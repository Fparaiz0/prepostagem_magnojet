<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\SenderController;
use Illuminate\Support\Facades\Route;

// Página inicial do site 
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tela de login 
Route::get('/login', [AuthController::class, 'index'])->name('login');

// Processar os dados do login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Formulário cadastrar novo usuário 
Route::get('/register', [AuthController::class, 'create'])->name('register');

// Receber os dados do formulário e cadastrar novo usuário
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

// Solicitar link para resetar a senha  
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Formulário para redefinir a senha com o token 
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showRequestForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Grupo de rotas restritas
Route::group(['middleware' => 'auth'], function () {

    // Página inicial do Administrativo
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('permission:dashboard');;

    // Página de Perfil
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show')->middleware('permission:show-profile');;
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('permission:edit-profile');;
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update')->middleware('permission:edit-profile');;
        Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit_password')->middleware('permission:edit-password-profile');;
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update_password')->middleware('permission:edit-password-profile');;
    });

    // Usuários
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware('permission:index-user');;
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create-user');;
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:show-user');;
        Route::post('/', [UserController::class, 'store'])->name('users.store')->middleware('permission:create-user');;
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit-user');;
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit-user');;
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:destroy-user');;
        Route::get('/{user}/edit-password', [UserController::class, 'editPassword'])->name('users.edit_password')->middleware('permission:edit-password-user');;
        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update_password')->middleware('permission:edit-password-user');;
    });

    // Usuários Status
    Route::prefix('user-statuses')->group(function () {
        Route::get('/', [UserStatusController::class, 'index'])->name('user_statuses.index')->middleware('permission:index-user-status');;
        Route::get('/create', [UserStatusController::class, 'create'])->name('user_statuses.create')->middleware('permission:create-user-status');;
        Route::get('/{userStatus}', [UserStatusController::class, 'show'])->name('user_statuses.show')->middleware('permission:show-user-status');;
        Route::post('/', [UserStatusController::class, 'store'])->name('user_statuses.store')->middleware('permission:create-user-status');;
        Route::get('/{userStatus}/edit', [UserStatusController::class, 'edit'])->name('user_statuses.edit')->middleware('permission:edit-user-status');;
        Route::put('/{userStatus}', [UserStatusController::class, 'update'])->name('user_statuses.update')->middleware('permission:edit-user-status');;
        Route::delete('/{userStatus}', [UserStatusController::class, 'destroy'])->name('user_statuses.destroy')->middleware('permission:destroy-user-status');;
    });

    // Papéis
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:index-role');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create-role');
        Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:show-role');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:create-role');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:edit-role');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:edit-role');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:destroy-role');
    });

    // Permissão do papel 
    Route::prefix('role-permissions')->group(function () {
        Route::get('/{role}', [RolePermissionController::class, 'index'])->name('role-permissions.index')->middleware('permission:index-role-permission');
        Route::get('/{role}/{permission}', [RolePermissionController::class, 'update'])->name('role-permissions.update')->middleware('permission:update-role-permission');  
    });

    // Permissão
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:index-permission');
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create-permission');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('permission:show-permission');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:create-permission');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:edit-permission');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:edit-permission');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:destroy-permission');
    });

    // Embalagens
    Route::prefix('packagings')->group(function () {
        Route::get('/', [PackagingController::class, 'index'])->name('packagings.index')->middleware('permission:index-packaging');;
        Route::get('/create', [PackagingController::class, 'create'])->name('packagings.create')->middleware('permission:create-packaging');;
        Route::get('/{packaging}', [PackagingController::class, 'show'])->name('packagings.show')->middleware('permission:show-packaging');;
        Route::post('/', [PackagingController::class, 'store'])->name('packagings.store')->middleware('permission:create-packaging');;
        Route::get('/{packaging}/edit', [PackagingController::class, 'edit'])->name('packagings.edit')->middleware('permission:edit-packaging');;
        Route::put('/{packaging}', [PackagingController::class, 'update'])->name('packagings.update')->middleware('permission:edit-packaging');;
        Route::delete('/{packaging}', [PackagingController::class, 'destroy'])->name('packagings.destroy')->middleware('permission:destroy-packaging');;
    });

    // Remetentes
    Route::prefix('sender')->group(function () {
        Route::get('/', [SenderController::class, 'index'])->name('senders.index')->middleware('permission:index-sender');;
        Route::get('/create', [SenderController::class, 'create'])->name('senders.create')->middleware('permission:create-sender');;
        Route::get('/{sender}', [SenderController::class, 'show'])->name('senders.show')->middleware('permission:show-sender');;
        Route::post('/', [SenderController::class, 'store'])->name('senders.store')->middleware('permission:create-sender');;
        Route::get('/{sender}/edit', [SenderController::class, 'edit'])->name('senders.edit')->middleware('permission:edit-sender');;
        Route::put('/{sender}', [SenderController::class, 'update'])->name('senders.update')->middleware('permission:edit-sender');;
        Route::delete('/{sender}', [SenderController::class, 'destroy'])->name('senders.destroy')->middleware('permission:destroy-sender');;
    });

    // Destinatários
    Route::prefix('recipient')->group(function () {
        Route::get('/', [RecipientController::class, 'index'])->name('recipients.index')->middleware('permission:index-recipient');;
        Route::get('/create', [RecipientController::class, 'create'])->name('recipients.create')->middleware('permission:create-recipient');;
        Route::get('/{recipient}', [RecipientController::class, 'show'])->name('recipients.show')->middleware('permission:show-recipient');;
        Route::post('/', [RecipientController::class, 'store'])->name('recipients.store')->middleware('permission:create-recipient');;
        Route::get('/{recipient}/edit', [RecipientController::class, 'edit'])->name('recipients.edit')->middleware('permission:edit-recipient');;
        Route::put('/{recipient}', [RecipientController::class, 'update'])->name('recipients.update')->middleware('permission:edit-recipient');;
        Route::delete('/{recipient}', [RecipientController::class, 'destroy'])->name('recipients.destroy')->middleware('permission:destroy-recipient');;
    });

});
