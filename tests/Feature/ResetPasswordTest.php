<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPassword()
    {
        $user = User::factory()->create();

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->post('/password/email', [
            'email' => $user->email
        ]);

        $response->assertStatus(302);
    }
}
