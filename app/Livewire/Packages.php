<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Packages extends Component
{

    public function recharge($id)
    {
        dd($id);
        $response = Http::withHeaders([
            'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
            'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
        ])->post('https://www.instamojo.com/api/1.1/payment-requests/', [
            'purpose' => "sales",
            'amount' => '10',
            'phone' => '919024829041',
            'buyer_name' => encrypt($id),
            'redirect_url' => 'https://79ac-205-254-163-52.ngrok-free.app/redirect',
            'webhook' => 'https://79ac-205-254-163-52.ngrok-free.app/webhook',
            'send_email' => false,
            'send_sms' => false,
            'email' => 'foo@example.com',
            'allow_repeated_payments' => false,
        ]);

        $url = json_decode($response->body())->payment_request->longurl;
        // dd($url);
        return redirect()->away($url);
    }

    public function render()
    {
        return view('livewire.packages');
    }
}
