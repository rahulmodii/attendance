<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
class WhiteLabel extends Component
{


    use WithFileUploads;
    // $table->string('logo')->nullable();
    //         $table->string('software_name')->nullable();
    //         $table->string('software_update_path')->nullable();
    //         $table->string('version_number')->nullable();
    //         $table->string('support_number')->nullable();
    public $domain;
    public $webhook;
    public $authId;
    public $logo;
    public $software_name;
    public $software_update_path;
    public $version_number;
    public $support_number;
    public $currentLogo;

    public function mount()
    {
        $this->authId = Auth::user()->id;
        $this->webhook = Auth::user()->white_label_webhook;
        $this->domain = Auth::user()->domain;
        $this->currentLogo = Auth::user()->logo;
        $this->software_name = Auth::user()->software_name;
        $this->software_update_path = Auth::user()->software_update_path;
        $this->version_number = Auth::user()->version_number;
        $this->support_number = Auth::user()->support_number;
    }

    public function saveDomain()
    {
        User::find($this->authId)->update([
            'domain' => $this->domain,
        ]);
        return $this->dispatch('message', 'Domain Updated Successfully!!');
    }

    public function saveWebhook()
    {
        User::find($this->authId)->update([
            'white_label_webhook' => $this->webhook,
            'is_white_label' => 1,
        ]);
        return $this->dispatch('message', 'Webhook Updated Successfully!!');
    }

    public function save()
    {
        $data = [
            'software_name' => $this->software_name,
            'software_update_path' => $this->software_update_path,
            'version_number' => $this->version_number,
            'support_number' => $this->support_number,
        ];

        if ($this->logo) {
            $logo =  $this->logo->store('documents', 'public');
            $data['logo'] = $logo;
        }
        $update =  User::find($this->authId)->update($data);
        // dd($update);
    }

    public function render()
    {

        // dd($report);
        return view('livewire.white-label');
    }
}
