<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| 这里使用了 Sanctum 提供的保护机制，前端需携带凭证 (withCredentials)
| 并在请求头中带上正确的 XSRF-Token 才能通过验证。
| 你可以在前端先请求 /sanctum/csrf-cookie 来获取 CSRF Token。
|
| 如果要使用 Laravel Breeze API + Sanctum，需要在 config/sanctum.php 中
| 将 stateful 域名配置好，并且在 .env 里正确设置 SANCTUM_STATEFUL_DOMAINS。
|--------------------------------------------------------------------------
*/

// 匿名用户可访问的路由
Route::middleware('guest')->group(function () {
    // 用户注册
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register');

    // 用户登录
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    // 请求重置密码链接
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // 重置密码
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

// 已经通过 Sanctum 认证的用户才可访问的路由
Route::middleware(['auth:sanctum'])->group(function () {
    // 发送邮箱验证邮件
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1') // 限制用户一分钟内只能请求 6 次
        ->name('verification.send');

    // 验证邮箱（从邮件链接点击过来，要求链接携带签名）
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware('signed')
        ->name('verification.verify');

    // (可选) 获取当前登录用户的信息
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    // 用户登出
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
