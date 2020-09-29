<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VendorAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $is_vendor = is_null(auth()->user()) ? false : auth()->user()->isVendor();
        return ( Auth::check() or  $is_vendor)? $next($request) : respond('Unauthorized', 401);
    }
}
