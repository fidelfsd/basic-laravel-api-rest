<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = Auth::user()->role_id;

        if ($userRole !== UserRole::ADMIN->value) {
            $data = [
                'message' => 'You are not allowed to access this resource',
            ];
            return response()->json($data, Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
