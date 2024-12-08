<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WhiteLabel extends Component
{

    public $domain;
    public $webhook;
    public $authId;

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
        return view('livewire.white-label');
    }
}
