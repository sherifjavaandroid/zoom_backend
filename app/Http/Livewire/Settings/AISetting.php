<?php

namespace App\Http\Livewire\Settings;

use Exception;
use App\Http\Livewire\BaseLivewireComponent;

class Aisetting extends BaseLivewireComponent
{


    public $aiChatbot;
    public $aiImageGenerator;
    public $aiLoginRequired;
    public $preferredAISystem;
    public $aiSystems = [
        // openapi
        [
            'name' => 'OpenAI',
            'id' => 'openai',

        ],
        // google gemini
        [
            'name' => 'Google Gemini',
            'id' => 'gemini',
        ],
    ];

    public $openAIKey;
    public $openAIOrganization;
    //google gemini keys
    public $googleGeminiAPIKey;

    //validation rules
    protected $rules = [
        'preferredAISystem' => 'required|string',
        'openAIKey' => 'required_if:preferredAISystem,openai|string',
        'openAIOrganization' => 'nullable|string',
        'googleGeminiAPIKey' => 'required_if:preferredAISystem,gemini|string',
    ];

    //messages
    protected $messages = [
        'preferredAISystem.required' => 'Please select a preferred AI System',
        'openAIKey.required_if' => 'OpenAI API Key is required',
        'googleGeminiAPIKey.required_if' => 'Google Gemini API Key is required',
    ];



    public function render()
    {
        return view('livewire.settings.aisetting');
    }


    public function mount()
    {
        $this->aiChatbot = (bool) setting('aiChatbot', '0');
        $this->aiImageGenerator = (bool) setting('aiImageGenerator', '0');
        $this->aiLoginRequired = (bool) setting('aiLoginRequired', '0');
        $this->preferredAISystem = setting('preferredAISystem', 'openai');
        $this->googleGeminiAPIKey = env('GEMINI_API_KEY', '');
        $this->openAIOrganization = env('OPENAI_ORGANIZATION', '');
        $this->openAIKey = env('OPENAI_API_KEY', '');
    }

    public function saveAppSettings()
    {
        try {
            $this->isDemo();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "App Settings save failed!");
            return;
        }


        $this->validate();
        try {
            //validate the form
            // ai settings
            $appSettings = [
                'aiChatbot' =>  $this->aiChatbot ?? false,
                'aiImageGenerator' =>  $this->aiImageGenerator ?? false,
                'aiLoginRequired' =>  $this->aiLoginRequired ?? false,
                'preferredAISystem' =>  $this->preferredAISystem ?? 'openai',
            ];
            // update the site name
            setting($appSettings)->save();
            //set ENV
            setEnv('GEMINI_API_KEY', $this->googleGeminiAPIKey);
            setEnv('OPENAI_ORGANIZATION', $this->openAIOrganization);
            setEnv('OPENAI_API_KEY', $this->openAIKey);
            $this->showSuccessAlert("App Settings saved successfully!");
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "App Settings save failed!");
        }
    }
}
