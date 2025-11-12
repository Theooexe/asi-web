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

        return new Price(
            $decoded['currency'],
            $decoded['amount'],
            $decoded['currency_rate']
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof Price) {
            return [$key => json_encode($value->toArray())];
        }

        return [$key => $value];
    }
}
