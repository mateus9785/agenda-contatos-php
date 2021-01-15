<?php

namespace Database\Factories;

use App\Models\ContactGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactGroupFactory extends Factory
{
    protected $model = ContactGroup::class;

    public function definition()
    {
        return [
            'contact_id' => $this->faker->uuid,
            'group_id' => $this->faker->uuid,
            'user_id' => $this->faker->uuid,
        ];
    }
}
