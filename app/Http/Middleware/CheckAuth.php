<?php

namespace App\Http\Middleware;

use App\Models\Teacher;
use Closure;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;

class CheckAuth
{
    public function handle($request, Closure $next, $type = null)
    {
        $user = Admin::user();
        if ($user instanceof Administrator && $type == "student") {
            echo "没有访问权限";
            die;
        } elseif ($user instanceof Teacher && $type == 'teacher') {
            echo "没有访问权限";
            die;
        }


        return $next($request);
    }
}