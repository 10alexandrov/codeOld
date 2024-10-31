<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJefeSalonAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $allowedMethods = ['verMoneys', 'saveAuxData', 'getTicketsFilter', 'getTypes','updateAuxData','showLocal', 'showBar','showUsersmc','destroyTotal','syncUsersmcView','syncUsersrmc','search'];

        // Verifica si el usuario está autenticado
        if ($user && $user->hasRole('Jefe Salones')) {
            // Obtén el controlador y el método de la ruta actual
            $controller = class_basename($request->route()->getController());
            $action = $request->route()->getActionMethod();

            // Verifica si el controlador no es 'TicketsController' y si el método no está permitido
            if ($controller != 'TicketsController' && !in_array($action, ['index', 'show']) && !in_array($action, $allowedMethods)) {
                return redirect('/')->with('error', 'No tienes los permisos necesarios');
            }
        }

        return $next($request);

    }
}
