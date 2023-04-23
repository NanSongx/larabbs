<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;  // 这是注入

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 设定了所有的控制器动作都需要登录后才能访问。
        $this->middleware('auth');
        // 只有 verify 动作使用 signed 中间件进行认证， signed 中间件是一种由框架提供的很方便的 URL 签名认证方式
        $this->middleware('signed')->only('verify');
        // 对 verify 和 resend 动作做了频率限制，1 分钟内不能超过 6 次。throttle 中间件是框架提供的访问频率限制功能，throttle 中间件会接收两个参数，这两个参数决定了在给定的分钟数内可以进行的最大请求数。
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
