<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profiles";

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = require 'fillable_fields_profile.php';
    }

    // Định nghĩa rules cho validation (nếu cần)
    public static $rules = [
        'config_id' => 'required|exists:configs,id',
        'ma_muc_luc' => 'required|string',
        'ma_phong' => 'required|string',
        'hop_so' => 'required|string',
        'ho_so_so' => 'required|string',
        'tieu_de_ho_so' => 'required|string',
        'ngay_thang' => 'required|date',
        'ngay_bat_dau' => 'required|date',
        'ngay_ket_thuc' => 'required|date',
        'so_to' => 'required|integer',
        'thbq' => 'required|string',
        'ghi_chu' => 'nullable|string',
    ];
    public function config()
    {
        return $this->belongsTo(Config::class, 'config_id');
    }

    public function maPhong()
    {
        return $this->belongsTo(Phong::class, 'ma_phong');
    }
    public function maMucLuc()
    {
        return $this->belongsTo(MucLuc::class, 'ma_muc_luc');
    }
}
