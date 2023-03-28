<?php

use Cxj\LookingGlass\Http\Controllers\HealthDashboard;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;


Route::group(['prefix' => 'api', 'middleware' => 'api'], function() {
    /** @phpstan-ignore-next-line  Method added via macro in Spatie library */
    Route::webhooks('/webhook');
});

Route::get('/lg-dash', HealthDashboard::class)->name('looking-glass-dashboard');
Route::get('/health', HealthCheckResultsController::class);

