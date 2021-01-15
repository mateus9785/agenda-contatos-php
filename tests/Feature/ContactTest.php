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

    public function testContactIndex()
    {

        $user = User::factory()->create();
        Contact::factory(10)->create(['user_id' => $user->id])
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

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->get('/contact');

        $response->assertStatus(200);
    }

    public function testContactShow()
    {

        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        Group::factory(3)
            ->create(['user_id' => $user->id])
            ->each(function ($group) use ($contact, $user) {
                ContactGroup::factory()->create([
                    'contact_id' => $contact->id,
                    'user_id' => $user->id,
                    'group_id' => $group->id
                ]);
            });

        Address::factory(3)->create(['contact_id' => $contact->id]);
        Phone::factory(3)->create(['contact_id' => $contact->id]);

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->get('/contact/form?id=' . $contact->id);

        $response->assertStatus(200);
    }

    public function testContactStore()
    {
        $fake = Factory::create();

        $user = User::factory()->create();
        $groups = Group::factory(3)->create(['user_id' => $user->id]);

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->post('/contact', [
            'name' => $fake->name,
            'name_file' => Str::random(10),
            'groups' => [$groups[0]->id, $groups[1]->id, $groups[2]->id],
            'phones' => [$fake->phoneNumber, $fake->phoneNumber, $fake->phoneNumber],
            'addresses' => [
                [
                    'street' => $fake->name,
                    'neighborhood' => $fake->name,
                    'city' => $fake->city,
                    'province' => $fake->word,
                    'complement' => $fake->sentence,
                    'cep' => $fake->postcode,
                    'number' => (string) $fake->numberBetween(0, 9999),
                ]
            ]
        ]);

        $response->assertStatus(200);
    }

    public function testContactUpdate()
    {
        $fake = Factory::create();

        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $groups = Group::factory(3)->create(['user_id' => $user->id]);

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->put('/contact/' . $contact->id, [
            'name' => $fake->name,
            'name_file' => Str::random(10),
            'groups' => [$groups[0]->id, $groups[1]->id, $groups[2]->id],
            'phones' => [$fake->phoneNumber, $fake->phoneNumber, $fake->phoneNumber],
            'addresses' => [
                [
                    'street' => $fake->name,
                    'neighborhood' => $fake->name,
                    'city' => $fake->city,
                    'province' => $fake->word,
                    'complement' => $fake->sentence,
                    'cep' => $fake->postcode,
                    'number' => (string) $fake->numberBetween(0, 9999),
                ]
            ]
        ]);

        $response->assertStatus(200);
    }

    public function testContactDelete()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        Group::factory(3)
            ->create(['user_id' => $user->id])
            ->each(function ($group) use ($contact, $user) {
                ContactGroup::factory()->create([
                    'contact_id' => $contact->id,
                    'user_id' => $user->id,
                    'group_id' => $group->id
                ]);
            });

        Address::factory(3)->create(['contact_id' => $contact->id]);
        Phone::factory(3)->create(['contact_id' => $contact->id]);

        $route = $this->actingAs($user)->withoutMiddleware(Cors::class);

        $response = $route->delete('/contact/' . $contact->id);

        $response->assertStatus(200);
    }
}
