<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'tax_number',
        'company_name',
        'address',
        'source',
        'field',
    ];

    public function receipt()
    {
        return $this->hasMany(Receipt::class);
    }

    public function payment_slip()
    {
        return $this->hasMany(PaymentSlip::class);
    }

    public function bill()
    {
        return $this->hasMany(Bill::class);
    }
}
