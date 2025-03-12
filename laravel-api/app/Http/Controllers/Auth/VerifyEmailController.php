<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * 处理邮箱验证并自动登录用户，然后跳转到个人信息页面。
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // 1. 根据路由中的 {id} 查找用户
        $user = User::findOrFail($request->route('id'));

        // 2. 校验 URL 中的 {hash} 是否与用户邮箱的哈希值匹配
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, '邮箱验证链接无效。');
        }

        // 3. 如果用户尚未验证邮箱，则标记为已验证
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        // 4. 自动登录用户
        Auth::login($user);

        // 5. 跳转到前端个人信息页面
        return redirect()->away(config('app.frontend_url') . '/profile?verified=1');
    }
}
