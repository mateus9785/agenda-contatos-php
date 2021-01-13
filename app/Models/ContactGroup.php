<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{

    protected $fillable = ['contact_id', 'group_id', 'user_id'];

    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }
}
