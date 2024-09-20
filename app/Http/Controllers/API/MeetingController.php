<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class MeetingController extends Controller
{

    //
    public function index(Request $request)
    {

        $meetings = Meeting::mine()->orderBy('id', "DESC")->paginate();
        return $meetings;
    }

    //
    public function publicMeeting(Request $request)
    {

        $meetings = Meeting::where('public', 1)->orderBy('id', "DESC")->paginate();
        return $meetings;
    }


    //
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                // 'title' => 'required|string',
                'id' => 'required|unique:meetings,meeting_id',
                'banner' => 'sometimes|nullable|image|max:4069',
            ],
            $messages = [
                'id.required' => 'Meeting ID is required',
                'title.required' => 'Meeting title is required',
                'banner.size' => 'Banner must be equal or less to 4MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "message" => $this->readalbeError($validator),
            ], 400);
        }


        try {

            //Login is mandatory for creating new meeting
            $mandatoryLogin = setting('mandatoryLogin', '0') == "1" ? true : false;
            if (Auth::guard('sanctum')->user() == null &&  $mandatoryLogin) {
                return response()->json([
                    "message" => "You need to be authenticated to create a meeting",
                ], 400);
            }

            $meeting = new Meeting();
            $meeting->meeting_id = $request->id;
            $meeting->meeting_title = $request->title ?? "Untitled";
            //if user is authenticated
            if (Auth::guard('sanctum')->user() != null) {
                $meeting->user_id = Auth::guard('sanctum')->user()->id;
                $meeting->public = $request->public ?? false;
            }
            //if user is not authenticated
            else {
                $meeting->public = true;
            }
            $meeting->save();

            if ($request->banner) {
                $meeting->clearMediaCollection();
                $meeting->addMedia($request->file('banner'))->toMediaCollection();
            }

            return response()->json([
                "message" => "Meeting created successful",
                "meeting" => $meeting,
            ]);
        } catch (Exception $error) {
            return response()->json([
                "message" => $error->getMessage()
            ], 400);
        }
    }

    //
    public function join(Request $request, $id)
    {

        try {

            $meeting =  Meeting::where("meeting_id", $id)->first();
            $mandatoryLogin = setting('mandatoryLogin', '0') == "1" ? true : false;
            $unauthorizedMeeting = setting('unauthorizedMeeting', '1') == "1" ? true : false;

            //in app meeting is mandatory to join
            if (empty($meeting) && !$unauthorizedMeeting) {
                return response()->json([
                    "message" => "No meeting found with associated meeting id",
                ], 400);
            } else if (Auth::guard('sanctum')->user() == null &&  $mandatoryLogin) {
                return response()->json([
                    "message" => "You need to be authenticated to join a meeting",
                ], 400);
            }

            //
            if (empty($meeting)) {
                $meeting = new Meeting();
                $meeting->meeting_id = $id;
                $meeting->meeting_title = "Meeting-" . $id;
                $meeting->public = true;
                $meeting->save();
            }


            return response()->json([
                "message" => "Meeting join successful",
                "meeting" => $meeting,
            ]);
        } catch (ModelNotFoundException $error) {
            logger("Join meeting ModelNotFoundException error", [$error]);
            return response()->json([
                "message" => "There is no meeting with the provided data"
            ], 400);
        } catch (Exception $error) {
            logger("Join meeting Exception error", [$error]);
            return response()->json([
                "message" => $error->getMessage()
            ], 400);
        }
    }

    //
    public function update(Request $request, $id)
    {

        //
        try {

            $meeting = Meeting::where([
                "user_id" => Auth::id(),
                "id" => $id,
            ])->firstorfail();

            //validation
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'sometimes|string',
                    'id' => 'sometimes|unique:meetings,meeting_id',
                    'banner' => 'sometimes|nullable|image|max:4069',
                ],
                $messages = [
                    'banner.max' => 'Banner must be equal or less to 4MB',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    "message" => $this->readalbeError($validator),
                ], 400);
            }


            $meeting->meeting_id = $request->id ?? $meeting->meeting_id;
            $meeting->meeting_title = $request->title ?? $meeting->meeting_title;
            $meeting->public = $request->public ?? false;
            $meeting->save();

            if ($request->banner) {
                $meeting->clearMediaCollection();
                $meeting->addMedia($request->file('banner'))->toMediaCollection();
            }

            return response()->json([
                "message" => "Meeting updated successful",
                "meeting" => $meeting,
            ]);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                "message" => "There is no meeting with the provided data"
            ], 400);
        } catch (Exception $error) {
            return response()->json([
                "message" => $error->getMessage()
            ], 400);
        }
    }

    //
    public function destroy(Request $request, $id)
    {

        //
        try {

            $meeting = Meeting::where([
                "user_id" => Auth::id(),
                "id" => $id,
            ])->firstorfail();


            //delete
            $meeting->delete();

            return response()->json([
                "message" => "Meeting deleted successful",
            ]);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                "message" => "There is no meeting with the provided data"
            ], 400);
        } catch (Exception $error) {
            return response()->json([
                "message" => $error->getMessage()
            ], 400);
        }
    }
}
