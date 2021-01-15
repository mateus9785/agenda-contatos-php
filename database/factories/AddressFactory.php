<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'street' => $this->faker->streetName,
            'neighborhood' => $this->faker->name,
            'city' => $this->faker->city,
            'province' => $this->faker->name,
            'complement' => $this->faker->sentence,
            'cep' => $this->faker->postcode,
            'number' => $this->faker->numberBetween(0, 9999),
            'contact_id' => $this->faker->uuid
        ];
    }
}
