<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Referral extends Component
{
    public function render()
    {
        $data = User::where('referal_id', auth()->user()->id)->get();
        $secondLevel = User::whereIn('referal_id', $data->pluck('id'))->get();

        // Fetch second-level user names
        $secondLevelName = $data->pluck('name');

        // Combine the results
        $secondLevel = $secondLevel->merge($secondLevel);
        $secondLevelName = $secondLevelName->merge($data->pluck('name'));
        return view('livewire.referral', compact('data','secondLevel','secondLevelName'));
    }
}
