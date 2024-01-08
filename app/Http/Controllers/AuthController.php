<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private UserService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Autenticação de usuário
     *
     * @param Request $request
     * @return AuthResource|JsonResponse|\Illuminate\Support\MessageBag
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->only(['email', 'password']), [
                'email' => 'required | email | exists:users',
                'password' => 'required | min:6'
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $credentials = $request->only(['email', 'password']);

            /** @var \App\Models\User $user */
            $user = $this->service->login($credentials);

            return new AuthResource($user);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }
}
