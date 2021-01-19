<?php

namespace App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para visualização e alteração
     *
     * @var array
     */

    protected $fillable = [
        'street', 'neighborhood', 'city', 'province', 'complement',
        'cep', 'number', 'contact_id'
    ];

    /**
     * Método que cadastra endereço
     * @param $query
     * @param array $address
     * @param int $contact_id
     */

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

    /**
     * Pega o contato que possui esse endereço
     */

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }
}
