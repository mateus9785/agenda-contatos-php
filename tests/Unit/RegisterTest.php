<?php

namespace Tests\Unit;

use App\Services\RegisterService;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Injeção de dependência da service de registro de usuário
     *
     * @var object
     */
    protected $registerService;

    /**
     * Carrega os dados necessários para os testes
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->registerService = app(RegisterService::class);
    }

    /**
     * Testa o service de registro de usuário, verificando o email retornado
     *
     * @return void
     */
    public function testCreateRegister()
    {
        $fake = Factory::create();
        $name = $fake->name;
        $email = $fake->unique()->safeEmail;
        $password = $fake->password;

        $user = $this->registerService->create($name, $email, $password);

        $this->assertTrue($user->email == $email);
    }
}
