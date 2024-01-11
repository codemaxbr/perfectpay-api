<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Response;

/**
 * Class JwtMiddleware
 * @package App\Http\Middleware
 */
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        if(empty($token) || is_null($token)) {
            // Unauthorized response if token not there
            throw new Exception('Token not provided.', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $request['user_id'] = $credentials->sub;
            $request['scope'] = $credentials->iss;

            if ($credentials->iss != "users") {
                return response()->json([
                    'status' => false,
                    'error' => 'Acesso restrito apenas para Usuários'
                ], Response::HTTP_UNAUTHORIZED);
            }

            return $next($request);

        } catch (ExpiredException $e) {
            throw new Exception('Provided token is expired.', Response::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
    }
}
