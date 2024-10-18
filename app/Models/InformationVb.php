<?php

namespace App\Models;

use App\Constants\Status;
use App\Models\Config;
use App\Models\Phong;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'filepdf',
        'profile_id',
        'status'
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
        return $this->belongsTo(MucLuc::class, 'ma_mucluc');
    }
    public function getStatus() : Attribute
    {
        return new Attribute(
            function () {
                $html = '';

                if ($this->status == Status::ENABLE) {
                    $html = '<span class="badge badge--primary">Hoạt động</span>';
                    //Featured
                } else {
                    $html = '<span><span class="badge badge--dark">Không hoạt động</span></span>';
                }   //Unfeatured

            });
          }


    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }




}
