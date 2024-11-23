<?php

use App\Jobs\DayJob;
use App\Models\Recharge;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/testpayment',function(){


    $response = Http::withHeaders([
        'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
        'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
    ])->post('https://www.instamojo.com/api/1.1/payment-requests/', [
        'purpose' => "sales",
        'amount' => '10',
        'phone' => '919024829041',
        'buyer_name' => 'rahul',
        'redirect_url' =>'https://79ac-205-254-163-52.ngrok-free.app/redirect',
        'webhook' => 'https://79ac-205-254-163-52.ngrok-free.app/webhook',
        'send_email' => false,
        'send_sms' => false,
        'email' => 'foo@example.com',
        'allow_repeated_payments' => false,
    ]);

    $url = json_decode($response->body())->payment_request->longurl;
    // dd($url);
    return redirect()->away($url);
});

Route::get('/redirect',function(Request $request){

    $paymentId = $request->get('payment_id');
        $response = Http::withHeaders([
            'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
            'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
        ])->get("https://www.instamojo.com/api/1.1/payments/$paymentId/");

        $res = json_decode($response->body(),true);
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
            Recharge::create([
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
            Recharge::create([
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
        dd($res);
});

Route::post('/webhook',function(Request $request){
    dd($request->body());
});


Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', function () {
        return view('attendance');
    })->name('attendance');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    Route::get('/employee', function () {
        return view('employee');
    })->name('employee');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/packages', function () {
        return view('packages');
    })->name('packages');

    Route::get('/referral', function () {
        return view('referal');
    })->name('referral');

    Route::get('/wallet', function () {
        return view('wallet');
    })->name('wallet');



    Route::get('/logout', function () {
        if (Auth::check()) {
            Auth::logout();
            Session::flush();
            return redirect()->route('attendance');
        } else {
            return redirect()->route('attendance');
        }
    })->name('logout');
});

Route::get('/test',function(){
    DayJob::dispatch();
});
