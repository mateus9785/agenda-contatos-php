<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Contact;
use App\Models\Group;
use App\Models\ContactGroup;
use App\Models\Address;
use App\Models\Phone;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Support\Str;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    protected $faker_contact;
    protected $contacts;

    public function setUp(): void
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
                            'group_id' => $group->id
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
                ]
            ]
        ];

        $this->route = $this->actingAs($user)->withoutMiddleware(Cors::class);
    }

    public function testContactIndex()
    {
        $response = $this->route->get('/contact');

        $response->assertStatus(200);
    }

    public function testContactShow()
    {
        $response = $this->route->get('/contact/form?id=' . $this->contacts[0]->id);

        $response->assertStatus(200);
    }

    public function testContactStore()
    {
        $response = $this->route->post('/contact', $this->faker_contact);

        $response->assertStatus(200);
    }

    public function testContactUpdate()
    {
        $response = $this->route->put('/contact/' . $this->contacts[0]->id, $this->faker_contact);

        $response->assertStatus(200);
    }

    public function testContactDelete()
    {
        $response = $this->route->delete('/contact/' . $this->contacts[0]->id);

        $response->assertStatus(200);
    }
}
