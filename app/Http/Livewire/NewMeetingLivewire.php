<?php

namespace App\Http\Livewire;

use App\Models\Meeting;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewMeetingLivewire extends BaseLivewireComponent
{

    //
    public $model = Meeting::class;

    //
    public $meetingTitle;
    public $meetingID;
    public $meetingPulbic;

    protected $rules = [
        "meetingID" => "required|string|min:6|unique:meetings,meeting_id",
        "meetingTitle" => "required|string",
    ];

    protected $messages = [
        "meetingID.unique" => "Meeting ID already exists",
    ];


    public function render()
    {
        return view('livewire.meeting_new');
    }

    public function save()
    {
        //validate
        $this->validate();

        try {

            DB::beginTransaction();
            $meeting = new Meeting();
            $meeting->meeting_title = $this->meetingTitle;
            $meeting->meeting_id = setting('meeting_prefix_id') . "" . $this->meetingID;
            $meeting->user_id = Auth::id();
            $meeting->public = $this->meetingPulbic ?? 0;
            $meeting->save();

            if ($this->photo) {
                $meeting->addMedia($this->photo->getRealPath())->toMediaCollection();
            }

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert("Meeting created successfully!");
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? "Meeting creation failed!");
        }
    }
}
