<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactGroup extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para visualização e alteração
     *
     * @var array
     */

    protected $fillable = ['contact_id', 'group_id', 'user_id'];

    /**
     * Une com a tabela de grupos em uma query
     */

    public function scopeJoinGroup($query)
    {
        return $query->join('groups', function ($join) {
            $join->on('contact_groups.group_id', '=', 'groups.id');
        });
    }

    /**
     * Pega o contato que possui um grupo
     */

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    /**
     * Pega o grupo que possui um contato
     */

    public function group()
    {
        return $this->hasOne(Group::class);
    }
}
