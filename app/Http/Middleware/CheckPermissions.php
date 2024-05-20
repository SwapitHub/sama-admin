<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Get the authenticated admin user
         $adminUser = auth()->guard('admin')->user();
         if ($adminUser) {
            if (empty($adminUser->role_id)) {
                return $next($request);
            }
            $role = Role::find($adminUser->role_id);
            $permissions = explode(',', $role->permissions);
            $route = $request->route()->getName();
            $method = $request->getMethod();
            $isAllowed = false;

            foreach ($permissions as $allowed_permission) {
                $perm = Permission::find($allowed_permission);
                $perm = $perm->permissions;
                $permissionParts = explode('###', $perm);
                foreach ($permissionParts as $permissionPart) {
                    list($allowedMethod, $allowedRoute) = explode(' :: ', $permissionPart);
                    // Check if the user has permission for the requested route and method
                    if ($method === $allowedMethod && $route === $allowedRoute) {
                        $isAllowed = true;
                        break 2; // Exit both inner and outer loops
                    }
                }
            }
            if (!$isAllowed) {
                // return response('Not Allowed', Response::HTTP_FORBIDDEN);
                return response()->view('admin.error-page', [], Response::HTTP_FORBIDDEN);
            }
         }else{
            return response('Admin User not authenticated', Response::HTTP_FORBIDDEN);
        }
         return $next($request);
    }
}
