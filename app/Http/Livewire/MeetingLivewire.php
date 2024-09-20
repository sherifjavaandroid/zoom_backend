<?php

namespace App\Http\Livewire;

use App\Models\Meeting;
use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MeetingLivewire extends Component
{

    public $meetingId;
    public $errorMessage;

    public function mount($code)
    {
        $this->meetingId = $code;
    }

    public function render()
    {
        return view('livewire.meeting')->layout('layouts.auth');
    }


    public function loadMeeting()
    {
        try {

            $meeting =  Meeting::where("meeting_id", $this->meetingId)->first();
            $mandatoryLogin = setting('mandatoryLogin', '0') == "1" ? true : false;
            $unauthorizedMeeting = setting('unauthorizedMeeting', '1') == "1" ? true : false;

            //in app meeting is mandatory to join
            if (empty($meeting) && !$unauthorizedMeeting) {
                $this->errorMessage = "No meeting found with associated meeting id";
            } else if (Auth::user() == null &&  $mandatoryLogin) {
                $this->errorMessage = "You need to be authenticated to join a meeting";
            } else {
                $meetingTitle = $meeting->meeting_title ?? "Untitled";
                $isMine = Auth::user() != null && $meeting->user_id == Auth::id();
                $bgColor = setting('websiteColor', '#20063c');
                $displayName = auth()->user()->name ?? ("Anonymous-" . \Str::random(2));
                $myId = auth()->user()->id ?? ("A" . \Str::random(4));
                $meetingDomain = setting('jitsi_meeting_domain', 'jitsi.belnet.be');
                //
                $this->emit(
                    'startMeeting',
                    $meetingDomain,
                    $this->meetingId,
                    $meetingTitle,
                    $displayName,
                    $myId,
                    $isMine,
                    $bgColor,
                );
            }
        } catch (Exception $error) {
            logger($error);
            $this->errorMessage = $error->getMessage() ?? "";
        }
    }
}