<?php

namespace App\Models;

use App\Models\Config;
use App\Models\Phong;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationVb extends Model
{
    use HasFactory;
    protected $table = 'information_vb';

    // Các trường có thể được gán giá trị hàng loạt
    protected $fillable = [
        'config_id',
        'ma_phong',
        'ma_mucluc',
        'hop_so',
        'ho_so_so',
        'so_kh_vb',
        'time_vb',
        'tac_gia',
        'author',
        'noi_dung',
        'to_so',
        'ghi_chu',
        'duong_dan',
        'filepdf'
    ];

    public function config()
    {
        return $this->belongsTo(Config::class, 'config_id');
    }

    public function maPhong()
    {
        return $this->belongsTo(Phong::class, 'ma_phong');
    }



}
