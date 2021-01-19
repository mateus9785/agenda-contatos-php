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

    /**
     * Objetos para gerar dados fakes
     *
     * @var object
     */
    protected $faker;

    /**
     * Lista de vários grupos
     *
     * @var array
     */
    protected $groups;

    /**
     * Objeto para facilitar fazer uma requisição
     *
     * @var object
     */
    protected $route;

    /**
     * Carrega os dados necessários para os testes
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $user = User::factory()->create();
        $this->groups = Group::factory(10)->create(['user_id' => $user->id]);

        $this->route = $this->actingAs($user)->withoutMiddleware(Cors::class);
    }

    /**
     * Testa a rota de listagem de grupos, verificando se retornou 200
     *
     * @return void
     */

    public function testGroupIndex()
    {
        $response = $this->route->get('/group');

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de cadastro de grupos, verificando se retornou 200
     *
     * @return void
     */

    public function testGroupStore()
    {
        $response = $this->route->post('/group', [
            'name' => $this->faker->name,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de alteração de grupos, verificando se retornou 200
     *
     * @return void
     */

    public function testGroupUpdate()
    {
        $response = $this->route->put('/group/' . $this->groups[0]->id, [
            'name' => $this->faker->name,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de deletar grupos, verificando se retornou 200
     *
     * @return void
     */

    public function testGroupDelete()
    {
        $response = $this->route->delete('/group/' . $this->groups[0]->id);

        $response->assertStatus(200);
    }
}
