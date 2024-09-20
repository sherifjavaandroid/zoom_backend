<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseLivewireComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginLivewire extends BaseLivewireComponent
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        "email" => "required|email|exists:users",
        "password" => "required|string",
    ];

    protected $messages = [
        "email.exists" => "Email not associated with any account"
    ];

    public function login(){


        $this->validate();

        //
        $user = User::where('email', $this->email)->first();

        if(Hash::check( $this->password, $user->password ) && Auth::attempt(['email' => $this->email, 'password' => $this->password]) ){
            return redirect()->route( $user->hasRole('admin') ? 'dashboard': 'history');
        }else{
            $this->showErrorAlert("Invalid Credentials. Please check your credentials and try again");
        }

    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}
