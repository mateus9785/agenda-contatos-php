<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\RegisterService;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    protected $registerService;

    public function setUp(): void
    {
        parent::setUp();

        $this->registerService = app(RegisterService::class);
    }

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