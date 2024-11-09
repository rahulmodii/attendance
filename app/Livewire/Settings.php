<?php

namespace App\Livewire;

use App\Models\Settings as ModelsSettings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Settings extends Component
{

    public $name;
    public $mobile;
    public $latitude;
    public $longitude;
    public $radius;

    public function mount()
    {

        $auth = Auth::user();
        $precheck = ModelsSettings::where('user_id', $auth->id)->first();
        if ($precheck) {
            $this->latitude = $precheck->latitude;
            $this->longitude = $precheck->longitude;
            $this->radius = $precheck->radius;
        }
    }

    public function save()
    {
        $auth = Auth::user();
        $precheck = ModelsSettings::where('user_id', $auth->id)->first();
        if ($precheck) {
            ModelsSettings::find($auth->id)->update(['latitude' => $this->latitude, 'longitude' => $this->longitude, 'radius' => $this->radius]);
            return $this->dispatch('message', 'Settings Updated Successfully!!');
        } else {
            ModelsSettings::create(['user_id' => $auth->id, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'radius' => $this->radius]);
            return $this->dispatch('message', 'Settings Create Successfully!!');
        }
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
