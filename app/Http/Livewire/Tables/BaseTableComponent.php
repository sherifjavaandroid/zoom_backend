<?php

namespace App\Http\Livewire\Tables;

use Exception;
use Kdion4891\LaravelLivewireTables\TableComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BaseTableComponent extends TableComponent
{
    use LivewireAlert;


    protected $listeners = [
        'deleteModel',
        'refreshTable' => '$refresh',
    ];

    //
    public function thClass($attribute)
    {
        return 'p-2';
    }

    public function tdClass($attribute, $value)
    {
        return 'p-2';
    }

    public function trClass($model)
    {
        return 'border-b';
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
    //End Alert



    public $selectedModel;
    public $model;

    public function initiateDelete($id)
    {
        $this->selectedModel = $this->model::find($id);

        $this->confirm('Delete', [
            'icon' => "question",
            'toast' => false,
            'text' =>  'Are you sure you want to delete the selected data?',
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => "Cancel",
            'onConfirmed' => 'deleteModel',
            'onCancelled' => 'cancelled'
        ]);
    }


    public function deleteModel()
    {

        try {
            $this->selectedModel->delete();
            $this->showSuccessAlert("Deleted");
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Failed");
        }
    }
}
