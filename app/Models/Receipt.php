<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipts';

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
