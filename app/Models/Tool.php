<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tool extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    protected $casts = [
        'price'=> PriceCast::class,
    ];

    #[Scope]
    protected function wherePriceGreaterThan(Builder $query, float $value):void
    {
        $query->where("price->amount",">",(int)$value);
    }


}
