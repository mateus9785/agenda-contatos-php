<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\ContactGroup;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

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

    public function contactGroups()
    {
        return $this->hasMany(ContactGroup::class);
    }
}
