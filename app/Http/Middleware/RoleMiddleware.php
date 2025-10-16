<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
      $user = Auth::user();
    Log::info('Evaluando roles', [
        'user_id' => $user->id ?? null,
        'user_role' => $user->id_rol ?? null,
        'required_roles' => $roles,
    ]);

    if (!$user || !in_array($user->id_rol, $roles)) {
        Log::warning('Acceso denegado', [
            'user_id' => $user->id ?? null,
            'user_role' => $user->id_rol ?? null,
            'required_roles' => $roles,
        ]);
        abort(403, 'No tienes permiso para acceder a esta página.');
    }

    return $next($request);
    }
}
