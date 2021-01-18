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

    protected $faker;
    protected $user;
    protected $password = '123456789';

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->user = User::factory()->create(['password' => Hash::make($this->password)]);
    }

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
