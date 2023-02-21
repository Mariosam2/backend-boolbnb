<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SearchMiddleware
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
        $services = $request->query('services');
        $category = $request->query('category');
        $address = $request->query('address');
        $radius = $request->query('radius');
        $beds = $request->query('beds');


        $request->services = $services;
        $request->category = $category;
        $request->address = $address;
        $request->radius = $radius;
        $request->beds = $beds;

        return $next($request);
    }
}
