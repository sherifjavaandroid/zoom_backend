<?php

namespace App\Http\Livewire;

use Exception;

class PrivacySettingsLivewire extends BaseLivewireComponent
{

    //Privacy Settings
    public $privacyPolicy;

    public function render()
    {
        return view('livewire.settings.privacy-policy');
    }

    //Meeeting settings
    public function privacySettings()
    {
        $this->privacyPolicy = setting('privacyPolicy', "");
        $this->dispatchBrowserEvent('privacyPolicyChange', ["value" => $this->privacyPolicy]);
    }

    public function savePrivacyPolicy()
    {

        try {

            $this->isDemo();
            setting([
                'privacyPolicy' =>  $this->privacyPolicy,
            ])->save();

            $this->showSuccessAlert("Privacy Policy Settings saved successfully!");
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Privacy Policy Settings save failed!");
        }
    }
}
