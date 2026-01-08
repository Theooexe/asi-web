<?php

use App\Enums\Roles;
use App\Events\UserCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('dispatches UserCreated with client role when user confirms default role', function () {
    Event::fake();

    $name = 'Test User';
    $email = 'test.user@example.com';

    $this->artisan('user:create', [
        'name' => $name,
        'email' => $email,
    ])
        ->expectsConfirmation('Voulez-vous créer un nouvel utilisateur client ?', 'yes') // si je met no ici alors la partie commentée va s'exe
        /**
         * 'Quel rôle doit avoir le nouvel utilisateur ?',
         * Roles::Admin->value, // la réponse choisie
         * [
         * Roles::Client->value,
         * Roles::Admin->value,
         * Roles::SuperAdmin->value,
         * ]
         */
        ->assertExitCode(0);

    Event::assertDispatched(UserCreated::class, function ($event) use ($name, $email) {
        return $event->name === $name
            && $event->email === $email
            && $event->role === Roles::Client->value;
    });
});
