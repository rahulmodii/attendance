<?php

namespace App\Livewire;

use App\Models\Coupons;
use App\Models\User;
use App\Models\Wallet as ModelsWallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wallet extends Component
{
    public $coupon;

    public function applyCoupon()
    {
        $checkCoupon = Coupons::where(['coupon' => $this->coupon, 'is_used' => 0])->first();
        if ($checkCoupon) {
            $id = Auth::user()->id;
            User::find($id)->update([
                'package_id' => $checkCoupon->package_id,
                'expiry_date' => Carbon::now()->addYear(1)->format('Y-m-d'),
            ]);
            $checkCoupon->update([
                'used_by' => $id,
                'is_used' => 1,
            ]);

            $parentId = User::find($id)->parent_id;
            $firstParent = User::find($parentId);
            $firstParentIds = $firstParent->id;
            if ($firstParent) {
                $referalAmount = round($checkCoupon->amount * 0.5);
                ModelsWallet::create([
                    'user_id' => $parentId,
                    'current_balance' => $firstParent->wallet_balance + $referalAmount,
                    'previous_balance' => $firstParent->wallet_balance,
                    'type' => 1,
                    'amount' => $referalAmount,
                    'coupon_used_id' => $checkCoupon->id,
                    'coupon_used_string' => $checkCoupon->coupon,
                    'account_source' => 1,
                    'used_by_name'=> auth()->user()->name
                ]);
                $firstParent->update(['wallet_balance' => $firstParent->wallet_balance + $referalAmount]);
                $firstParentId = User::find($firstParentIds);
                $secondParent = User::find($firstParentId->parent_id);
                $referalAmountNew = round($checkCoupon->amount * 0.15);
                ModelsWallet::create([
                    'user_id' => $secondParent->id,
                    'current_balance' => $secondParent->wallet_balance + $referalAmountNew,
                    'previous_balance' => $secondParent->wallet_balance,
                    'type' => 1,
                    'amount' => $referalAmountNew,
                    'coupon_used_id' => $checkCoupon->id,
                    'coupon_used_string' => $checkCoupon->coupon,
                    'account_source' => 1,
                    'used_by_name'=> auth()->user()->name
                ]);
                $secondParent->increment('wallet_balance', $referalAmountNew);
            }
            $this->coupon = "";
            return $this->dispatch('message', 'Coupon Applied Successfully!!');
        } else {
            return $this->dispatch('message', 'Invalid Coupon!!');
        }
    }

    public function render()
    {
        $id = auth()->user()->id;
        $totalRefered = User::where('parent_id', $id)->count();
        $data = ModelsWallet::where('user_id',$id)->get();
        return view('livewire.wallet', compact('totalRefered','data'));
    }
}
