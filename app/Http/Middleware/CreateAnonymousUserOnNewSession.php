<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CreateAnonymousUserOnNewSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_null($request->user()) === false) return $next($request);

        $newUser = User::create([
            'name' => 'Anonymous',
        ]);

        $newUser->creditAllocations()->create([
            'quantity_allocated' => config('casino.credit_allocation_quantity.on_new_anonymous_user', 0),
        ]);

        Auth::login($newUser, false);
        $request->session()->regenerate();

        return $next($request);        
    }
}
