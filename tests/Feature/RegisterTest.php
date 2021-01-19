<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * Testa a rota de cadastro de um usuário verificando se está retornando 302
     *
     * @return void
     */

    public function testUserRegister()
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
