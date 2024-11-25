<?php

use App\Jobs\DayJob;
use App\Models\Packages;
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

Route::get('/packages-create', function () {
    // id, package_name, amount, max_staff, status, created_at, updated_at
    $packages = [
        ['package_name' => 'Bronze', 'amount' => 2000, 'min_staff' => 1, 'max_staff' => 10, 'status' => 1, 'other_amount' => 1000],
        ['package_name' => 'Silver', 'amount' => 3000, 'min_staff' => 10, 'max_staff' => 20, 'status' => 1, 'other_amount' => 1500],
        ['package_name' => 'Gold', 'amount' => 4000, 'min_staff' => 20, 'max_staff' => 30, 'status' => 1, 'other_amount' => 2000],
        ['package_name' => 'Platinum', 'amount' => 5000, 'min_staff' => 30, 'max_staff' => 40, 'status' => 1, 'other_amount' => 2500],
    ];
    // Packages::all()->delete();
    Packages::insert($packages);
});

Route::get('/testpayment', function () {

    $response = Http::withHeaders([
        'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
        'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
    ])->post('https://www.instamojo.com/api/1.1/payment-requests/', [
        'purpose' => "sales",
        'amount' => '10',
        'phone' => '919024829041',
        'buyer_name' => 'rahul',
        'redirect_url' => 'https://8871-205-254-163-52.ngrok-free.app/redirect',
        'webhook' => 'https://8871-205-254-163-52.ngrok-free.app/webhook',
        'send_email' => false,
        'send_sms' => false,
        'email' => 'foo@example.com',
        'allow_repeated_payments' => false,
    ]);

    $url = json_decode($response->body())->payment_request->longurl;
    // dd($url);
    return redirect()->away($url);
});

Route::get('/redirect', function (Request $request) {

    $paymentId = $request->get('payment_id');
    $paymentRequestId = $request->get('payment_request_id');
    if (!$paymentId && !$paymentRequestId) {
        return redirect()->route('login');
    }
    $recharge = Recharge::where('payment_id', $paymentRequestId)->first();
    dd($recharge);
    if ($recharge) {
        $response = Http::withHeaders([
            'X-Api-Key' => '1738a39ef7efea853cd22d9ec697044e',
            'X-Auth-Token' => '2dc1fb5a6c41ac17949ae1d9611784a1',
        ])->get("https://www.instamojo.com/api/1.1/payments/$paymentId/");

        $res = json_decode($response->body(), true);
        User::find($recharge->user_id)->update([
            'package_id' => $recharge->package_id,
            'expiry_date' => Carbon::now()->addYear(1)->format('Y-m-d'),
        ]);
        $parentId = User::find($recharge->user_id)->parent_id;

        if ($parentId) {
            $firstParent = User::find($parentId);

            if ($firstParent) {
                $referalAmount = round($recharge->unit_price * 0.5);

                // Update the first parent's wallet and create a wallet entry
                Wallet::create([
                    'user_id' => $firstParent->id,
                    'current_balance' => $firstParent->wallet_balance + $referalAmount,
                    'previous_balance' => $firstParent->wallet_balance,
                    'type' => 1,
                    'amount' => $referalAmount,
                    'coupon_used_id' => $recharge->recharge_by,
                    'coupon_used_string' => "",
                    'account_source' => 2,
                    'used_by_name' => "",
                    'recharge_id' => $recharge->id,
                ]);
                $firstParent->increment('wallet_balance', $referalAmount);

                // Check and handle second parent
                $secondParentId = $firstParent->parent_id;
                if ($secondParentId) {
                    $secondParent = User::find($secondParentId);
                    if ($secondParent) {
                        $referalAmountNew = round($recharge->unit_price * 0.15);

                        // Update the second parent's wallet and create a wallet entry
                        Wallet::create([
                            'user_id' => $secondParent->id,
                            'current_balance' => $secondParent->wallet_balance + $referalAmountNew,
                            'previous_balance' => $secondParent->wallet_balance,
                            'type' => 1,
                            'amount' => $referalAmountNew,
                            'coupon_used_id' => $recharge->user_id,
                            'coupon_used_string' => "",
                            'account_source' => 2,
                            'used_by_name' => "",
                            'recharge_id' => $recharge->id,
                        ]);
                        $secondParent->increment('wallet_balance', $referalAmountNew);
                    }
                }
            }
        }

        $recharge = $recharge->update(['status' => 1, 'raw_json' => json_encode($recharge), 'fees' => $res['payment']['fees'], 'billing_instrument' => $response['payment']['billing_instrument']]);

        return redirect()->route('packages');
    } else {
        return redirect()->route('login');
    }

});

Route::post('/webhook', function (Request $request) {
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

Route::get('/test', function () {
    DayJob::dispatch();
});
