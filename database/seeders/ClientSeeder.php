<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Liste de tes nombres (peut représenter des ID, codes, etc.)
        $codes = [
          1,2,3
        ];

        foreach ($codes as $code) {
            Client::factory()->create([
                'id' => $code,
                'email' => "client{$code}@example.com",
                'address' => "Adresse du client n°{$code}",
            ]);
        }
    }
}
