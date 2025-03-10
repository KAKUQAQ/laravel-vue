<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * 需要排除 CSRF 保护的 API 路由
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*', // 让 Vue 访问 API 时不会触发 CSRF 保护
        'sanctum/csrf-cookie', // 允许 Sanctum 认证
        'register', // ✅ 允许注册时绕过 CSRF
        'login', // ✅ 允许登录绕过 CSRF
    ];
}
