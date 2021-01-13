<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * indica os atributos para definição de dados em massa
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id'];

    /**
     * mapeamento do relacionamento com usuário
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeFindOne($query, int $id, int $user_id)
    {
        return $query->where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();
    }
}
