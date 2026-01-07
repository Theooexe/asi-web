<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\User;

class PersistAUser
{
    public function handle(UserCreated $event): void
    {
        User::create([
            'name' => $event->name,
            'email' => $event->email,
            'role' => $event->role,
        ]);
    }
}
