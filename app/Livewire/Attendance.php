<?php

namespace App\Livewire;

use App\Models\Attendance as ModelsAttendance;
use App\Models\Settings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Attendance extends Component
{

    public $latitude;
    public $longitude;
    public $image;
    public $isDisable = true;

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
        'set:live-image' => 'setLiveImage',
        'set:live-image-checkout' => 'setLiveImageCheckout',
    ];

    public function setLatitudeLongitude($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->calculateDistance();
    }

    public function setLiveImage($liveImage)
    {
        $auth = auth()->user();
        $precheck = ModelsAttendance::where(['mobile' => $auth->mobile])->orderBy('id', 'desc')->first();
        if (!$precheck && $precheck->type == 1) {
            $this->dispatch('message', 'Please Check Out First');
            return '';
        } else {
            $this->image = $liveImage;
            $image = explode('base64,', $liveImage);
            $image = end($image);
            $image = str_replace(' ', '+', $image);
            $file = "images/" . uniqid() . '.png';
            if (preg_match('/^data:image\/(\w+);base64,/', $liveImage, $type)) {
                $data = substr($liveImage, strpos($liveImage, ',') + 1);
                $type = strtolower($type[1]); // Image type (png, jpeg, gif, etc.)
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return response()->json(['error' => 'Invalid image type'], 415);
                }
                $data = base64_decode($data);
                $file = uniqid() . '.' . $type;
            }
            Storage::disk('public')->put($file, $data);
            ModelsAttendance::create(['user_id' => $auth->id, 'mobile' => $auth->mobile, 'type' => '1', 'image' => $file]);
            $this->dispatch('message', 'Check In Successfully Done');
        }

    }

    public function setLiveImageCheckout($liveImage)
    {
        $auth = auth()->user();
        $precheck = ModelsAttendance::where(['mobile' => $auth->mobile])->orderBy('id', 'desc')->first();
        if (!$precheck || $precheck->type == 0) {
            $this->dispatch('message', 'Please Check In First');
            return '';
        } else {
            $this->image = $liveImage;
            $image = explode('base64,', $liveImage);
            $image = end($image);
            $image = str_replace(' ', '+', $image);
            $file = "images/" . uniqid() . '.png';
            if (preg_match('/^data:image\/(\w+);base64,/', $liveImage, $type)) {
                $data = substr($liveImage, strpos($liveImage, ',') + 1);
                $type = strtolower($type[1]); // Image type (png, jpeg, gif, etc.)
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return response()->json(['error' => 'Invalid image type'], 415);
                }
                $data = base64_decode($data);
                $file = uniqid() . '.' . $type;
            }
            Storage::disk('public')->put($file, $data);
            $diffInMinutes = abs(now()->diffInMinutes($precheck->created_at));
            $roundedDiffInMinutes = round($diffInMinutes);
            ModelsAttendance::create(['user_id' => $auth->id, 'mobile' => $auth->mobile, 'type' => '0', 'image' => $file, 'time' => $roundedDiffInMinutes]);
            $this->dispatch('message', 'Check Out Successfully Done');
        }

    }

    public function checkout()
    {
        ModelsAttendance::create(['user_id' => 1, 'mobile' => '9024829041', 'type' => '0', 'image' => '']);
        $this->dispatch('message', 'Check Out Successfully Uploaded');
    }

    public function calculateDistance()
    {
        $setting = Settings::where('mobile', '9024829041')->first();

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

    public function render()
    {
        $data = ModelsAttendance::where('mobile', '9024829041')->orderBy('id', 'desc')->get();
        return view('livewire.attendance', compact('data'));
    }
}
