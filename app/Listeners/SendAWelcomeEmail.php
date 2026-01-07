<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SendAWelcomeEmail implements ShouldQueue
{

    public $connection = 'database';
    public $queue = 'mails';

    /**
     * Traitement du listener.
     */
    public function handle(UserCreated $event): void
    {
        $name = $event->name;
        $email = $event->email;

        Mail::raw("Bravo {$name}, vous faites maintenant partie de notre programme de fidélité !", function (Message $message) use ($email, $name) {
            $message->to($email, $name)
                ->subject('Bienvenue chez nous !');
        });
    }
}
