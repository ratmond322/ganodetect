<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardDataController;

/*
| Development-only: public API routes for dashboard quick testing.
| Remove auth middleware in production.
*/

Route::get('/dashboard-stats', [DashboardDataController::class, 'stats']);
Route::get('/recent-detections', [DashboardDataController::class, 'recent']);
Route::get('/trend', [DashboardDataController::class, 'trend']);
Route::get('/distribution', [DashboardDataController::class, 'distribution']);
Route::get('/area-coverage', [DashboardDataController::class, 'areaCoverage']);
Route::get('/drone-locations', [DashboardDataController::class, 'droneLocations']);
