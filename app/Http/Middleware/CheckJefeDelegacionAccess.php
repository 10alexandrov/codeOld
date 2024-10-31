<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Zone;
use App\Models\User;
use App\Models\Delegation;
use App\Models\Local;

class CheckJefeDelegacionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $delegationIds = $user->delegation()->pluck('delegations.id')->toArray();

        if ($user->hasRole('Jefe Delegacion')) {
            $routeName = $request->route()->getName();

            // Restricciones para el controlador BossDelegationController
            if (strpos($routeName, 'bossDelegations') !== false) {
                return redirect('/')->with('error', 'No tienes los permisos necesarios');
            }

            // Permitir solo el acceso a los métodos index y show del controlador DelegationsController
            if (strpos($routeName, 'delegations') !== false && !in_array($request->method(), ['GET', 'HEAD'])) {
                return redirect('/')->with('error', 'No tienes los permisos necesarios');
            }
            // Verificar si la ruta pertenece al controlador DelegationsController y si el usuario tiene acceso a la delegación
            if (strpos($routeName, 'delegations') !== false && $request->route('delegation')) {
                $delegationId = $request->route('delegation');
                // Verificar si el usuario tiene acceso a la delegación solicitada
                if (!$user->delegation()->where('delegations.id', $delegationId)->exists()) {
                    return redirect('/')->with('error', 'No tienes los permisos necesarios');
                }
            }

            // Verificar si la ruta pertenece al controlador ZonesController y si el usuario tiene acceso a la zona
            if (strpos($routeName, 'zones') !== false && $request->route('zone')) {
                $zoneId = $request->route('zone');
                // Verificar si la zona está asociada a alguna de las delegaciones asociadas al usuario
                $associatedZones = Zone::whereIn('delegation_id', $delegationIds)->pluck('id')->toArray();
                if (!in_array($zoneId, $associatedZones)) {
                    return redirect('/')->with('error', 'No tienes los permisos necesarios');
                }
            }

            // Verificar si la ruta pertenece al controlador UsersController y si el usuario tiene acceso al usuario
            if (strpos($routeName, 'users') !== false && $request->route('user')) {
                $userFromRoute = $request->route('user');
                $userId = $userFromRoute instanceof User ? $userFromRoute->id : (int) $userFromRoute;
                // Verificar si el usuario está asociado a alguna de las delegaciones asociadas al jefe técnico
                $associatedUsers = User::whereHas('delegation', function ($query) use ($delegationIds) {
                    $query->whereIn('delegation_id', $delegationIds);
                })->pluck('id')->toArray();
                if (!in_array($userId, $associatedUsers)) {
                    return redirect('/')->with('error', 'No tienes los permisos necesarios');
                }
            }

            // Verificar si la ruta pertenece al controlador LocalesController y si el usuario tiene acceso al local
            if (strpos($routeName, 'locals') !== false && $request->route('local')) {
                $localId = $request->route('local');
                // Obtener las zonas asociadas al usuario
                $zoneIds = Zone::whereIn('delegation_id', $delegationIds)->pluck('id')->toArray();
                // Verificar si el local está asociado a alguna de las zonas asociadas al usuario
                $associatedLocales = Local::whereIn('zone_id', $zoneIds)->pluck('id')->toArray();
                if (!in_array($localId, $associatedLocales)) {
                    return redirect('/')->with('error', 'No tienes los permisos necesarios');
                }
            }
        }

        return $next($request);
    }
}
