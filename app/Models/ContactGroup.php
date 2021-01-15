<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Contact;
use App\Models\Group;

class ContactGroup extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'group_id', 'user_id'];

    public function scopeJoinGroup($query)
    {
        return $query->join('groups', function($join) {
            $join->on('contact_groups.group_id', '=', 'groups.id');
        });
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function group()
    {
        return $this->hasOne(Group::class);
    }
}
