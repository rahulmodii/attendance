<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WhiteLabel extends Component
{

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

    public function mount()
    {
        $this->authId = Auth::user()->id;
        $this->webhook = Auth::user()->white_label_webhook;
        $this->domain = Auth::user()->domain;
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

    public function render()
    {


        // dd($report);
        return view('livewire.white-label');
    }
}
