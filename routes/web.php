<?php

use App\Jobs\DayJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('login');
})->name('login');

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
