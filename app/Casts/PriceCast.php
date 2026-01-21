<?php
namespace App\Casts;

use App\Helpers\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $decoded = json_decode($value, true);

        if (!is_array($decoded)) {
            return Price::fromEuros((float) $value);
        }

        // On utilise ?? pour donner des valeurs par défaut si les clés sont absentes
        return new Price(
            $decoded['currency'] ?? 'EUR',
            $decoded['amount'] ?? 0,
            $decoded['currency_rate'] ?? 1.0
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // Si la valeur est déjà un objet Price, on l'encode en JSON
        if ($value instanceof Price) {
            return json_encode($value->toArray());
        }

        // Si la valeur est un tableau (ce qu'on envoie depuis Livewire), on l'encode en JSON
        if (is_array($value)) {
            return json_encode($value);
        }

        // Sinon, on retourne la valeur telle quelle (si c'est déjà une string JSON)
        return $value;
    }
}
