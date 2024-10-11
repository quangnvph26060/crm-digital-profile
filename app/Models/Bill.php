<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';

    protected $fillable = [
        'tax',
        'total_money',
        'client_id',
    ];

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
