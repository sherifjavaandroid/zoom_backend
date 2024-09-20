<?php

namespace App\Http\Livewire;

use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HistoryLivewire extends BaseLivewireComponent
{

    public $model = Meeting::class;

    //
    public $meetingTitle;
    public $meetingID;
    public $meetingPulbic;

    public function render()
    {
        return view('livewire.history');
    }

    //
    public function initiateEdit($id){
        $this->selectedModel = $this->model::find($id);
        $this->meetingTitle = $this->selectedModel->meeting_title;
        $this->meetingID = $this->selectedModel->meeting_id;
        $this->meetingPulbic = $this->selectedModel->public ?? 0;
        $this->photo = null;
        $this->emit('showEditModal');
    }


    public function update(){
        //validate
        $this->validate(
            [
                "meetingTitle" => "required|string",
                "meetingID" => "required|string|min:6|unique:meetings,meeting_id,".$this->selectedModel->id."",
            ]
        );

        try{

            DB::beginTransaction();
            $meeting = $this->selectedModel;
            $meeting->meeting_title = $this->meetingTitle;
            $meeting->meeting_id = $this->meetingID;
            $meeting->user_id = Auth::id();
            $meeting->public = $this->meetingPulbic ?? 0;
            $meeting->save();

            if( $this->photo ){
                $meeting->clearMediaCollection();
                $meeting->addMedia( $this->photo->getRealPath() )->toMediaCollection();
            }

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert("Meeting created successfully!");
            $this->emit('refreshTable');


        }catch(Exception $error){
            DB::rollback();
            $this->showErrorAlert( $error->getMessage() ?? "Meeting creation failed!");

        }

    }
}
