<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\Roles;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * Nom et signature de la commande.
     * Exemple d'appel : php artisan user:create "Jean Dupont" "jean@test.com" --role=admin
     */
    protected $signature = 'user:create {name} {email} {--role=}';

    /**
     * Description de la commande.
     */
    protected $description = 'Créer un utilisateur avec un rôle (client par défaut)';

    /**
     * Exécution de la commande.
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $role = $this->option('role');

        if (!$role) {
            if ($this->confirm('Voulez-vous créer un nouvel utilisateur client ?', true)) {
                $role = Roles::Client->value;
            } else {
                //$roles = collect(Roles::cases()
                $role = $this->choice('Quel rôle doit avoir le nouvel utilisateur ?', [
                    Roles::Client->value,
                    Roles::Admin->value,
                    Roles::SuperAdmin->value
                ]);
            }
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        $this->info("Utilisateur '$name' ($role) créé avec succès !");
        return Command::SUCCESS;
    }
}
