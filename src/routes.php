<?php

use Cxj\LookingGlass\Http\Controllers\HealthDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/lg-dash', HealthDashboard::class)->name('looking-glass-dashboard');
