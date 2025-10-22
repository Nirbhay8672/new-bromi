<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('dashboard', function () {
    $totalUsers = \App\Models\User::count();
    
    return Inertia::render('Dashboard', [
        'totalUsers' => $totalUsers
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('index-test', function () {
    return Inertia::render('IndexTest');
})->name('index-test');

// Admin routes with role/permission middleware
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->name('dashboard');
    
    
    Route::get('/permissions', [App\Http\Controllers\AdminController::class, 'permissions'])
        ->name('permissions');
    
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])
        ->name('users');
    
    // User CRUD API routes
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])
        ->name('users.store');
    
    Route::put('/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])
        ->name('users.update');
    
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])
        ->name('users.delete');
    
    // Role CRUD routes
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::post('/roles/{role}/sync-permissions', [App\Http\Controllers\RoleController::class, 'syncPermissions'])
        ->name('roles.sync-permissions');
    
    // Permission CRUD routes
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    
    // Role management actions
    Route::post('/assign-role', [App\Http\Controllers\AdminController::class, 'assignRole'])
        ->name('assign-role');
    
    Route::delete('/remove-role', [App\Http\Controllers\AdminController::class, 'removeRole'])
        ->name('remove-role');
    
    // Permission management actions
    Route::post('/give-permission-to-role', [App\Http\Controllers\AdminController::class, 'givePermissionToRole'])
        ->name('give-permission-to-role');
    
    Route::delete('/revoke-permission-from-role', [App\Http\Controllers\AdminController::class, 'revokePermissionFromRole'])
        ->name('revoke-permission-from-role');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
