<?php

namespace App\Http\Livewire\Settings;

use Exception;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\BaseLivewireComponent;

class General extends BaseLivewireComponent
{


    public $websiteName;
    public $websiteColor;
    public $countryCode;
    public $websiteLogo;
    public $oldWebsiteLogo;
    public $favicon;
    public $oldFavicon;
    public $loginImage;
    public $oldLoginImage;
    public $registerImage;
    public $oldRegisterImage;
    public $aiChatbot;
    public $aiImageGenerator;
    public $openAIKey;



    public function render()
    {
        return view('livewire.settings.general');
    }


    public function mount()
    {
        $this->websiteName = setting('websiteName', env("APP_NAME"));
        $this->websiteColor = setting('websiteColor', '#20063c');
        $this->countryCode = setting('countryCode', 'INTERNATIONAL');
        $this->oldWebsiteLogo = setting('websiteLogo', asset('images/logo.png'));
        $this->oldFavicon = setting('favicon', asset('images/logo.png'));
        $this->oldLoginImage = setting('loginImage', asset('images/login.jpeg'));
        $this->oldRegisterImage = setting('registerImage', asset('images/register.jpg'));
        $this->aiChatbot = (bool) setting('aiChatbot', '0');
        $this->aiImageGenerator = (bool) setting('aiImageGenerator', '0');
        // $this->openAIKey = setting('openAIKey', '');
        $this->openAIKey = "XXXXXXXXXXXX";
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
                'countryCode' =>  $this->countryCode ?? "INTERNATIONAL",
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
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "App Settings save failed!");
        }
    }
}
