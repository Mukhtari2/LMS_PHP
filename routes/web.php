<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup-admin', function () {
    $user = User::updateOrCreate(
        ['email' => 'admin@test.com'], // Don't duplicate if exists
        [
            'name' => 'Super Admin',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]
    );
    return "Admin created successfully! Email: admin@test.com, Password: password123";
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
