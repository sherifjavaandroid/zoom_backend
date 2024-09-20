<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\User;
use App\Traits\FirebaseAuthTrait;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthController extends Controller
{
    use FirebaseAuthTrait;
    //
    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ],
            $messages = [
                'email.exists' => 'Email not associated with any account',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                "message" => $this->readalbeError($validator),
            ], 400);
        }

        //
        $user = User::where('email', $request->email)->first();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            //generate tokens
            return $this->authObject($user);
        } else {
            return response()->json([
                "message" => "Invalid credentials. Please change your password and try again"
            ], 401);
        }
    }

    //
    public function password_reset(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'phone' => "phone:" . setting('countryCode', "INTERNATIONAL") . "|exists:users,phone",
            ],
            $messages = [
                'phone.exists' => 'Phone not associated with any account',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                "message" => $this->readalbeError($validator),
            ], 400);
        }

        //verify firebase token
        try {

            //
            $phone = new PhoneNumber($request->phone, setting('countryCode', "INTERNATIONAL"));
            $phone = $phone->formatE164();
            $phone = str_ireplace(" ", "", $phone);


            $firebaseUser = $this->verifyFirebaseIDToken($request->firebase_id_token);
            //verify that the token belongs to the right user
            if ($firebaseUser->phoneNumber == $phone) {

                $user = User::where("phone", $phone)->firstorfail();
                $user->password = Hash::make($request->password);
                $user->Save();

                return response()->json([
                    "message" => "Account Password Updated Successfully",
                ], 200);
            } else {
                return response()->json([
                    "message" => "Password Reset Failed",
                ], 400);
            }
            return $firebaseUser;
        } catch (Exception $ex) {
            return response()->json([
                "message" => $ex->getMessage(),
            ], 400);
        }
    }

    //
    public function register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => "phone:" . setting('countryCode', "INTERNATIONAL") . "|unique:users",
                'password' => 'required',
            ],
            $messages = [
                'email.unique' => 'Email already associated with an account',
                'phone.unique' => 'Phone already associated with an account',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "message" => $this->readalbeError($validator),
            ], 400);
        }


        try {

            //
            $phone = new PhoneNumber($request->phone, setting('countryCode', "INTERNATIONAL"));
            $phone = $phone->formatE164();
            $phone = str_ireplace(" ", "", $phone);

            DB::beginTransaction();
            //
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $phone;
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            //generate tokens
            return $this->authObject($user);
        } catch (Exception $error) {

            DB::rollback();
            return response()->json([
                "message" => $error->getMessage()
            ], 500);
        }
    }

    //
    public function profileUpdate(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
                'phone' => 'sometimes|unique:users,phone,' . Auth::id(),
                'photo' => 'sometimes|nullable|image|max:2048',
            ],
            $messages = [
                'email.unique' => 'Email already associated with an account',
                'phone.unique' => 'Phone already associated with an account',
                'photo.max' => 'Photo must be equal or less to 2MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "message" => $this->readalbeError($validator),
            ], 400);
        }


        try {


            DB::beginTransaction();
            $user = User::find(Auth::id());
            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            //
            //phone format
            if ($request->phone != null) {
                $phone = new PhoneNumber($request->phone, setting('countryCode', "INTERNATIONAL"));
                $phone = $phone->formatE164();
                $phone = str_ireplace(" ", "", $phone);
                $user->phone = $phone;
            }
            //
            $user->save();

            if ($request->photo) {
                $user->clearMediaCollection();
                $user->addMedia($request->file('photo'))->toMediaCollection('profile');
            }

            DB::commit();
            //generate tokens
            return response()->json([
                "message" => "User profile updated successful",
                "user" => $user,
            ]);
        } catch (Exception $error) {

            DB::rollback();
            return response()->json([
                "message" => $error->getMessage()
            ], 500);
        }
    }

    //
    public function deleteProfile(Request $request)
    {

        try {


            DB::beginTransaction();
            //delete all meeting
            Meeting::where("user_id", Auth::id())->delete();
            User::where('id', Auth::id())->delete();
            DB::commit();
            //generate tokens
            return response()->json([
                "message" => "User profile delete successful",
            ]);
        } catch (Exception $error) {

            DB::rollback();
            return response()->json([
                "message" => $error->getMessage()
            ], 500);
        }
    }


    /**
     *
     * Helpers
     *
     */
    public function authObject($user)
    {
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            "token" => $token,
            "type" => "Bearer",
            "message" => "User login successful",
            "user" => $user,
        ]);
    }
}
