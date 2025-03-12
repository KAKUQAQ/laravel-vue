<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * 在 Laravel 8+ 里，默认不会再自动设置控制器命名空间，
     * 如果想复用老的命名空间写法，可使用 $this->namespace = 'App\\Http\\Controllers';
     * 并在 map() / routes() 中 ->namespace($this->namespace)。
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * 在这里进行路由加载等初始化
     */
    public function boot()
    {
        // Laravel 8+ 推荐的写法：使用 $this->routes(...)
        $this->routes(function () {
            // 加载 api.php，并带上 "/api" 前缀
            Route::prefix('api')            // <-- 关键：设定 prefix('api')
                 ->middleware('api')       // <-- 走 'api' 中间件组
                 // ->namespace($this->namespace) // 如需老式命名空间可取消注释
                 ->group(base_path('routes/api.php'));

            // （可选）加载 web.php，如果你有传统 Web 路由需求
            Route::middleware('web')
                 // ->namespace($this->namespace)
                 ->group(base_path('routes/web.php'));
        });
    }
}
