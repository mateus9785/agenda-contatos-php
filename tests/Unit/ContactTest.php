<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use App\Models\Contact;
use Illuminate\Support\Str;
use App\Services\ContactService;

class ContactTest extends TestCase
{

    /**
     * Objetos para gerar dados fakes
     *
     * @var object
     */

    protected $faker;

    /**
     * Injeção de dependência da service de contatos
     *
     * @var object
     */

    protected $contactService;

    /**
     * Lista de contatos para testes
     *
     * @var object
     */

    protected $contacts;

    /**
     * Dados do contato gerados aleatóriamente para teste
     *
     * @var object
     */

    protected $faker_contact;

    /**
     * Carrega os dados necessários para os testes
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->contactService = app(ContactService::class);
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->contacts = Contact::factory(10)->create(['user_id' => $user->id]);
        $groups = Group::factory(3)->create(['user_id' => $user->id]);
        $this->faker_contact = [
            'name' => $this->faker->name,
            'name_file' => Str::random(10),
            'groups' => [$groups[0]->id, $groups[1]->id, $groups[2]->id],
            'phones' => [$this->faker->phoneNumber, $this->faker->phoneNumber, $this->faker->phoneNumber],
            'addresses' => [
                [
                    'street' => $this->faker->name,
                    'neighborhood' => $this->faker->name,
                    'city' => $this->faker->city,
                    'province' => $this->faker->word,
                    'complement' => $this->faker->sentence,
                    'cep' => $this->faker->postcode,
                    'number' => (string) $this->faker->numberBetween(0, 9999),
                ]
            ]
        ];
    }

    /**
     * Testa o método de listagem de contatos, vendo se retorna paginado
     *
     * @return void
     */

    public function testIndexContact()
    {
        $per_page = $this->faker->numberBetween(1, 10);
        $data = $this->contactService->index(null, null, $per_page);
        $this->assertTrue($data['contacts']->perPage() == $per_page);
    }

    /**
     * Testa o método de busca de contato, vendo se retorna os dados do contato certo
     *
     * @return void
     */

    public function testShowContact()
    {
        $data = $this->contactService->show($this->contacts[0]->id);
        $this->assertIsArray($data['provinces']);
        $this->assertTrue($data['contact']['data']->id == $this->contacts[0]->id);
    }

    /**
     * Testa o método de cadastro de contatos, vendo se retorna os dados corretamente
     *
     * @return void
     */

    public function testStoreContact()
    {
        $name = $this->faker_contact['name'];
        $name_file = $this->faker_contact['name_file'];
        $groups = $this->faker_contact['groups'];
        $phones = $this->faker_contact['phones'];
        $addresses = $this->faker_contact['addresses'];
        $data = $this->contactService->store($name, $name_file, $groups, $phones, $addresses);
        $this->assertIsNumeric($data->id);
        $this->assertTrue($data->name == $name);
        $this->assertTrue($data->name_file == $name_file);
    }

    /**
     * Testa o método de alteração de contatos, vendo se retorna os dados corretamente
     *
     * @return void
     */

    public function testUpdateContact()
    {
        $id = $this->contacts[0]->id;
        $name = $this->faker_contact['name'];
        $name_file = $this->faker_contact['name_file'];
        $groups = $this->faker_contact['groups'];
        $phones = $this->faker_contact['phones'];
        $addresses = $this->faker_contact['addresses'];
        $data = $this->contactService->update($id, $name, $name_file, $groups, $phones, $addresses);
        $this->assertTrue($data->id == $id);
        $this->assertTrue($data->name == $name);
        $this->assertTrue($data->name_file == $name_file);
    }

    /**
     * Testa o método de apagar contatos, vendo se realmente foi apagado
     *
     * @return void
     */

    public function testDestroyContact()
    {
        $this->contactService->destroy($this->contacts[0]->id);

        $deleted_contact = Group::find($this->contacts[0]->id);
        $this->assertTrue($deleted_contact == null);
    }
}
