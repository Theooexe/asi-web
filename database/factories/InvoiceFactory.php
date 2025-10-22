<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $amountBeforeTax =fake()->randomFloat(2, 50, 1000);
        $tax = $amountBeforeTax * 0.2;
        $totalAmount = $amountBeforeTax + $tax;

        return [
            'client_id' => $this->faker->numberBetween(1, 100),
            'amount_before_tax' => $amountBeforeTax,
            'tax' => $tax,
            'total_amount' => $totalAmount,
        ];
    }
}
