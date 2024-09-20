<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseLivewireComponent;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;


class RegisterLivewire extends BaseLivewireComponent
{
    public $name;
    public $email;
    public $phone;
    public $password;

    protected $messages = [
        "email.unique" => "Email already associated with any account",
        "phone.unique" => "Phone already associated with any account",
    ];

    public function register()
    {


        $this->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "phone" => "phone:" . setting('countryCode', "INTERNATIONAL") . "|unique:users",
            "password" => "required|string",
        ]);

        //
        try {

            $phone = new PhoneNumber($this->phone, setting('countryCode', "INTERNATIONAL"));
            $this->phone = $phone->formatE164();
            $this->phone = str_ireplace(" ", "", $this->phone);


            DB::beginTransaction();
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->password = Hash::make($this->password);
            $user->save();
            DB::commit();

            Auth::attempt(['email' => $this->email, 'password' => $this->password]);
            return redirect()->route($user->hasRole('admin') ? 'dashboard' : 'history');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? "An error occurred please try again later");
        }
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth');
    }
}