<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para visualização e alteração
     *
     * @var array
     */
    protected $fillable = ['name', 'contact_id'];

    /**
     * Pega o contato que possui esse telefone
     */
    public function contact()
    {
        return $this->hasOne(Contact::class);
    }
}
