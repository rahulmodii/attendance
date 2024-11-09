<?php

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
