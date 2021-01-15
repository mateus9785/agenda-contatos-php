<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_id'];

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }
}
