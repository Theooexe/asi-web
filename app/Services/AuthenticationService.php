<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class AuthenticationService
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createToken(): string
    {
        $token = Str::random(20);

        $this->user->update([
            'authentication_token' => $token,
            'authentication_token_generated_at' => now(),
        ]);

        return $token;
    }

    public function checkToken(string $token): bool
    {
        if ($this->user->authentication_token !== $token) {
            return false;
        }

        if ($this->user->authentication_token_generated_at->diffInHours(now()) > 24) {
            return false;
        }

        return true;
    }
}
