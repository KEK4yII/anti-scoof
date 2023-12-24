<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register(Request $request): array {

        $validator = Validator::make($request->json()->all(), [
            "login" => "required|string|min:5|max:30",
            "password" => "required|string|min:8|max:50"
        ]);

        if ($validator->fails()) {
            return $this->failedResponse($validator->errors()->all());
        }

        User::create([
            "login" => $validator->login,
            "password" => Hash::make($validator->password),
        ]);

        return $this->successResponse();
    }

    public function login(Request $request): array {
        $validator = Validator::make($request->json()->all(), [
            "login" => "required|string",
            "password" => "required|string"
        ]);

        $failedResponse = $this->failedResponse(["Неверный логин или пароль!"]);

        if ($validator->fails()) {
            return $failedResponse;
        }

        $user = User::where(["login" => $validator->login]);

        if (!$user) {
            return $failedResponse;
        }

        if (Hash::check($validator->password, $user->password)) {
            return ["jwt" => JWT::encode(["uid" => $user->id], env("JWT_SECRET"), "HS256")];
        } else {
            return $failedResponse;
        }

    }
}
