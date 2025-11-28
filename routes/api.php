<?php

use App\Http\Controllers\GestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/gestion/proyectos-por-tier/{tier}', [GestionController::class, 'getProyectosPorTier'])->name('api.gestion.proyectos-por-tier');
    Route::get('/gestion/staff-por-rol/{rol}', [GestionController::class, 'getStaffPorRol'])->name('api.gestion.staff-por-rol');
});
