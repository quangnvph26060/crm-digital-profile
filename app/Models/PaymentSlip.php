<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSlip extends Model
{
    use HasFactory;

    protected $table = 'payment_slips';

    protected $fillable = [
        'amount',
        'note',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
