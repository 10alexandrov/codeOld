<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Zone;
use App\Models\Local;


class CheckTecnicoAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->hasRole('Tecnico')) {

            // Permitir acceso a todos los métodos del LoadsController, excepto al método delete
            if ($request->route()->getController() instanceof \App\Http\Controllers\LoadsController) {
                if ($request->route()->getActionMethod() === 'delete') {
                    return redirect('/')->with('error', 'No tienes permisos para eliminar.');
                }
                return $next($request);
            }

            // Permitir solo el acceso a los métodos index y show
            $allowedMethods = ['index', 'show','saveAuxData','getTicketsFilter','getTypes','verMoneys','updateAuxData','showLocal', 'showBar'];
            $routeName = $request->route()->getName();
            $delegationIds = $user->delegation()->pluck('delegations.id')->toArray();

            // Verificar si el controlador es ArqueosController
            if ($request->route()->getController() instanceof \App\Http\Controllers\ArqueosController) {
                // Permitir store y update en ArqueosController
                if (in_array($request->route()->getActionMethod(), ['store', 'update'])) {
                    return $next($request);
                }
            }

            if (!in_array($request->route()->getActionMethod(), $allowedMethods)) {
                return redirect('/')->with('error', 'No tienes los permisos necesarios');
            }

            // Verificar si el técnico pertenece a la delegación solicitada en caso de método show
            if ($request->route('delegation')) {
                $delegacionId = $request->route('delegation');
                $hasAccess = $user->delegation()->where('delegations.id', $delegacionId)->exists();

                if (!$hasAccess) {
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
