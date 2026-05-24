<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;


class EsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //si no es usuario deniega acceso y redirige
        if (Gate::denies('es-admin')){
            abort(403, 'Lo sentimos. No tiene permiso de acceder aquí.'); //redirige al usuario no autorizado y le lanza el error
        }
        return $next($request);
    }
}
