<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Phong extends Model
{
    use HasFactory;  
    protected $table = "phong";
    protected $fillable = [
        'ten_phong',
        'ma_phong',
        'coquan_id',
    ];

    public function coquan()
    {
        return $this->belongsTo(Config::class, 'coquan_id');
    }
  
}
