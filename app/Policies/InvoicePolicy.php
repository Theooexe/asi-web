<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use App\Enums\Roles;

class InvoicePolicy
{
    /**
     * Seuls les admin et super_admin peuvent voir la liste des factures
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Roles::Admin, Roles::SuperAdmin]);
    }

    /**
     * Seuls les admin et super_admin peuvent voir le détail d'une facture
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return in_array($user->role, [Roles::Admin, Roles::SuperAdmin]);
    }

    /**
     * Seuls les admin et super_admin peuvent créer une facture
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [Roles::Admin, Roles::SuperAdmin]);
    }

    /**
     * Seuls les super_admin peuvent supprimer une facture
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->role === Roles::SuperAdmin;
    }

    /**
     * (optionnel) — personne ne met à jour ou restaure
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return false;
    }

    public function restore(User $user, Invoice $invoice): bool
    {
        return false;
    }

    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return false;
    }
}
