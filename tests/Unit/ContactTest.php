<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\ContactService;
use App\Models\User;
use App\Models\Contact;
use App\Models\Group;
use Faker\Factory;
use Illuminate\Support\Str;

class ContactTest extends TestCase
{

    protected $faker;
    protected $contactService;
    protected $contacts;
    protected $faker_contact;

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

    public function testIndexContact()
    {
        $per_page = $this->faker->numberBetween(1, 10);
        $data = $this->contactService->index(null, null, $per_page);
        $this->assertTrue($data['contacts']->perPage() == $per_page);
    }

    public function testShowContact()
    {
        $data = $this->contactService->show($this->contacts[0]->id);
        $this->assertIsArray($data['provinces']);
        $this->assertTrue($data['contact']['data']->id == $this->contacts[0]->id);
    }

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

    public function testDestroyContact()
    {
        $this->contactService->destroy($this->contacts[0]->id);

        $deleted_contact = Group::find($this->contacts[0]->id);
        $this->assertTrue($deleted_contact == null);
    }
}
