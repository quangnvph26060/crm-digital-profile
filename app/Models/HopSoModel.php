<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopSoModel extends Model
{
    use HasFactory;

    protected $table = "hop_so";

    protected $fillable = [
        "coquan_id",
        "phong_id",
        "mucluc_id",
        "hop_so"
    ];

    

}
