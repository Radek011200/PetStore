<?php

use App\Http\Controllers\PetApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/pets/{pet}', [PetApiController::class, 'show'])->name('pet.index');
Route::get('/pets/findByStatus/{status}', [PetApiController::class, 'findByStatus'])->name('pet.findByStatus');
Route::post('/pets/store', [PetApiController::class, 'store'])->name('pet.store');
Route::put('/pets', [PetApiController::class, 'update'])->name('pet.update');
Route::delete('/pets/{pet}', [PetApiController::class, 'destroy'])->name('pet.destroy');
Route::post('/pets/upload-image', [PetApiController::class, 'uploadPetImage'])->name('pet.uploadPetImage');
