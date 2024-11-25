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
    public $rechargeuserId;

    public $rechargeForOther = false;

    public function mount()
    {
        $id = Auth::user()->id;
        $this->rechargeuserId = $id;
    }

    public function updatedRechargeuserId()
    {
        // dd($this->rechargeuserId);
        $id = Auth::user()->id;
        if ($this->rechargeuserId == $id) {
            $this->rechargeForOther = false;
        } else {
            $this->rechargeForOther = true;
        }

    }

    public function recharge($id)
    {
        // dd($id);
        $packageId = decrypt($id);
        $auth = Auth::user();
        $authId = $this->rechargeForOther ? $this->rechargeuserId : $auth->id;
        $mobile = $auth->mobile;
        $countryCode = $auth->country_code;
        $mobile = "$countryCode$mobile";
        $package = ModelsPackages::find($packageId);
        Recharge::where(['user_id' => $authId, 'status' => 0])->delete();
        $amount = $this->rechargeForOther ? $package->other_amount  : $package->amount;
        $createRecharge = Recharge::create([
            'user_id' => $authId,
            'package_id' => $packageId,
            'buyer_name' => $auth->name,
            'buyer_phone' => $mobile,
            'unit_price' => $amount,
            'recharge_by' => $auth->id,
        ]);

        if ($createRecharge) {
            $response = Http::withHeaders([
                'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
                'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
            ])->post('https://www.instamojo.com/api/1.1/payment-requests/', [
                'purpose' => "sales",
                'amount' => "$createRecharge->unit_price",
                'phone' => "$mobile",
                'buyer_name' => "$auth->name",
                'redirect_url' => 'https://attendance.wappblaster.com/redirect',
                'webhook' => 'https://attendance.wappblaster.com/webhook',
                'send_email' => false,
                'send_sms' => false,
                'email' => 'foo@example.com',
                'allow_repeated_payments' => false,
            ]);
            $externalCall = json_decode($response->body(), true);
            dd($externalCall);
            if (isset($externalCall['success']) && $externalCall['success'] == true) {
                $rechargeCheck = Recharge::find($createRecharge->id);
                $rechargeCheck->update(['payment_id' => $externalCall['payment_request']['id']]);
                return redirect()->away($externalCall['payment_request']['longurl']);
            } else {
                return $this->dispatch('message', 'Something went wrong!!');
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
        $referals = User::where(['referal_id' => $id])->get();
        return view('livewire.packages', compact('packages', 'data', 'referals'));
    }
}
