<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Liste des IDs clients
        $clientIds = [
            1,2,3
        ];

        foreach ($clientIds as $clientId) {
            // Création de 1 à 3 factures aléatoires par client
            $invoiceCount = rand(1, 3);

            for ($i = 0; $i < $invoiceCount; $i++) {
                $amountBeforeTax = fake()->randomFloat(2, 100, 1000); // entre 100 et 1000 €
                $taxRate = 0.2; // 20%
                $tax = round($amountBeforeTax * $taxRate, 2);
                $totalAmount = round($amountBeforeTax + $tax, 2);

                $sendAt = now()->subDays(rand(1, 60));
                $acquittedAt =now()->subDays(rand(0, 20));

                Invoice::create([
                    'client_id' => $clientId,
                    'amount_before_tax' => $amountBeforeTax,
                    'tax' => $tax,
                    'total_amount' => $totalAmount,
                    'send_at' => $sendAt,
                    'acquitted_at' => $acquittedAt,
                ]);
            }
        }
    }
}
