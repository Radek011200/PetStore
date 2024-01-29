<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PetController::class, 'index'])->name('pet.index');
Route::get('/create-pet', [PetController::class, 'showCreatePetForm']);
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::get('/pets/search', [PetController::class, 'searchForm'])->name('pets.searchForm');
Route::get('/pets/{id}/show', [PetController::class, 'show'])->name('pets.show');
Route::get('/pets/{id}/delete', [PetController::class, 'delete'])->name('pets.delete');
Route::get('/pets/upload-foto', [PetController::class, 'uploadFoto'])->name('pets.uploadPhoto');
