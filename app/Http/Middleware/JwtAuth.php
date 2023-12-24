<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Traits\ResponseTrait;
use App\Models\User;

class JwtAuth
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->header('Authorization');
        $jwt = preg_replace("#^Bearer #", "", $jwt);
        $secret = env("JWT_SECRET");
        if ($jwt === "") {
            $response = $this->failedResponse(["Not logged"]);
            return new Response(json_encode($response), 500);
        }

        try {
            $jwt = JWT::decode($jwt, new Key($secret, "HS256"));
        } catch (SignatureInvalidException $e) {
            $response = $this->failedResponse([$e->getMessage()]);
            return new Response(json_encode($response), 500);
        }

        $jwt = json_decode($jwt, true);

        if ($jwt["exp"] > time()) {
            $response = $this->failedResponse(["JWT expired"]);
            return new Response(json_encode($response), 500);
        }

        $user = User::find($jwt["uid"]);

        if ($user === null) {
            $response = $this->failedResponse(["User not found!"], 401);
            return new Response(json_encode($response), 401);
        }

        $request->userInstance = $user;

        return $next($request);
    }
}
