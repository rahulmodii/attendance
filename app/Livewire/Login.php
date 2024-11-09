<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{

    public $mobile;
    public $otp;
    public $isSent = false;

    public function sendOtp()
    {
        if ($this->isSent) {
            $checkVerification = Verification::where(['mobile' => $this->mobile, 'otp' => $this->otp])->first();
            if ($checkVerification) {
                $checkVerification->delete();
                $preCheckUser = User::where('mobile', $this->mobile)->first();
                if ($preCheckUser) {
                    Auth::login($preCheckUser, true);
                    return redirect()->route('attendance');
                } else {
                    $auth = User::create(['name' => Str::random(8), 'email'=>"$this->mobile@mailsac.com" , 'mobile' => $this->mobile, 'password' => Hash::make($this->mobile), 'role' => 1]);
                    Auth::login($auth, true);
                    return redirect()->route('attendance');
                }
            } else {
                return $this->dispatch('message', 'Wrong Otp');
            }
        } else {
            $localotp = rand(1000, 9999);
            $mobile = $this->mobile;
            $this->otp = $localotp;
            Verification::create(['mobile' => $mobile, 'otp' => $localotp]);
            $url = 'https://webhooks.wappblaster.com/webhook/669b736a97d275a0b8012769';
            // $response = Http::get($url, [
            //     'number' => $mobile,
            //     'otp' => $localotp,
            // ]);
            $this->isSent = true;
        }

    }

    public function render()
    {
        return view('livewire.login');
    }
}
