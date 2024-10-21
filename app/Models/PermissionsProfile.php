<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionsProfile extends Model
{
    use HasFactory;
    protected $table = 'permissions_profile';

    protected $fillable = [
        'config_id',
        'ma_muc_luc',
        'ma_phong',
        'hop_so',
        'ho_so_so',
        'tieu_de_ho_so',
        'ngay_thang',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'so_to',
        'thbq',
        'mo_ta',
        'ghi_chu',
        'active'
    ];
}
