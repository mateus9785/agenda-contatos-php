<?php

namespace App\Models;

use App\Models\User;
use App\Models\Phone;
use App\Models\Address;
use App\Models\ContactGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para visualização e alteração
     *
     * @var array
     */

    protected $fillable = ['name', 'name_file', 'is_user_contact', 'user_id'];

    /**
     * Método de buscar grupos por id
     * @param $query
     * @param int $id
     * @param int $user_id
     */

    public function scopeFindOne($query, int $id, int $user_id)
    {
        return $query->where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();
    }

    /**
     * Pega o usuário dono desse contato
     */

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Pega os grupos que esse contato está
     */

    public function contactGroups()
    {
        return $this->hasMany(ContactGroup::class);
    }

    /**
     * Pega os telefones desse contato
     */

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Pega os endereços desse contato
     */

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
