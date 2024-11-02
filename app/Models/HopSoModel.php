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
    public function maCoQuan()
    {
        return $this->belongsTo(Config::class, 'coquan_id');
    }
    public function maPhong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
    public function maMucLuc()
    {
        return $this->belongsTo(MucLuc::class, 'mucluc_id');
    }

}
