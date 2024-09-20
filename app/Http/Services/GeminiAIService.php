<?php

namespace App\Http\Services;

use GeminiAPI\Laravel\Facades\Gemini;

class GeminiAIService
{




    public function chat($messages = [], $newMessage)
    {
        if ($messages == null  || !is_array($messages)) {
            $messages = [];
        }

        //loop throught the messages and convert role that is not user to role: model
        $messages = array_map(function ($message) {
            if ($message['role'] != 'user') {
                $message['role'] = 'model';
            }
            //also convert the content to message
            $message['message'] = $message['content'] ?? $message['message'];
            return $message;
        }, $messages);
        //pop the last message if its from role user
        if (count($messages) > 0 && $messages[count($messages) - 1]['role'] == 'user') {
            array_pop($messages);
        }
        //start the chat
        $chat = Gemini::startChat($messages);
        $responseText = $chat->sendMessage($newMessage);
        return [
            "choices" => [
                [
                    "message" => [
                        "role" => "assistant",
                        "content" => $responseText
                    ],
                ],
            ],
        ];
    }

    public function imageGenerate($prompt, $number_of_images = null, $size = null, $response_format = null)
    {
        //throw new \Exception("Not implemented yet");
        throw new \Exception(__("Image Generation is not supported yet. Please contact the admin."));
    }
}
