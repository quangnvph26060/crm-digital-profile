<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongMucLuc extends Model
{
    use HasFactory;
    protected $table = "phong_mucluc";
    protected $fillable = [
        'phong_id',
        'mucluc_id',
    ];
}
