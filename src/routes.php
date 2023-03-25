<?php

use App\Http\Controllers\HealthDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/lg-dash', HealthDashbaord::class)->('looking-glass-dashboard');
