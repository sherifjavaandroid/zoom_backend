<?php

namespace App\Http\Services;

use OpenAI;

class OpenAIService
{


    public function getClient()
    {
        $apiKey = env('OPENAI_API_KEY', "");
        $organization = env('OPENAI_ORGANIZATION', "");
        return OpenAI::client($apiKey, $organization);
    }

    public function chat($messages = [])
    {
        //loop throught the messages and convert role that is not user to role: assistant
        $messages = array_map(function ($message) {
            if ($message['role'] != 'user') {
                $message['role'] = 'assistant';
            }
            return $message;
        }, $messages);
        //
        $model = "gpt-3.5-turbo";
        $client = $this->getClient();
        $response = $client->chat()->create([
            'model' => $model,
            'messages' => $messages,
        ]);
        return $response->toArray();
    }

    public function imageGenerate($prompt, $number_of_images = null, $size = null, $response_format = null)
    {

        // $model = "dall-e-3";
        $model = "dall-e-2";
        $number_of_images = $number_of_images ?: 2;
        if ($model == "dall-e-3") {
            $number_of_images = 1;
        }
        $client = $this->getClient();
        $payload = [
            'model' => $model,
            'prompt' => $prompt,
            'n' => (int) $number_of_images,
            'size' => ((string) $size) ?: '256x256',
            'response_format' => $response_format ?: 'url',
        ];
        $response = $client->images()->create($payload);
        return $response->toArray();
    }
}