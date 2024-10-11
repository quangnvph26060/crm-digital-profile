<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    protected $table = 'bill_detail';
    protected $fillable = [
        'service_name',
        'unit',
        'amount',
        'price',
        'bill_id',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
