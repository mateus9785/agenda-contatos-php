<?php

namespace App\Models;

use App\Models\Contact;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MyResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * Campos permitidos para visualização e alteração
     *
     * @var array
     */

    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * Campos que ficam escondidos
     *
     * @var array
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Converte valor do atributo
     *
     * @var array
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Método de envio de email para mudança de senha
     *
     * @param string $token
     * @return void
     */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPasswordNotification($token));
    }

    /**
     * Pega os contatos desse usuário
     */

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
