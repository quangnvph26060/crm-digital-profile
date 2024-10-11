<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAds extends Model
{
    use HasFactory;

    protected $table = "data_ads";

    protected $fillable = [
        "content",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
