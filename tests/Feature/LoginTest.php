<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserLogin()
    {
        $fake = Factory::create();
        $password = '123456789';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $response = $this->withoutMiddleware(Cors::class)->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => $fake->randomElement(['on', 'off']),
        ]);

        $response->assertStatus(302);
    }
}
