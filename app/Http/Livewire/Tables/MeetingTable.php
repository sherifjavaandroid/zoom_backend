<?php

namespace App\Http\Livewire\Tables;

use App\Models\Meeting;
use Kdion4891\LaravelLivewireTables\Column;

class MeetingTable extends BaseTableComponent
{

    public $model = Meeting::class;
    public $header_view = 'components.buttons.new';


    public function query()
    {
        return Meeting::query();
    }

    public function columns()
    {
        return [
            Column::make('ID')->searchable()->sortable(),
            Column::make('Banner')->view('components.meeting.banner'),
            Column::make('Meeting Title')->searchable()->sortable(),
            Column::make('Meeting ID')->searchable()->sortable(),
            Column::make('Type')->view('components.meeting.public'),
            Column::make('Created By', 'creator'),
            Column::make('Created At', 'formatted_date')->searchable()->sortable(),
            Column::make('Actions')->view('components.buttons.meeting_actions'),
        ];
    }
}
