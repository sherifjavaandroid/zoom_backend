<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\GeminiAIService;
use App\Http\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AIGeneratorController extends Controller
{

    public function chat(Request $request)
    {
        /**
         * messages
         */
        $validator = Validator::make($request->all(), [
            'messages' => 'sometimes|array',
        ]);

        //failed
        if ($validator->fails()) {
            return response()->json([
                'message' => $this->readalbeError($validator)
            ], 400);
        }
        //ai system enabled
        if (isGeminiEnabled()) {
            $geminiAIService = new GeminiAIService();
            $response = $geminiAIService->chat(
                $request->messages,
                $request->message,
            );
        } else {
            $openAIService = new OpenAIService();
            $response = $openAIService->chat($request->messages);
        }
        return response()->json($response);
    }

    public function imageGenerate(Request $request)
    {
        /**
         * prompt
            number_of_images
            size
            response_format
         */
        $validator = Validator::make($request->all(), [
            'prompt' => 'required',
        ]);

        //failed
        if ($validator->fails()) {
            return response()->json([
                'message' => $this->readalbeError($validator)
            ], 400);
        }

        try {
            if (isGeminiEnabled()) {
                $geminiAIService = new GeminiAIService();
                $response = $geminiAIService->imageGenerate(
                    $request->prompt,
                    $request->number_of_images,
                    $request->size,
                    $request->response_format
                );
            } else {
                $openAIService = new OpenAIService();
                $response = $openAIService->imageGenerate(
                    $request->prompt,
                    $request->number_of_images,
                    $request->size,
                    $request->response_format
                );
            }
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
