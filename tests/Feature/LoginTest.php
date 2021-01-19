<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Objetos para gerar dados fakes
     *
     * @var object
     */
    protected $faker;

    /**
     * Objeto com usuário criado para testes
     *
     * @var object
     */
    protected $user;

    /**
     * Senha para testes
     *
     * @var array
     */
    protected $password = '123456789';

    /**
     * Carrega os dados necessários para os testes
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->user = User::factory()->create(['password' => Hash::make($this->password)]);
    }

    /**
     * Testa a rota de login de um usuário, verificando se retornou 302
     *
     * @return void
     */

    public function testUserLogin()
    {
        $response = $this->withoutMiddleware(Cors::class)->post('/login', [
            'email' => $this->user->email,
            'password' => $this->password,
            'remember' => $this->faker->randomElement(['on', 'off']),
        ]);

        $response->assertStatus(302);
    }
}
