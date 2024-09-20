<?php

namespace App\Http\Livewire\Settings;

use Exception;
use App\Http\Livewire\BaseLivewireComponent;

class Admob extends BaseLivewireComponent
{



    //Notification Settings
    public $app_id;
    public $banner_ad_id;
    public $interstitial_ad_id;
    public $ad_enable;

    //ios admob variables
    public $ios_app_id;
    public $ios_banner_ad_id;
    public $ios_interstitial_ad_id;
    public $ios_ad_enable;


    public $rules = [
        //required if ad_enable is true or 1
        "app_id" => "required_if:ad_enable,1",
        "banner_ad_id" => "required_if:ad_enable,1",
        //ios
        "ios_app_id" => "required_if:ios_ad_enable,1",
        "ios_banner_ad_id" => "required_if:ios_ad_enable,1",
    ];

    public function mount()
    {
        $admobJson = setting('android_admob', "");
        if (!empty($admobJson)) {
            $admobJson = json_decode($admobJson);
            $this->app_id = $admobJson->app_id;
            $this->banner_ad_id = $admobJson->banner_ad_id;
            $this->interstitial_ad_id = $admobJson->interstitial_ad_id;
            $this->ad_enable = $admobJson->ad_enable;
        } else {
            $this->app_id = null;
            $this->banner_ad_id = null;
            $this->interstitial_ad_id = null;
            $this->ad_enable = null;
        }
        //
        $admobiOSJson = setting('ios_admob', "");
        if (!empty($admobJson)) {
            $admobiOSJson = json_decode($admobiOSJson);
            $this->ios_app_id = $admobiOSJson->app_id;
            $this->ios_banner_ad_id = $admobiOSJson->banner_ad_id;
            $this->ios_interstitial_ad_id = $admobiOSJson->interstitial_ad_id;
            $this->ios_ad_enable = $admobiOSJson->ad_enable;
        } else {
            $this->ios_app_id = null;
            $this->ios_banner_ad_id = null;
            $this->ios_interstitial_ad_id = null;
            $this->ios_ad_enable = null;
        }
    }

    public function render()
    {
        return view('livewire.settings.admob');
    }


    public function save()
    {
        $this->validate();

        try {

            //android
            $admobJson = [
                "app_id" => $this->app_id,
                "banner_ad_id" => $this->banner_ad_id,
                "interstitial_ad_id" => $this->interstitial_ad_id,
                "ad_enable" => $this->ad_enable,
            ];


            setting([
                'android_admob' =>  json_encode($admobJson),
            ])->save();

            //
            $admobJson = [
                "app_id" => $this->ios_app_id,
                "banner_ad_id" => $this->ios_banner_ad_id,
                "interstitial_ad_id" => $this->ios_interstitial_ad_id,
                "ad_enable" => $this->ios_ad_enable,
            ];


            setting([
                'ios_admob' =>  json_encode($admobJson),
            ])->save();


            $this->showSuccessAlert("Settings saved successfully!");
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Settings save failed!");
        }
    }
}
