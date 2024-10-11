<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMission extends Model
{
    use HasFactory;

    protected $table = "log_missions";

    protected $fillable = [
        "user_id",
        "mission_id",
        "date",
        "status",
        "is_expired"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
