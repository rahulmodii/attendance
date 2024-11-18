<?php

namespace App\Livewire;

use App\Models\Settings as ModelsSettings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Settings extends Component
{

    public $mobile;
    public $latitude;
    public $longitude;
    public $radius;
    public $name;
    public $company_name;
    public $in_time;
    public $out_time;

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
    ];

    public function setLatitudeLongitude($latitude, $longitude)
    {
        $auth = Auth::user();
        $precheck = ModelsSettings::where('user_id', $auth->id)->first();
        if (!$precheck) {
            if (!$precheck->latitude && !$precheck->longitude) {
                $this->latitude = $latitude;
                $this->longitude = $longitude;
            }

        }

    }

    public function mount()
    {

        $auth = Auth::user();
        $precheck = ModelsSettings::where('user_id', $auth->id)->first();
        if ($precheck) {
            $this->latitude = $precheck->latitude;
            $this->longitude = $precheck->longitude;
            $this->radius = $precheck->radius;
            $this->name = $precheck->name;
            $this->company_name = $precheck->company_name;
            $this->in_time = $precheck->in_time;
            $this->out_time = $precheck->out_time;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'company_name' => 'required',
            'radius' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'out_time' => 'required',
            'in_time' => 'required',

        ]);
        $auth = Auth::user();
        $precheck = ModelsSettings::where('user_id', $auth->id)->first();
        if ($precheck) {
            $auth->update(['name'=>$this->name]);
            ModelsSettings::where('user_id', $auth->id)->update(['latitude' => $this->latitude, 'longitude' => $this->longitude, 'radius' => $this->radius, 'name' => $this->name, 'company_name' => $this->company_name, 'in_time' => $this->in_time, 'out_time' => $this->out_time]);
            return $this->dispatch('message', 'Settings Updated Successfully!!');
        } else {
            $auth->update(['name'=>$this->name]);
            ModelsSettings::create(['user_id' => $auth->id, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'radius' => $this->radius, 'name' => $this->name, 'company_name' => $this->company_name, 'in_time' => $this->in_time, 'out_time' => $this->out_time]);
            return $this->dispatch('message', 'Settings Create Successfully!!');
        }
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
