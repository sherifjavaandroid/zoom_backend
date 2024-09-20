<?php

namespace App\Http\Livewire\Settings;

use Exception;
use App\Http\Livewire\BaseLivewireComponent;

class Firebase extends BaseLivewireComponent
{

    //Notification Settings
    public $fcmServerKey;
    public $fcmSenderID;
    public $fcmAPIKey;


    public function render()
    {
        return view('livewire.settings.firebase');
    }


    public function mount()
    {
        $this->fcmServerKey = setting('fcmServerKey', 'XXXXXXXXXXXX');
        $this->fcmSenderID = setting('fcmSenderID', 'XXXXXXXXXXXX');
        $this->fcmAPIKey = setting('fcmAPIKey', 'XXXXXXXXXXXX');
    }

    public function saveNotificationSetting()
    {

        try {

            //
            if ($this->photo) {
                $serviceKeyPath = $this->photo->storeAs('vault', 'firebase_service.json');
            }

            setting([
                'fcmServerKey' =>  $this->fcmServerKey,
                'fcmSenderID' =>  $this->fcmSenderID,
                'fcmAPIKey' =>  $this->fcmAPIKey,
                'serviceKeyPath' =>  $serviceKeyPath ?? "",
            ])->save();


            $this->photo = null;
            $this->showSuccessAlert("Settings saved successfully!");
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Settings save failed!");
        }
    }
}
