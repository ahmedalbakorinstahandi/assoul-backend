<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});
Route::get('/delete-account', function () {
    return view('delete_account');
});
Route::get('/support', function () {
    return view('support');
});
