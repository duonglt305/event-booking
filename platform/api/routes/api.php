<?php

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'RegisterController@register');
        Route::post('verify', 'RegisterController@verify');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('profile', 'AuthController@profile');
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('change-photo', 'AuthController@changePhoto');
    });
    Route::get('events', 'EventController@index');
    Route::prefix('organizers')->group(function () {
        Route::get('{organizer}/events/{event}', 'EventController@show');
        Route::post('{organizer}/events/{event}/registration', 'RegistrationController@registration');
        Route::get('{organizer}/events/{event}/payment-detail', 'RegistrationController@paymentDetail');
        Route::get('{organizer}/events/{event}/articles', 'EventController@articles');
    });
    Route::post('confirm-payment', 'RegistrationController@confirmPayment');
    Route::post('payment', 'RegistrationController@payment');
    Route::get('registrations', 'RegistrationController@registrations');
    Route::post('contact','EventController@contact');
});
