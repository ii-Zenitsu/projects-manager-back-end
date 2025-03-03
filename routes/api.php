<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ParticipationController;
use App\Http\Middleware\CheckRole;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
    return "Bienvenue Admin !";
    });
   });

Route::post("/login",[AuthController::class,"login"]);
Route::post("/register",[AuthController::class,"register"]);

Route::apiResource('formations', FormationController::class);

Route::get("/projets/closed", [ProjetController::class, "getClosed"]);
Route::get("/projets/late", [ProjetController::class, "getLate"]);
Route::get("/projets/closedwithlate", [ProjetController::class, "getClosedWithLate"]);

Route::apiResource('participations', ParticipationController::class)->middleware('auth:sanctum');
Route::apiResource('personnes', PersonneController::class);
Route::apiResource('projets', ProjetController::class);
Route::apiResource('projets', ProjetController::class);

Route::get("/personnes/{id}/projets", [PersonneController::class, "getProjets"]);
Route::get("/projets/{id}/personnes", [ProjetController::class, "getPersonnes"]);
Route::post("/projets/{id}/attach-personnes", [ProjetController::class, "attachPersonnes"]);




