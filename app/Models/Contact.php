<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     */
    public function scopeFindOne($query, int $id, int $user_id)
    {
        return $query->where([
            'id' => $id,
            'user_id' => $user_id,
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
