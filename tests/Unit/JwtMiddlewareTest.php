<?php

namespace Tests\Unit;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Response;
use Tests\TestCase;

class JwtMiddlewareTest extends TestCase
{
    public function test_deve_conseguir_gerar_um_token_JWT()
    {
        $user = User::factory()->make();
        $token = $user->generateToken();

        $this->assertNotEmpty($token);
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $this->assertEquals($user->id, $credentials->sub);

        return $token;
    }

    /**
     * @depends test_deve_conseguir_gerar_um_token_JWT
     */
    public function test_deve_conseguir_limitar_o_acesso_por_escopo($token)
    {
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $request = $this->get('/customers', ['Authorization' => 'Bearer ' . $token]);

        if ($credentials->iss != "users") {
            $request->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
        } else {
            $request->assertResponseStatus(Response::HTTP_OK);
        }
    }

    public function test_nao_deve_permitir_acesso_sem_token()
    {
        $request = $this->get('/customers');
        $request->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }
}
