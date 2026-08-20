<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Objetos para gerar dados fakes
     *
     * @var object
     */
    protected $faker;

    /**
     * Carrega os dados necessários para os testes
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * Testa a rota de cadastro de um usuário verificando se está retornando 302
     *
     * @return void
     */
    public function test_user_register()
    {
        $password = $this->faker->password;

        $response = $this->withoutMiddleware(Cors::class)->post('/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(302);
    }
}
