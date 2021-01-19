<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Objeto com usuário criado para testes
     *
     * @var object
     */
    protected $user;

    /**
     * Objeto para facilitar fazer uma requisição
     *
     * @var object
     */
    protected $route;

    /**
     * Carrega os dados necessários para os testes
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->route = $this->actingAs($this->user)->withoutMiddleware(Cors::class);
    }

    /**
     * Testa a rota de mudança de senha, verificando se esta retornando 302
     *
     * @return void
     */

    public function testResetPassword()
    {
        $response = $this->route->post('/password/email', [
            'email' => $this->user->email
        ]);

        $response->assertStatus(302);
    }
}
