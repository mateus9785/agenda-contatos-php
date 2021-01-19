<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class MyResetPasswordNotification extends ResetPassword
{
    /**
     * Método que envia email
     *
     * @param $notifiable
     * @return Illuminate\Notifications\Messages\MailMessage
     */

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Agenda - redefinição de senha')
            ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha de sua conta.')
            ->action('Mudar senha', url(env('APP_URL') . route('password.reset', $this->token, false)))
            ->line('Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.');
    }
}
