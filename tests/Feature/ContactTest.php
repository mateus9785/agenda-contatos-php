<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\Group;
use App\Models\Phone;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * Dados do contato gerados aleatóriamente para teste
     *
     * @var array
     */
    protected $faker_contact;

    /**
     * Lista de vários contatos
     *
     * @var array
     */
    protected $contacts;

    /**
     * Objeto para facilitar fazer uma requisição
     *
     * @var object
     */
    protected $route;

    /**
     * Carrega os dados necessários para os testes
     */
    protected function setUp(): void
    {
        parent::setUp();

        $faker = Factory::create();

        $user = User::factory()->create();
        $this->contacts = Contact::factory(10)->create(['user_id' => $user->id])
            ->each(function ($contact) use ($user) {
                Address::factory(3)->create(['contact_id' => $contact->id]);
                Phone::factory(3)->create(['contact_id' => $contact->id]);
                Group::factory(3)
                    ->create(['user_id' => $user->id])
                    ->each(function ($group) use ($contact, $user) {
                        ContactGroup::factory()->create([
                            'contact_id' => $contact->id,
                            'user_id' => $user->id,
                            'group_id' => $group->id,
                        ]);
                    });
            });

        $groups = Group::factory(3)->create(['user_id' => $user->id]);

        $this->faker_contact = [
            'name' => $faker->name,
            'name_file' => Str::random(10),
            'groups' => [$groups[0]->id, $groups[1]->id, $groups[2]->id],
            'phones' => [$faker->phoneNumber, $faker->phoneNumber, $faker->phoneNumber],
            'addresses' => [
                [
                    'street' => $faker->name,
                    'neighborhood' => $faker->name,
                    'city' => $faker->city,
                    'province' => $faker->word,
                    'complement' => $faker->sentence,
                    'cep' => $faker->postcode,
                    'number' => (string) $faker->numberBetween(0, 9999),
                ],
            ],
        ];

        $this->route = $this->actingAs($user)->withoutMiddleware(Cors::class);
    }

    /**
     * Testa a rota de visualizar todos os contato, verificando se retornou 200
     *
     * @return void
     */
    public function test_contact_index()
    {
        $response = $this->route->get('/contact');

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de visualizar o contato, verificando se retornou 200
     *
     * @return void
     */
    public function test_contact_show()
    {
        $response = $this->route->get('/contact/form?id='.$this->contacts[0]->id);

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de cadastrar contatos, verificando se retornou 200
     *
     * @return void
     */
    public function test_contact_store()
    {
        $response = $this->route->post('/contact', $this->faker_contact);

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de alterar contatos, verificando se retornou 200
     *
     * @return void
     */
    public function test_contact_update()
    {
        $response = $this->route->put('/contact/'.$this->contacts[0]->id, $this->faker_contact);

        $response->assertStatus(200);
    }

    /**
     * Testa a rota de deletar contatos, verificando se retornou 200
     *
     * @return void
     */
    public function test_contact_delete()
    {
        $response = $this->route->delete('/contact/'.$this->contacts[0]->id);

        $response->assertStatus(200);
    }
}
