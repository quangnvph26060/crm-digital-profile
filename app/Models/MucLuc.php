<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MucLuc extends Model
{
    use HasFactory;
    protected $table = "mucluc";
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'phong_id',
        'ten_mucluc',
        'ma_mucluc',
    ];

    public function maPhong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
