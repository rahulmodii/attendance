<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Report extends Component
{
    public function render()
    {
         // Get all employees under the authenticated user
         $users = User::where('parent_id', Auth::user()->id)->get();

         // Extract user IDs and names for dynamic columns
         $userColumns = $users->map(function ($user) {
             return ['id' => $user->id, 'name' => $user->name];
         });

         // Initialize the report array
         $report = [];

         // Get the start and end dates of the current month
         $startDate = Carbon::now()->startOfMonth();
         $endDate = Carbon::now()->endOfMonth();

         // Loop through each day of the month
         for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
             $dailyData = ['date' => $date->format('d-m-Y'),'day'=>$date->format('l')];

             // Loop through each user to fetch their attendance for the current date
             foreach ($userColumns as $user) {
                 $attendance = User::find($user['id'])
                     ->attendanceSessions()
                     ->whereDate('date', $date)
                     ->selectRaw('MIN(in_time) as first_in_time, MAX(out_time) as last_out_time')
                     ->first();

                 $totalMinutes = 0;
                 if ($attendance && $attendance->first_in_time && $attendance->last_out_time) {
                     $inTime = Carbon::parse($attendance->first_in_time);
                     $outTime = Carbon::parse($attendance->last_out_time);
                     $totalMinutes = $outTime->diffInMinutes($inTime);
                 }

                 $dailyData[$user['id']] = $totalMinutes;
             }

             $report[] = $dailyData;
         }
        return view('livewire.report',compact('report','userColumns'));
    }
}
