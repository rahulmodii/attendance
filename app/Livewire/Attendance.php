<?php

namespace App\Livewire;

use App\Models\Attendance as ModelsAttendance;
use App\Models\AttendanceSession;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\User;
class Attendance extends Component
{

    public $latitude;
    public $longitude;
    public $image;
    public $isDisable = true;
    public $currentSessionId = 0;

    public $employeeFilterId = 0;

    public $data = [];

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
        'set:live-image' => 'setLiveImage',
        'set:live-image-checkout' => 'setLiveImageCheckout',
    ];

    public function mount(){
        $auth = Auth::user();
        $this->employeeFilterId = $auth->id;
        $data = AttendanceSession::where('user_id', $auth->id)->orderBy('id', 'desc')->get();
        $this->data = $data;
    }

    public function setLatitudeLongitude($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->calculateDistance();
    }

    public function setLiveImage($liveImage)
    {
        // dd($liveImage);
        $auth = Auth::user();
        // dd($auth);
        $precheck = AttendanceSession::where(['date' => Carbon::today()->format('Y-m-d'), 'user_id' => $auth->id])->whereNull('out_time')->latest()->first();

        if ($precheck) {
            return $this->dispatch('message', 'Please Check Out First');
        } else {
            $this->image = $liveImage;
            $image = str_replace('data:image/png;base64,', '', $this->image);

            // Decode the image
            $image = preg_replace('/\s+/', '', $image);
            $image = base64_decode($image);

            // Define a unique filename with the correct extension
            $filename = 'image_' . time() . '.png';

            // Store the image in the 'public' disk (in `storage/app/public`)
            Storage::disk('public')->put($filename, $image);
            $url = Storage::url($filename);

            AttendanceSession::create([
                'user_id' => $auth->id,
                'date' => now()->toDateString(),
                'in_time' => now()->toTimeString(),
                'in_selfie' => $url,
            ]);
            return $this->dispatch('message', 'Check In Done Succssfully!!');
        }
    }

    public function setLiveImageCheckout($liveImage)
    {
        // dd($liveImage);
        $auth = Auth::user();
        $precheck = AttendanceSession::where(['date' => Carbon::today()->format('Y-m-d'), 'user_id' => $auth->id])->whereNull('out_time')->latest()->first();
        if (!$precheck) {
            return $this->dispatch('message', 'Please Check In First');
        } else {
            $this->image = $liveImage;
            $image = str_replace('data:image/png;base64,', '', $liveImage);

            // Decode the image
            $image = preg_replace('/\s+/', '', $image);
            $image = base64_decode($image);

            // Define a unique filename with the correct extension
            $filename = 'image_' . time() . '.png';

            // Store the image in the 'public' disk (in `storage/app/public`)
            Storage::disk('public')->put($filename, $image);
            $url = Storage::url($filename);
            $diffInMinutes = abs(now()->diffInMinutes($precheck->in_time));
            $roundedDiffInMinutes = round($diffInMinutes);
            $precheck->update([
                'out_selfie' => $url,
                'out_time' => now()->toTimeString(),
                'total_minutes' => $roundedDiffInMinutes,
            ]);
            return $this->dispatch('message', 'Check Out Successfully Done');
        }
    }

    public function calculateDistance()
    {
        $id = auth()->user()->id;
        if (auth()->user()->role == 2) {
           $id = auth()->user()->parent_id;
        }
        $setting = Settings::where('user_id', $id)->first();

        $originLatitude = $this->latitude;
        $originLongitude = $this->longitude;
        $destinationLatitude = $setting->latitude;
        $destinationLongitude = $setting->longitude;
        $origins = "$originLatitude , $originLongitude";
        $destinations = "$destinationLatitude , $destinationLongitude";
        $mode = 'driving';
        $units = 'metric';
        $apiKey = 'AIzaSyA_nqLQQ1atU39I9LOWn3eu_qboK43o9YM';

        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => $origins,
            'destinations' => $destinations,
            'mode' => $mode,
            'units' => $units,
            'key' => $apiKey,
        ]);
        // dd($response->json());
        if ($response->successful()) {
            $data = $response->json();

            if ($data['status'] === 'OK') {
                $element = $data['rows'][0]['elements'][0];
                if ($element['status'] === 'OK') {
                    $totalDistance = $element['distance']['value'];
                    $permittedDistance = $setting->radius;
                    if ($permittedDistance > $totalDistance) {
                        $this->isDisable = false;
                    }
                } else {
                    return response()->json([
                        'error' => 'Destination not reachable.',
                        'status' => $element['status'],
                    ], 400);
                }
            } else {
                return response()->json([
                    'error' => 'API Error.',
                    'status' => $data['status'],
                ], 500);
            }
        } else {
            return response()->json([
                'error' => 'HTTP Request Failed.',
                'status' => $response->status(),
            ], $response->status());
        }
    }

    public function updatedEmployeeFilterId($value)
    {
        // $this->isDisable = true;
        $this->data  = AttendanceSession::where('user_id', $value)->orderBy('id', 'desc')->get();
    }

    public function render()
    {
        $auth = Auth::user();
        $employees = User::where('parent_id', $auth->id)->get();
        return view('livewire.attendance', compact('employees'));
    }
}
