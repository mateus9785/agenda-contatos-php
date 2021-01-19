<?php

namespace App\Models;

use App\Models\User;
use App\Models\ContactGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para visualização e alteração
     *
     * @var array
     */

    protected $fillable = ['name', 'user_id'];

    /**
     * Método de buscar grupos por id
     */

    public function scopeFindOne($query, int $id, int $user_id)
    {
        return $query->where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();
    }

    /**
     * Pega o usuário dono desse grupo
     */

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Pega os contatos que estão nesse grupo
     */

    public function contactGroups()
    {
        return $this->hasMany(ContactGroup::class);
    }
}
