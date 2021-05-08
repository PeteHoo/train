<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 10:25
 */

namespace App\Http\Middleware;


use App\Utils\ErrorCode;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('api')->guest()) {
            return response()->json(['code' => ErrorCode::AUTH_ERROR,'message' => '未设置token']);
        }
        return $next($request);
    }
}
