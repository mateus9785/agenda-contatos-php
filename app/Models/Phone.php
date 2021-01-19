<?php

namespace App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
