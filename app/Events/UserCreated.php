<?php

namespace App\Events;

use App\Enums\Roles;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use Dispatchable, SerializesModels;
    public function __construct(public string $name,public string $email,public string $role)
    {

    }
}
