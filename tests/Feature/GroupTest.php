<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use Asm89\Stack\Cors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GroupTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    protected $faker;
    protected $groups;
    protected $route;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $user = User::factory()->create();
        $this->groups = Group::factory(10)->create(['user_id' => $user->id]);

        $this->route = $this->actingAs($user)->withoutMiddleware(Cors::class);
    }

    public function testGroupIndex()
    {
        $response = $this->route->get('/group');

        $response->assertStatus(200);
    }

    public function testGroupStore()
    {
        $response = $this->route->post('/group', [
            'name' => $this->faker->name,
        ]);

        $response->assertStatus(200);
    }

    public function testGroupUpdate()
    {
        $response = $this->route->put('/group/' . $this->groups[0]->id, [
            'name' => $this->faker->name,
        ]);

        $response->assertStatus(200);
    }

    public function testGroupDelete()
    {
        $response = $this->route->delete('/group/' . $this->groups[0]->id);

        $response->assertStatus(200);
    }
}
