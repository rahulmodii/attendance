<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{

    use WithPagination;

    #[Validate('required|min:3')]
    public $name;
    #[Validate('required|min:10|unique:users,mobile')]
    public $mobile;
    #[Validate('required|min:10|unique:users,whatsapp')]
    public $whatsapp;

    public function store()
    {
        $validated = $this->validate();

        $auth = Auth::user();

        User::create([
            'name' => $this->name,
            'email' => "$this->mobile@mailsac.com",
            'password' => Hash::make($this->mobile),
            'role' => 2,
            'mobile' => $this->mobile,
            'whatsapp' => $this->whatsapp,
            'parent_id' => $auth->id,
        ]);

        return $this->dispatch('message','Employee Created Successfully!!');
    }


    public function render()
    {
        $id = Auth::user()->id;
        $data = User::where('parent_id', $id)->orderBy('id', 'desc')->paginate(1);
        return view('livewire.employee', compact('data'));
    }
}
