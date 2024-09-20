<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordLivewire extends Component
{

    public $phone;
    public $setPassword = false;
    public $otp;
    public $idToken;
    public $password;
    public $password_confirmation;
    protected $listeners = ['allowReset' => 'showResetForm'];

    protected $rules = [
        "phone" => "phone:INTERNATIONAL,US|exists:users"
    ];

    protected $messages = [
        "phone.exists" => "No account associated with phone"
    ];

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.auth');
    }

    public function initiateFireabse()
    {
        $this->emit('initiateFirebaseAuth', setting('fcmAPIKey', ''));
    }

    public function resetPassword()
    {

        $phoneRule = setting('countryCode', "INTERNATIONAL");
        $this->validate([
            "phone" => "required|phone:$phoneRule|exists:users"
        ]);
        $this->emit('sendOTP', $this->phone);
    }








    //
    public function verifyOTP()
    {

        $this->validate([
            "otp" => "required|size:6"
        ]);
        $this->emit('verifyFirebaseAuth', $this->otp);
    }


    public function showResetForm($idToken)
    {
        $this->idToken = $idToken;
        $this->setPassword = true;
    }

    public function saveNewPassword()
    {

        $this->validate([
            "password" => 'required|min:6',
            "password_confirmation" => 'required|same:password|min:6',
        ]);

        //
        if (!empty($this->idToken)) {
            $user = User::where('phone', $this->phone)->first();
            $user->password = Hash::make($this->password);
            $user->Save();

            //
            $this->phone = "";
            $this->setPassword = false;
            $this->alert('success', "", [
                'position'  =>  'center',
                'text' => "Account password updated. You can now login with the newly created account password",
                'toast'  =>  false,
            ]);
        }
    }
}
