<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth("admin")->check()){

            $user = auth("admin")->user();
            $permissions = $user->getAllPermissions()->pluck("name","name")->toArray();

            $permissions["admin.home.index"] = "admin.home.index";
            $permissions["admin.admin.logout"] = "admin.admin.logout";
            $permissions["admin.profile.edit"] = "admin.profile.edit";
            $permissions["admin.profile.update"] = "admin.profile.update";
            $permissions["admin.logout"] = "admin.logout";

            if(! in_array($request->route()->getAction("as"), $permissions)){

                if($request->ajax()){
                    return response()->error(trans("messages.common.permission_error_message"),[], 403);
                }

                return response(view("admin.error.403"));
            }
        }

        return $next($request);
    }
}
