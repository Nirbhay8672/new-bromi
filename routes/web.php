<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes with role/permission middleware
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->middleware('permission:view-dashboard')
        ->name('dashboard');
    
    Route::get('/roles', [App\Http\Controllers\AdminController::class, 'roles'])
        ->middleware('permission:manage-roles')
        ->name('roles');
    
    Route::get('/permissions', [App\Http\Controllers\AdminController::class, 'permissions'])
        ->middleware('permission:manage-permissions')
        ->name('permissions');
    
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])
        ->middleware('permission:manage-users')
        ->name('users');
    
    // Role management actions
    Route::post('/assign-role', [App\Http\Controllers\AdminController::class, 'assignRole'])
        ->middleware('permission:manage-roles')
        ->name('assign-role');
    
    Route::delete('/remove-role', [App\Http\Controllers\AdminController::class, 'removeRole'])
        ->middleware('permission:manage-roles')
        ->name('remove-role');
    
    // Permission management actions
    Route::post('/give-permission-to-role', [App\Http\Controllers\AdminController::class, 'givePermissionToRole'])
        ->middleware('permission:manage-permissions')
        ->name('give-permission-to-role');
    
    Route::delete('/revoke-permission-from-role', [App\Http\Controllers\AdminController::class, 'revokePermissionFromRole'])
        ->middleware('permission:manage-permissions')
        ->name('revoke-permission-from-role');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
