<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DayJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = User::where('role', 1)->get();

        foreach ($data as $key => $value) {
            $attendances = User::where('parent_id', $value->id)->with(['attendanceSessions' => function ($query){
                $query->whereDate('date', '2024-11-09')
                    ->selectRaw('user_id, MIN(in_time) as first_in_time, MAX(out_time) as last_out_time')
                    ->groupBy('user_id');
            }])->get();
            $connectionString = "";
            foreach ($attendances as $key => $attendance) {
                $checkIn = count($attendance->attendanceSessions) > 0  ? $attendance->attendanceSessions->first()->first_in_time : 'N/A';
                $checkOut = count($attendance->attendanceSessions) > 0 ? $attendance->attendanceSessions->first()->last_out_time : 'N/A';
                $totalMinute = $attendance->totalTime(Carbon::now()->format('2024-11-09'));
                $connectionString .= " Name: $attendance->name checkIn: $checkIn checkOut: $checkOut totalMinute: $totalMinute 🚀🚀 ";
            }
            // dd($connectionString);
            try {
                $response = Http::get("https://webhooks.wappblaster.com/webhook/66e5ce43e500551042b3f626", [
                    'number' => "919024829041",
                    'report' => $connectionString,
                ]);
                if ($response->failed()) {
                    Log::error('Failed to send message', [
                        // 'manager_id' => $manager->id,
                        'response' => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('HTTP Request Exception', [
                    // 'manager_id' => $manager->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // dd($response->json());
        }

    }
}
