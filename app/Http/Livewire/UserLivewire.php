<?php

namespace App\Http\Livewire;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Propaganistas\LaravelPhone\PhoneNumber;

class UserLivewire extends BaseLivewireComponent
{

    //
    public $model = User::class;

    //
    public $name;
    public $email;
    public $phone;
    public $password;
    public $role;

    protected $rules = [
        "name" => "required|string",
        "email" => "required|email|unique:users",
        "phone" => "required|phone:INTERNATIONAL,US|unique:users",
        "password" => "sometimes|nullable|string",
    ];


    protected $messages = [
        "email.unique" => "Email already associated with any account"
    ];

    public function render()
    {
        return view('livewire.users', [
            "roles" => Role::all()->map(function ($role) {
                return [
                    "id" => $role->name,
                    "name" => $role->name,
                ];
            }),
        ]);
    }

    public function save()
    {
        $phoneRule = setting('countryCode', "INTERNATIONAL");
        $mRules = $this->rules;
        $mRules['phone'] = "required|phone:$phoneRule|unique:users";
        //validate
        $this->validate();

        try {

            //clean up provided phone number
            $phone = new PhoneNumber($this->phone, $phoneRule);
            $phone = $phone->formatE164();
            $phone = str_ireplace(" ", "", $phone);


            DB::beginTransaction();
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $phone;
            $user->password = Hash::make($this->password);
            $user->save();

            if (!empty($this->role)) {
                $user->assignRole($this->role);
            }

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert("User created successfully!");
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? "User creation failed!");
        }
    }

    public function initiateEdit($id)
    {
        $this->selectedModel = $this->model::find($id);
        $this->name = $this->selectedModel->name;
        $this->email = $this->selectedModel->email;
        $this->phone = $this->selectedModel->phone;
        $this->role = $this->selectedModel->role_name;
        if ($this->phone != null) {
            $this->emit('initPhone', json_encode(["phoneEdit", "phone", $this->phone]));
        }
        $this->emit('showEditModal');
    }

    public function update()
    {
        //validate
        $phoneRule = setting('countryCode', "INTERNATIONAL");
        $this->validate(
            [
                "name" => "required|string",
                "email" => "required|email|unique:users,email," . $this->selectedModel->id . "",
                "phone" => "required|phone:$phoneRule|unique:users,phone," . $this->selectedModel->id . "",
                "password" => "sometimes|nullable|string",
            ]
        );

        try {

            //clean up provided phone number
            $phone = new PhoneNumber($this->phone, $phoneRule);
            $phone = $phone->formatE164();
            $phone = str_ireplace(" ", "", $phone);

            //
            DB::beginTransaction();
            $user = $this->selectedModel;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $phone;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->save();

            if (!empty($this->role)) {
                $user->syncRoles($this->role);
            }

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert("User created successfully!");
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? "User creation failed!");
        }
    }
}
