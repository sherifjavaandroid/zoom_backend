<?php

namespace App\Http\Livewire\Tables;

use App\Models\User;
use App\Models\Meeting;
use Illuminate\Support\Facades\DB;
use Kdion4891\LaravelLivewireTables\Column;

class UserTable extends BaseTableComponent
{

    public $model = User::class;
    public $header_view = 'components.buttons.new';

    public function query()
    {
        return User::query();
    }

    public function columns()
    {
        return [
            Column::make('ID')->searchable()->sortable(),
            Column::make('Name')->searchable()->sortable(),
            Column::make('Email')->searchable()->sortable(),
            Column::make('Phone')->searchable()->sortable(),
            Column::make('Role', 'role_name'),
            Column::make('Created At', 'formatted_date')->sortable()->sortUsing(function ($models, $sort_attribute, $sort_direction) {
                return $models->orderBy('created_at',  $sort_direction);
            }),
            Column::make('Actions')->view('components.buttons.user_actions'),
        ];
    }


    //
    public function deleteModel()
    {

        try {
            DB::beginTransaction();
            Meeting::where('user_id', $this->selectedModel->id)->delete();
            $this->selectedModel->delete();
            DB::commit();
            $this->showSuccessAlert("Deleted");
        } catch (\Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? "Failed");
        }
    }
}
