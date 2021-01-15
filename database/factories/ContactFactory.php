<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'name_file' => Str::random(10),
            'is_user_contact' => $this->faker->numberBetween(0, 1),
            'user_id' => $this->faker->uuid
        ];
    }
}
