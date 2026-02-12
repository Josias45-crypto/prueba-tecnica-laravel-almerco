<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LocationController;

// Ruta principal redirige al login
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Rutas para obtener estados y ciudades (AJAX)
Route::get('/api/states/{country}', [LocationController::class, 'getStates'])->name('api.states');
Route::get('/api/cities/{state}', [LocationController::class, 'getCities'])->name('api.cities');

// Rutas de administrador (protegidas por middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD de usuarios
    Route::resource('users', UserController::class);
    Route::get('users-data', [UserController::class, 'getData'])->name('users.data');
    
    // Emails (admin ve todos)
    Route::get('emails', [EmailController::class, 'index'])->name('emails.index');
});

// Rutas de usuarios normales (protegidas por auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Emails (usuarios ven solo los suyos)
    Route::resource('emails', EmailController::class)->only(['index', 'create', 'store']);
    Route::get('emails-data', [EmailController::class, 'getData'])->name('emails.data');
});
