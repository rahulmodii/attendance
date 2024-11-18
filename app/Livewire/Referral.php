<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Referral extends Component
{
    public function render()
    {
        $data = User::where('referal_id', auth()->user()->id)->get();
        $secondLevel = collect();
        foreach ($data as $value) {
            $secondLevel = $secondLevel->merge(User::where('referal_id', $value->id)->get());
        }
        // dd($secondLevel);
        return view('livewire.referral', compact('data','secondLevel'));
    }
}
