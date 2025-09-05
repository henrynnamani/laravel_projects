<?php

use App\Http\Controllers\Api\EventController;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('event', EventController::class);

Route::apiResource('events.attendees', Attendee::class)->scoped(['attendee' => 'event']);