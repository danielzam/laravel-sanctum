<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class SanctumTokenValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $expiration = config('sanctum.expiration');
        if ($token = $request->bearerToken()) {
            $model = Sanctum::$personalAccessTokenModel;

            $accessToken = $model::findToken($token);

            if (! $accessToken) {
                return response()->json([
                    'access' => 'Token Inválido!'
                ], 401);
            }

            if ($expiration &&
                    $accessToken->created_at->lte(now()->subMinutes($expiration))) {
                return response()->json([
                    'access' => 'Token Expirado!'
                ], 401);
            }
        }
        else {
            return response()->json([
                'access' => 'No tiene acceso a esta área!'
            ], 401);
        }

        return $next($request);
    }
}
