<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\ContactGroup;
use App\Models\Phone;
use App\Models\Address;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_file', 'is_user_contact', 'user_id'];

    public function scopeFindOne($query, int $id, int $user_id)
    {
        return $query->where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function contact_groups()
    {
        return $this->hasMany(ContactGroup::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
