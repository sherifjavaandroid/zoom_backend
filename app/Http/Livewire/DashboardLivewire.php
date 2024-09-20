<?php

namespace App\Http\Livewire;

use App\Models\Meeting;
use App\Models\User;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Carbon\Carbon;
use Livewire\Component;

class DashboardLivewire extends Component
{
    public function render()
    {

        $hostedMeetings = Meeting::today()->count();
        $publicMeetings = Meeting::today()->public()->count();
        $totalMeetings = Meeting::count();
        $totalUsers = User::count();
        $totalMeetingChart = (new LineChartModel())->setTitle('Yearly Host Meeting Overview');
        $totalUsersChart = (new ColumnChartModel())->setTitle('Yearly Users Overview');

        //



        // $hostedMeetingChart->addColumn('Jump', 600, '#90cdf4');
        // $hostedMeetingChart->addColumn('Jump', 600, '#90cdf4');

        return view('livewire.dashboard', [
            "hostedMeetings" => $hostedMeetings,
            "publicMeetings" => $publicMeetings,
            "totalMeetings" => $totalMeetings,
            "totalUsers" => $totalUsers,
            "hostedMeetingChart" => $this->hostedMeetingChart(),
            "usersChart" => $this->usersChart(),
            "totalMeetingChart" => $this->totalMeetingChart(),
            "totalUsersChart" => $this->totalUsersChart(),
        ]);
    }




    public function hostedMeetingChart()
    {

        //
        $chart = (new ColumnChartModel())->setTitle('Hosted Meeting This Week')->withoutLegend();

        for ($loop = 0; $loop < 7; $loop++) {
            $date = Carbon::now()->startOfWeek()->addDays($loop);
            $formattedDate = $date->format("D");
            $data = Meeting::whereDate("created_at", $date)->count();

            //
            $chart->addColumn(
                $formattedDate,
                $data,
                $this->genColor(),
            );
        }


        return $chart;
    }

    public function usersChart()
    {

        //
        $chart = (new ColumnChartModel())->setTitle('Users This Week')->withoutLegend();

        for ($loop = 0; $loop < 7; $loop++) {
            $date = Carbon::now()->startOfWeek()->addDays($loop);
            $formattedDate = $date->format("D");
            $data = User::whereDate("created_at", $date)->count();

            //
            $chart->addColumn(
                $formattedDate,
                $data,
                $this->genColor(),
            );
        }


        return $chart;
    }

    public function totalMeetingChart()
    {

        //
        $chart = (new PieChartModel())->setTitle('Total Meetings (' . Date("Y") . ')')->withoutLegend();

        for ($loop = 0; $loop < 12; $loop++) {
            $date = Carbon::now()->firstOfYear()->addMonths($loop);
            $formattedDate = $date->format("M");
            $data = Meeting::whereMonth("created_at", $date)->count();

            //
            $chart->addSlice(
                $formattedDate,
                $data,
                $this->genColor(),
            );
        }


        return $chart;
    }

    public function totalUsersChart()
    {

        //
        $chart = (new PieChartModel())->setTitle('Total Users (' . Date("Y") . ')')->withoutLegend();

        for ($loop = 0; $loop < 12; $loop++) {
            $date = Carbon::now()->firstOfYear()->addMonths($loop);
            $formattedDate = $date->format("M");
            $data = User::whereMonth("created_at", $date)->count();

            //
            $chart->addSlice(
                $formattedDate,
                $data,
                $this->genColor(),
            );
        }


        return $chart;
    }


    public function genColor()
    {
        return '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    }
}
