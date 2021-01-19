<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Injeção de dependência da service de grupos
     *
     * @var object
     */

    protected $groupService;

    /**
     * Objetos para gerar dados fakes
     *
     * @var object
     */

    protected $faker;

    /**
     * Lista de grupos para testes
     *
     * @var array
     */

    protected $groups;

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
        $this->actingAs($user);
        $this->groups = Group::factory(5)->create(['user_id' => $user->id]);

        $this->groupService = app(GroupService::class);
    }

    /**
     * Testa o método de listagem de grupos, vendo se retorna paginado os dados
     *
     * @return void
     */

    public function testIndexGroup()
    {
        $per_page = $this->faker->numberBetween(1, 10);
        $paginate = $this->groupService->index($per_page);

        $this->assertTrue($paginate->perPage() == $per_page);
        $this->assertTrue($paginate->total() == sizeof($this->groups));
    }

    /**
     * Testa o método de cadastro de grupos, vendo se retorna os dados corretamente
     *
     * @return void
     */

    public function testStoreGroup()
    {
        $name = $this->faker->name;
        $new_group = $this->groupService->store($name);

        $this->assertTrue($new_group->name == $name);
    }

    /**
     * Testa o método de alteração de grupos, vendo se retorna os dados corretamente
     *
     * @return void
     */

    public function testUpdateGroup()
    {
        $name = $this->faker->name;
        $changed_group = $this->groupService->update($this->groups[0]->id, $name);

        $this->assertTrue($changed_group->name == $name);
    }

    /**
     * Testa o método de apagar grupos, vendo se realmente foi apagado
     *
     * @return void
     */

    public function testDeleteGroup()
    {
        $this->groupService->destroy($this->groups[0]->id);

        $deleted_group = Group::find($this->groups[0]->id);
        $this->assertTrue($deleted_group == null);
    }
}
