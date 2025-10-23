<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total_amount',
        'amount_before_tax',
        'tax',
        'send_at',
        'acquitted_at'
    ];

    protected $casts = [
        'send_at' => 'datetime',
        'acquitted_at' => 'datetime',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function tools(){
        return $this->belongsToMany(Tool::class ,'invoice_tool');
    }
}
