<?php

namespace App\Livewire;

use App\Models\Packages as ModelsPackages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Packages extends Component
{

    public function recharge($id)
    {
        $packageId = decrypt($id);
        $auth = Auth::user();
        $authId = $auth->id;
        $mobile = $auth->mobile;
        $countryCode = $auth->country_code;
        $mobile = "$countryCode$mobile";
        $package = ModelsPackages::find($packageId);
        $response = Http::withHeaders([
            'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
            'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
        ])->post('https://www.instamojo.com/api/1.1/payment-requests/', [
            'purpose' => "sales",
            'amount' => "$package->amount",
            'phone' => "$mobile",
            'buyer_name' => "$auth->name",
            'redirect_url' => 'https://8871-205-254-163-52.ngrok-free.app/redirect',
            'webhook' => 'https://8871-205-254-163-52.ngrok-free.app/webhook',
            'send_email' => false,
            'send_sms' => false,
            'email' => 'foo@example.com',
            'allow_repeated_payments' => false,
        ]);
        // dd($response->body());
        $url = json_decode($response->body())->payment_request->longurl;
        // dd($url);
        return redirect()->away($url);
    }

    public function render()
    {
        $packages = ModelsPackages::all();
        return view('livewire.packages',compact('packages'));
    }
}
