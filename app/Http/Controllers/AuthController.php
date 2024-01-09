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
            $scope = $request->header('scope', 'users');

            /** @var \App\Models\User $user */
            $user = $this->service->login($credentials, $scope);

            return new AuthResource($user);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | min:3',
                'email' => 'required | email | unique:users | unique:customers,email',
                'scope' => 'required | in:users,customers',
                'password' => 'required | min:6',
                'phone_number' => 'required | numeric',
                'cpf_cnpj' => 'required | numeric',
                'zipcode' => 'numeric',
                'street' => 'required_with:zipcode',
                'number' => 'required_with:zipcode',
                'neighborhood' => 'required_with:zipcode',
                'city' => 'required_with:zipcode',
                'state' => 'required_with:zipcode',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $fields = $request->only([
                'name',
                'email',
                'password',
                'scope',
                'phone_number',
                'cpf_cnpj',
                'zipcode',
                'street',
                'number',
                'neighborhood',
                'city',
                'state',
            ]);

            $values = $request->only($fields);
            $user = $this->service->create($values);

            return new AuthResource($user);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }
}
