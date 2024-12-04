<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpiryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->role == 1) {
            $date = auth()->user()->expiry_date;
        }
        if (auth()->user()->role == 2) {
            $parentId = auth()->user()->parent_id;
            $date = User::find($parentId)->expiry_date;
        }

        if (Carbon::parse($date)->isPast()) {
            return redirect()->route('packages');
        }

        return $next($request);
    }
}

