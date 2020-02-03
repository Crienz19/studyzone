<?php

Route::prefix('auth')->group(function () {
    Route::post('/register', 'Api\AuthController@register');
    Route::post('/login', 'Api\AuthController@login');
    Route::get('/logout', 'Api\AuthController@logout');
    Route::get('/me', 'Api\AuthController@me');
    Route::post('/resetPassword', 'Api\AuthController@resetPassword');
    Route::post('/resetToDefault/{userId}', 'Api\AuthController@resetToDefault');
});

Route::prefix('user')->group(function () {
    Route::get('/getAllUsers', 'Api\UserController@getAllUsers');
});

Route::prefix('client')->group(function () {
    Route::post('/addTransaction', 'Api\ClientController@addTransaction');
});

Route::prefix('admin')->group(function () {
   Route::get('/getAllTransactions', 'Api\AdminController@getAllTransactions');
   Route::get('/getOverallTransactions', 'Api\AdminController@getOverallTransactions');
   Route::post('/clockOut/{id}', 'Api\AdminController@clockMeOut');
   Route::post('/addTime/{id}', 'Api\AdminController@addTime');
});

Route::prefix('space')->group(function () {
    Route::get('/getAll', 'Api\SpaceController@getAll');
    Route::post('/store', 'Api\SpaceController@store');
    Route::patch('/update/{id}', 'Api\SpaceController@update');
    Route::delete('/delete/{id}', 'Api\SpaceController@destroy');
});

Route::prefix('card')->group(function () {
    Route::get('/getAllCards', 'Api\CardController@getAllCards');
    Route::post('/storeCard', 'Api\CardController@storeCard');
    Route::delete('/deleteCard/{id}', 'Api\CardController@deleteCard');
});

Route::prefix('subscription')->group(function () {
    Route::get('/getAllSubs', 'Api\SubscriptionController@getAllSubscription');
    Route::post('/addSubscription/{userId}', 'Api\SubscriptionController@addSubscription');
    Route::delete('/deleteSubscription/{id}', 'Api\SubscriptionController@deleteSubscription');
});

Route::prefix('amenities')->group(function () {
    Route::get('/getAllAmenities', 'Api\AmenitiesController@getAllAmenities');
    Route::post('/storeAmenities', 'Api\AmenitiesController@storeAmenities');
    Route::delete('/deleteAmenities/{id}', 'Api\AmenitiesController@deleteAmenities');
});

Route::prefix('services')->group(function () {
    Route::get('/getAllDailyService', 'Api\ServiceController@getAllDailyService');
    Route::get('/getOverallService', 'Api\ServiceController@getOverallService');
    Route::post('/storeService', 'Api\ServiceController@storeService');
});