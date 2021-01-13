<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = ['name', 'name_file', 'is_user_contact', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function contact_group()
    {
        return $this->hasMany('App\Models\ContactGroup');
    }

    public function scopeFindOne($query, int $id, int $user_id)
    {
        return $query->where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();
    }
}
