<?php

namespace App\Http\Livewire\Settings;

use Exception;
use App\Http\Livewire\BaseLivewireComponent;

class Meeting extends BaseLivewireComponent
{



    //Notification Settings
    public $mandatoryLogin;
    public $unauthorizedMeeting;
    public $meeting_prefix_id;
    public $jitsi_meeting_domain;


    public function render()
    {
        return view('livewire.settings.meeting');
    }

    public function mount()
    {
        $this->mandatoryLogin = setting('mandatoryLogin', '0') == "1" ? true : false;
        $this->unauthorizedMeeting = setting('unauthorizedMeeting', '1') == "1" ? true : false;
        $this->meeting_prefix_id = setting('meeting_prefix_id');
        $this->jitsi_meeting_domain = setting('jitsi_meeting_domain', 'jitsi.belnet.be');
    }

    public function generateMeetingPrefix()
    {
        $this->meeting_prefix_id = \Str::random(4) . "-";
    }



    public function saveMeetingSetting()
    {

        try {

            $this->isDemo();
            setting([
                'mandatoryLogin' =>  $this->mandatoryLogin,
                'unauthorizedMeeting' =>  $this->unauthorizedMeeting,
                'meeting_prefix_id' => $this->meeting_prefix_id,
                'jitsi_meeting_domain' => $this->jitsi_meeting_domain,
            ])->save();
            //
            $this->showSuccessAlert("Meeting Settings saved successfully!");
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Meeting Settings save failed!");
        }
    }
}
