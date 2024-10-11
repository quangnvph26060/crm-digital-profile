<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingKpi extends Model
{
    use HasFactory;

    protected $table = "setting_kpis";

    protected $fillable =[
        "week",
        "date_from",
        "date",
        "date_to",
        "month",
        "year",
        "user_id",
        "post_new_num",
        "post_edit_num",
        "post_publish_num"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
