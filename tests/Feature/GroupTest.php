<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Group;
use App\Models\User;
use Faker\Factory;
use Asm89\Stack\Cors;

class GroupTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testGroupIndex()
    {
        $user = User::factory()->create();
        Group::factory(10)->create(['user_id' => $user->id]);
        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->get('/group');

        $response->assertStatus(200);
    }

    public function testGroupStore()
    {
        $fake = Factory::create();

        $user = User::factory()->create();
        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->post('/group', [
            'name' => $fake->name,
        ]);

        $response->assertStatus(200);
    }

    public function testGroupUpdate()
    {
        $fake = Factory::create();

        $user = User::factory()->create();
        $group = Group::factory()->create(['user_id' => $user->id]);

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->put('/group/' . $group->id, [
            'name' => $fake->name,
        ]);

        $response->assertStatus(200);
    }

    public function testGroupDelete()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create(['user_id' => $user->id]);

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->delete('/group/' . $group->id);

        $response->assertStatus(200);
    }
}
