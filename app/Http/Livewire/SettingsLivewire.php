<?php

namespace App\Http\Livewire;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class SettingsLivewire extends BaseLivewireComponent
{

    // public $showNotification = false;
    // public $showApp = false;
    // public $showMeeting = false;
    // public $showPrivacy = false;
    // public $showAndroidAdmob = false;
    // public $showiOSAdmob = false;

    // //Notification Settings
    // public $fcmServerKey;
    // public $fcmSenderID;
    // public $fcmAPIKey;

    // // App settings
    // public $websiteName;
    // public $websiteColor;
    // public $countryCode;
    // public $websiteLogo;
    // public $oldWebsiteLogo;
    // public $favicon;
    // public $oldFavicon;
    // public $loginImage;
    // public $oldLoginImage;
    // public $registerImage;
    // public $oldRegisterImage;
    // public $aiChatbot;
    // public $aiImageGenerator;
    // public $openAIKey;

    // //Meeting Settings
    // public $mandatoryLogin;
    // public $unauthorizedMeeting;

    // //Privacy Settings
    // public $privacyPolicy;

    // //Admob Settings
    // public $app_id;
    // public $banner_ad_id;
    // public $interstitial_ad_id;
    // public $ad_enable;

    // public $adMobRules = [
    //     "app_id" => "required",
    //     "banner_ad_id" => "required",
    // ];

    // protected $listeners = [
    //     'deleteModel',
    //     'refreshTable' => '$refresh',
    // ];


    public function render()
    {
        return view('livewire.settings.index');
    }

    /*
    //Notification settings
    public function notificationSetting()
    {
        $this->fcmServerKey = setting('fcmServerKey', 'XXXXXXXXXXXX');
        $this->fcmSenderID = setting('fcmSenderID', 'XXXXXXXXXXXX');
        $this->fcmAPIKey = setting('fcmAPIKey', 'XXXXXXXXXXXX');
        $this->showNotification = true;
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


            $this->showSuccessAlert("Settings saved successfully!");
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Settings save failed!");
        }
    }

    //App settings
    public function appSettings()
    {
        $this->websiteName = setting('websiteName', env("APP_NAME"));
        $this->websiteColor = setting('websiteColor', '#20063c');
        $this->countryCode = setting('countryCode');
        $this->oldWebsiteLogo = setting('websiteLogo', asset('images/logo.png'));
        $this->oldFavicon = setting('favicon', asset('images/logo.png'));
        $this->oldLoginImage = setting('loginImage', asset('images/login.jpeg'));
        $this->oldRegisterImage = setting('registerImage', asset('images/register.jpg'));
        $this->aiChatbot = (bool) setting('aiChatbot', '0');
        $this->aiImageGenerator = (bool) setting('aiImageGenerator', '0');
        // $this->openAIKey = setting('openAIKey', '');
        $this->openAIKey = "XXXXXXXXXXXX";
        $this->showApp = true;
    }

    public function saveAppSettings()
    {

        $this->validate([
            "websiteLogo" => "sometimes|nullable|image|max:1024",
            "favicon" => "sometimes|nullable|image|mimes:png|max:48",
            "loginImage" => "sometimes|nullable|image|max:3072",
            "registerImage" => "sometimes|nullable|image|max:3072",
        ]);

        try {

            $this->isDemo();
            // store new logo
            if ($this->websiteLogo) {
                $this->oldWebsiteLogo = Storage::url($this->websiteLogo->store('public/logos'));
            }

            // store new logo
            if ($this->favicon) {
                $this->oldFavicon = Storage::url($this->favicon->store('public/favicons'));
            }

            // store new logo
            if ($this->loginImage) {
                $this->oldLoginImage = Storage::url($this->loginImage->store('public/auth/login'));
            }

            // store new logo
            if ($this->registerImage) {
                $this->oldRegisterImage = Storage::url($this->registerImage->store('public/auth/register'));
            }


            $appSettings = [
                'websiteName' =>  $this->websiteName,
                'websiteColor' =>  $this->websiteColor,
                'countryCode' =>  $this->countryCode ?? "AUTO",
                'websiteLogo' =>  $this->oldWebsiteLogo,
                'favicon' =>  $this->oldFavicon,
                'loginImage' =>  $this->oldLoginImage,
                'registerImage' =>  $this->oldRegisterImage,
                // ai settings
                'aiChatbot' =>  $this->aiChatbot ?? false,
                'aiImageGenerator' =>  $this->aiImageGenerator ?? false,
                'openAIKey' => ($this->openAIKey == "XXXXXXXXXXXX") ? setting('openAIKey', 'XXXXXXXXXXXX') : $this->openAIKey,
            ];

            // update the site name
            setting($appSettings)->save();



            $this->showSuccessAlert("App Settings saved successfully!");
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "App Settings save failed!");
        }
    }


    //Meeeting settings
    public function meetingSettings()
    {
        $this->mandatoryLogin = setting('mandatoryLogin', '0') == "1" ? true : false;
        $this->unauthorizedMeeting = setting('unauthorizedMeeting', '1') == "1" ? true : false;
        $this->showMeeting = true;
    }

    public function saveMeetingSetting()
    {

        try {

            $this->isDemo();
            setting([
                'mandatoryLogin' =>  $this->mandatoryLogin,
                'unauthorizedMeeting' =>  $this->unauthorizedMeeting,
            ])->save();

            $this->showSuccessAlert("Meeting Settings saved successfully!");
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Meeting Settings save failed!");
        }
    }


    //Meeeting settings
    public function privacySettings()
    {
        $this->privacyPolicy = setting('privacyPolicy', "");
        $this->showPrivacy = true;
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
            // $this->showErrorAlert( $error->getMessage() ?? "Privacy Policy Settings save failed!");
            $this->showErrorAlert("Privacy Policy ===> " . $this->privacyPolicy . "");
        }
    }






    //Adroid Admob settings
    public function androidAdmob()
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
        $this->showAndroidAdmob = true;
    }

    public function saveAndroidAdmob()
    {


        if ($this->isDemo()) {
            $this->showErrorAlert("Not allowed in demo");
            return;
        }

        $this->validate($this->adMobRules);

        try {


            $admobJson = [
                "app_id" => $this->app_id,
                "banner_ad_id" => $this->banner_ad_id,
                "interstitial_ad_id" => $this->interstitial_ad_id,
                "ad_enable" => $this->ad_enable,
            ];


            setting([
                'android_admob' =>  json_encode($admobJson),
            ])->save();

            $this->showSuccessAlert("Android Admob settings saved successfully!");
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Android Admob settings save failed!");
        }
    }

    //iOS Admob settings
    public function iosAdmob()
    {
        $admobJson = setting('ios_admob', "");
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

        $this->showiOSAdmob = true;
    }

    public function saveIosAdmob()
    {

        if ($this->isDemo()) {
            $this->showErrorAlert("Not allowed in demo");
            return;
        }

        $this->validate($this->adMobRules);

        try {



            $admobJson = [
                "app_id" => $this->app_id,
                "banner_ad_id" => $this->banner_ad_id,
                "interstitial_ad_id" => $this->interstitial_ad_id,
                "ad_enable" => $this->ad_enable,
            ];


            setting([
                'ios_admob' =>  json_encode($admobJson),
            ])->save();

            $this->showSuccessAlert("iOS Admob settings saved successfully!");
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "iOS Admob settings save failed!");
        }
    }
    */
}
