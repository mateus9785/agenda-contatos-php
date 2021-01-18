<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $route;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->route = $this->actingAs($this->user)->withoutMiddleware(Cors::class);
    }

    public function testResetPassword()
    {
        $response = $this->route->post('/password/email', [
            'email' => $this->user->email
        ]);

        $response->assertStatus(302);
    }
}
