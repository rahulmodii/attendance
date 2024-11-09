<?php

namespace App\Livewire;

use App\Models\Settings as ModelsSettings;
use Livewire\Component;

class Settings extends Component
{

    public $name;
    public $mobile;
    public $latitude;
    public $longitude;
    public $radius;

    public function mount(){

        $precheck = ModelsSettings::where('mobile','9024829041')->first();
        if ($precheck) {
            $this->name = $precheck->name;
            $this->mobile = $precheck->mobile;
            $this->latitude = $precheck->latitude;
            $this->longitude = $precheck->longitude;
            $this->radius = $precheck->radius;
        }
    }

    public function save()
    {
        $precheck = ModelsSettings::where('mobile',$this->mobile)->first();
        if ($precheck) {
            ModelsSettings::where(['mobile' => $this->mobile])->update(['latitude' => $this->latitude, 'longitude' => $this->longitude, 'radius' => $this->radius]);
        }else{
            ModelsSettings::create(['mobile' => $this->mobile, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'radius' => $this->radius]);
        }
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
