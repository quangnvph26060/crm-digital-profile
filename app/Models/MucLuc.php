<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MucLuc extends Model
{
    use HasFactory;
    protected $table = "mucluc";
    protected $fillable = [
        
        'ten_mucluc',
        'ma_mucluc',
    ];
}
