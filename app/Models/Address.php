<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'street', 'neighborhood', 'city', 'province', 'complement', 
        'cep', 'number', 'contact_id'
    ];

    public function scopeRegister($query, $address, $contact_id)
    {
        return $query->create([
            'street' => $address["street"],
            'neighborhood' => $address["neighborhood"],
            'city' => $address["city"],
            'province' => $address["province"],
            'complement' => $address["complement"],
            'cep' => $address["cep"],
            'number' => $address["number"],
            'contact_id' => $contact_id,
        ]);
    }
}
