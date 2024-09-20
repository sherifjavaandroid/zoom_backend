<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\App;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BaseLivewireComponent extends Component
{
    use WithPagination, WithFileUploads;
    use LivewireAlert;

    public $perPage = 6;
    public $showPassword = false;
    public $model;
    public $selectedModel;
    public $photoInfo;
    public $photo;

    protected $listeners = [
        'showCreateModal' => 'showCreateModal',
        'showEditModal' => 'showEditModal',
        'initiateEdit' => 'initiateEdit',
        'dismissModal' => 'dismissModal',
        'refreshView' => '$refresh'
    ];

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    //Alert
    public function showSuccessAlert($message = "")
    {
        $this->alert('success', "", [
            'position'  =>  'center',
            'text' => $message,
            'toast'  =>  false,
        ]);
    }

    public function showWarningAlert($message = "")
    {
        $this->alert('warning', "", [
            'position'  =>  'center',
            'text' => $message,
            'toast'  =>  false,
        ]);
    }

    public function showErrorAlert($message = "")
    {
        $this->alert('error', "", [
            'position'  =>  'center',
            'text' => $message,
            'toast'  =>  false,
        ]);
    }


    // Modal management
    public $showCreate = false;
    public $showEdit = false;
    public function showCreateModal()
    {
        $this->showCreate = true;
    }

    public function showEditModal()
    {
        $this->showEdit = true;
    }

    public function dismissModal()
    {
        $this->showCreate = false;
        $this->showEdit = false;
        $this->reset();
    }


    //
    public function updatedPhoto()
    {

        $file = array();

        if ($this->photo != null) {
            $filePath = pathinfo($this->photo->getRealPath());
            $file['name'] = $filePath['filename'];
            $file['extension'] = $filePath['extension'];
            //convert size to MB
            $file['size'] = number_format(filesize($filePath['dirname'] . '/' . $filePath['basename']) * 0.000001, 2);
        }

        $this->photoInfo = $file;
    }


    public function isDemo()
    {

        if (!App::environment('production')) {
            throw new \Exception("Changes can't be made in demo", 1);
        }

        return false;
    }
}
