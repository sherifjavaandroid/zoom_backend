<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseLivewireComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\Meeting;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeLivewire extends BaseLivewireComponent
{
    public $meetingid;
    public $newMeetingid;
    public $meetingTitle;

    protected $rules = [
        "meetingid" => "required|string",
    ];

    protected $newMeetingRules = [
        "newMeetingid" => "required|string|unique:meetings,meeting_id",
    ];


    public function join(){

        $this->validate();

        return redirect()->route('meeting.join', ["code" => $this->meetingid]);

    }

    public function host(){

        $this->validate( $this->newMeetingRules );

        try{

            //
            //Login is mandatory for creating new meeting
            $mandatoryLogin = setting('mandatoryLogin', '0') == "1" ? true : false;
            if( Auth::guard('web')->user() == null &&  $mandatoryLogin ){
                throw new Exception("You need to be authenticated to create a meeting");
            }

            DB::beginTransaction();
            $meeting = new Meeting();
            $meeting->meeting_title = $this->meetingTitle ?? 'Untitled';
            $meeting->meeting_id = $this->newMeetingid;
            $meeting->public = 1;
            $meeting->save();
            DB::commit();
            return redirect()->route('meeting.join', ["code" => $this->newMeetingid]);

        }catch(Exception $error){
            DB::rollback();
            $this->showErrorAlert( $error->getMessage() ?? "Meeting creation failed!");
        }


    }

    public function generateMeetingID(){
        $this->newMeetingid = Str::random(10);
    }


    public function mount(){
        $this->generateMeetingID();
    }
    public function render()
    {

        return view('livewire.home')->layout('layouts.auth');
    }
}
