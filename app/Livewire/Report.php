<?php

namespace App\Livewire;

use App\Models\AttendanceSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Report extends Component
{

    public $start_date;
    public $end_date;

    public function mount()
    {
        // dd(request()->query('start_date'));
        $this->start_date = request()->query('start_date');
        $this->end_date = request()->query('end_date');

    }

    public function render()
    {
        $users = User::where('parent_id', Auth::user()->id)->get(['id', 'name']);

        // Extract user IDs for attendance lookup and names for dynamic columns
        $userIds = $users->pluck('id');
        $userColumns = $users->map(function ($user) {
            return ['id' => $user->id, 'name' => $user->name];
        });

        // Initialize the report array
        $report = [];

        // Get the start and end dates from query or default to the current month
        $startDate = request()->query('start_date')
            ? Carbon::parse(request()->query('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = request()->query('end_date')
            ? Carbon::parse(request()->query('end_date'))->endOfDay()
            : Carbon::now()->endOfMonth();

        // Pre-fetch attendance data for the entire date range and user list
        $attendanceData = AttendanceSession::whereIn('user_id', $userIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('user_id, date, MIN(in_time) as first_in_time, MAX(out_time) as last_out_time')
            ->groupBy('user_id', 'date')
            ->get()
            ->groupBy('date');

            // dd($attendanceData);

        // Loop through each day of the selected range
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dailyData = ['date' => $date->format('d-m-Y'), 'day' => $date->format('l')];

            // Check if attendance data exists for the current date
            $dailyAttendance = $attendanceData->get($formattedDate, collect());

            foreach ($userColumns as $user) {
                $attendance = $dailyAttendance->where('user_id', $user['id'])->first();

                $totalMinutes = 0;
                if ($attendance && $attendance->first_in_time && $attendance->last_out_time) {
                    $inTime = Carbon::parse($attendance->first_in_time);
                    $outTime = Carbon::parse($attendance->last_out_time);
                    $totalMinutes = abs($outTime->diffInMinutes($inTime,false));

                    $hours = floor($totalMinutes / 60);
                    $minutes = $totalMinutes % 60;

                    $totalMinutes = sprintf('%02d:%02d', $hours, $minutes);
                }

                $dailyData[$user['id']] = $totalMinutes;
            }

            $report[] = $dailyData;
        }
        // dd($report);
        return view('livewire.report', compact('report', 'userColumns'));
    }
}
