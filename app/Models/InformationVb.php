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
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = require __DIR__ . '/array_vanban.php';

        if (!is_array($this->fillable)) {
            $this->fillable = [];
        }
    }

    public function config()
    {
        return $this->belongsTo(Config::class, 'ma_co_quan');
    }

    public function maPhong()
    {
        return $this->belongsTo(Phong::class, 'ma_phong');
    }

    public function maMucLuc()
    {
        return $this->belongsTo(MucLuc::class, 'ma_mucluc');
    }
    public function getStatus() : string
    {
       
                if ($this->status == Status::ENABLE) {
                    return '<span class="badge badge--primary">Hoạt động</span>';
                } else {
                    return '<span><span class="badge badge--dark">Không hoạt động</span></span>';
                } //Unfeatured

         
    }


    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
