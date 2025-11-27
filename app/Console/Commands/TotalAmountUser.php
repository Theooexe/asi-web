<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TotalAmountUser extends Command
{
    /**
     * Signature de la commande.
     * Exemple d'utilisation :
     * php artisan user:total-amount --id=1
     * ou
     * php artisan user:total-amount --email=test@test.com
     */
    protected $signature = 'user:total-amount {--id=} {--email=}';

    /**
     * Description de la commande.
     */
    protected $description = 'Calcule le montant total de toutes les factures d’un utilisateur';

    /**
     * Exécution de la commande.
     */
    public function handle(): int
    {
        $id = $this->option('id');
        $email = $this->option('email');

        if (!$id && !$email) {
            $this->error('Vous devez fournir soit un --id, soit un --email.');
            return Command::FAILURE;
        }

        $user = null;

        if ($id) {
            $user = User::find($id);
        } elseif ($email) {
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            $this->error('Aucun utilisateur trouvé.');
            return Command::FAILURE;
        }


        if (!method_exists($user, 'invoices')) {
            $this->error('Le modèle User doit avoir une relation invoices() pour accéder aux factures.');
            return Command::FAILURE;
        }

        $total = $user->invoices()->sum('total_amount');

        $this->info("Utilisateur : {$user->name}");
        $this->info("Montant total de ses factures : {$total} €");

        return Command::SUCCESS;
    }
}
