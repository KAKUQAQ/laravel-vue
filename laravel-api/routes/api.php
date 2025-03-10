<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return response()->json(['message' => 'Laravel API is working!']);
});

// ✅ 添加注册路由
Route::post('/register', [RegisteredUserController::class, 'store']);

// ✅ 添加登录路由
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// ✅ 添加登出路由
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');

// ✅ 获取用户信息（需要 Sanctum 认证）
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
