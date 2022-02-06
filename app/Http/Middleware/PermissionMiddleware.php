<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if ($permission !== null && !$request->user()->can($permission)) {
            $arrRoute = explode('.', $request->route()->getName());
            if ($arrRoute[2] == 'index') {
                return redirect()->route('backend.dashboard')->with('info', 'Bạn chưa được cấp quyền truy cập');
            } else {
                return redirect()->back()->with('warning', 'Bạn chưa được cấp quyền thực hiện');
            }
        }
        return $next($request);
    }
}
