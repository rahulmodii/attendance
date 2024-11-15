<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public $filterdate;

    public function mount(){
        $this->filterdate = Carbon::now()->format('Y-m-d');
    }

    public function updatedFilterdate($value){
        // dd($value);
        $this->filterdate = $value;
    }


    public function render()
    {
        $specificDate =  $this->filterdate;
        $id = Auth::user()->id;
        $data = User::where('parent_id', $id)->with(['attendanceSessions' => function ($query) use ($specificDate) {
            $query->whereDate('date', $specificDate)
                ->selectRaw('user_id, MIN(in_time) as first_in_time, MAX(out_time) as last_out_time')
                ->groupBy('user_id');
        }])->get();

        foreach ($data as $key => $value) {
            $value['totalMinute'] = $value->totalTime($this->filterdate);
            $new = $value->attendanceSessions->first();
            $value['first_in_time'] = 'N/A';
            $value['first_out_time'] = 'N/A';
            if ($new) {
                $value['first_in_time'] = $new->first_in_time;
                $value['first_out_time'] = $new->last_out_time;
            }
        }
        return view('livewire.dashboard', compact('data'));
    }
}
