<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRegister()
    {
        $fake = Factory::create();

        $response = $this->withoutMiddleware(Cors::class)->post('/register', [
            'name' => $fake->name,
            'email' => $fake->unique()->safeEmail,
            'password' => $fake->password,
            'password_confirmation' => $fake->password,
        ]);

        $response->assertStatus(302);
    }
}
