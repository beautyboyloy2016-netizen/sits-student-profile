<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user = auth()->user();
    if (! $user) {
      return $next($request);
    }

    // Super Admin bypass: always granted full access regardless of pivot state.
    Gate::before(function ($user, $ability) {
      if ($user->roles && $user->roles->contains('name', 'super_admin')) {
        return true;
      }
      return null;
    });

    $roles            = Role::with('permissions')->get();
    $permissionsArray = [];

    foreach ($roles as $role) {
      foreach ($role->permissions as $permissions) {
        $permissionsArray[$permissions->name][] = $role->id;
      }
    }
    foreach ($permissionsArray as $title => $roles) {
      Gate::define($title, function ($user) use ($roles) {
        return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
      });
    }
    return $next($request);
  }
}
