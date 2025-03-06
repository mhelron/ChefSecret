<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\OutletsController;
use App\Http\Controllers\InventoryController;

use App\Http\Middleware\Auth;
use App\Http\Middleware\VerifyRoles;

// Login Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.index');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'sendResetLink'])->name('password.reset.send');
Route::get('/new-password', [PasswordResetController::class, 'showNewPasswordForm'])->name('password.new');
Route::post('/new-password', [PasswordResetController::class, 'confirmReset'])->name('password.reset.confirm');

// Email Verification Routes
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])->name('verification.send');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

Route::view('/unauthorized', 'layouts.unauthorized')->name('unauthorized');

// Middleware
Route::middleware([Auth::class])->group(function () {

    // Verify Role
    Route::group(['middleware' => VerifyRoles::class . ':Super Admin,Admin,Manager,Staff'], function () {

        // Dashboard Route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Inventory Route
        Route::prefix('/inventory')->group(function () {
            Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
            Route::get('add-inventory', [InventoryController::class, 'create'])->name('inventory.add');
            Route::post('add-inventory', [InventoryController::class, 'store'])->name('inventory.store');
            Route::get('edit-inventory/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
            Route::put('update-inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
            Route::get('delete-inventory/{id}', [InventoryController::class, 'archive'])->name('inventory.delete');
            Route::get('get-category-fields/{id}', [InventoryController::class, 'getCategoryFields'])->name('inventory.category.fields');
        });
    });

    // Verify Role
    Route::group(['middleware' => VerifyRoles::class . ':Super Admin,Admin'], function () {

        // Users Route
        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('add-user', [UserController::class, 'create'])->name('users.add');
            Route::post('add-user', [UserController::class, 'store'])->name('users.store');
            Route::get('edit-user/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::put('update-user/{id}', [UserController::class, 'update'])->name('users.update');
            Route::get('delete-user/{id}', [UserController::class, 'archive'])->name('users.delete');
        });

        // Categories Route
        Route::prefix('/categories')->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
            Route::get('add-category', [CategoriesController::class, 'create'])->name('categories.add');
            Route::post('add-category', [CategoriesController::class, 'store'])->name('categories.store');
            Route::get('edit-category/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
            Route::put('update-category/{id}', [CategoriesController::class, 'update'])->name('categories.update');
            Route::get('delete-category/{id}', [CategoriesController::class, 'archive'])->name('categories.delete');
        });

        // Departments Route
        Route::prefix('/departments')->group(function () {
            Route::get('/', [DepartmentsController::class, 'index'])->name('departments.index');
            Route::get('add-department', [DepartmentsController::class, 'create'])->name('departments.add');
            Route::post('add-department', [DepartmentsController::class, 'store'])->name('departments.store');
            Route::get('edit-department/{id}', [DepartmentsController::class, 'edit'])->name('departments.edit');
            Route::put('update-department/{id}', [DepartmentsController::class, 'update'])->name('departments.update');
            Route::get('delete-department/{id}', [DepartmentsController::class, 'archive'])->name('departments.delete');
        });

        // Outlets Route
        Route::prefix('/outlets')->group(function () {
            Route::get('/', [OutletsController::class, 'index'])->name('outlets.index');
            Route::get('add-outlet', [OutletsController::class, 'create'])->name('outlets.add');
            Route::post('add-outlet', [OutletsController::class, 'store'])->name('outlets.store');
            Route::get('edit-outlet/{id}', [OutletsController::class, 'edit'])->name('outlets.edit');
            Route::put('update-outlet/{id}', [OutletsController::class, 'update'])->name('outlets.update');
            Route::get('delete-outlet/{id}', [OutletsController::class, 'archive'])->name('outlets.delete');
        });
    });
}); 
