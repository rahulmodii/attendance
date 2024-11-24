<?php

namespace App\Livewire;

use App\Models\Packages as ModelsPackages;
use App\Models\Recharge;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Packages extends Component
{
    public $otherPersonRechargeId = null;

    public function recharge($id)
    {
        $packageId = decrypt($id);
        $auth = Auth::user();
        $authId = $auth->id;
        $mobile = $auth->mobile;
        $countryCode = $auth->country_code;
        $mobile = "$countryCode$mobile";
        $package = ModelsPackages::find($packageId);
        Recharge::where(['user_id' => $authId, 'status' => 0])->delete();

        $createRecharge = Recharge::create([
            'user_id' => $authId,
            'package_id' => $packageId,
            'buyer_name' => $auth->name,
            'buyer_phone' => $mobile,
            'unit_price' => $package->amount,
            'recharge_by' => $auth->id,
        ]);

        if ($createRecharge) {
            $response = Http::withHeaders([
                'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
                'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
            ])->post('https://www.instamojo.com/api/1.1/payment-requests/', [
                'purpose' => "sales",
                'amount' => "$package->amount",
                'phone' => "$mobile",
                'buyer_name' => "$auth->name",
                'redirect_url' => 'https://214b-205-254-163-52.ngrok-free.app/redirect',
                'webhook' => 'https://214b-205-254-163-52.ngrok-free.app/webhook',
                'send_email' => false,
                'send_sms' => false,
                'email' => 'foo@example.com',
                'allow_repeated_payments' => false,
            ]);
            $externalCall = json_decode($response->body(), true);
            if (isset($externalCall['success']) && $externalCall['success'] == true) {
                $rechargeCheck = Recharge::find($createRecharge->id);
                User::find($rechargeCheck->user_id)->update(['payment_id' => $externalCall['payment_request']['id']]);
                return redirect()->away($externalCall['payment_request']['longurl']);
            } else {

            }
        }

        // dd($response->body());
        // id, user_id, package_id, payment_id, amount, buyer_name, buyer_phone, unit_price, fees, billing_instrument, raw_json, created_at, updated_at, recharge_by

    }

    public function render()
    {
        $packages = ModelsPackages::all();
        $id = Auth::user()->id;
        $data = Recharge::where(['user_id' => $id, 'status' => 1])->get();
        $referals = User::where(['parent_id' => $id, 'role' => 1])->get();
        return view('livewire.packages', compact('packages', 'data','referals'));
    }
}
