<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fanpage extends Model
{
    use HasFactory;

    protected $table = "fanpages";

    protected $fillable = [
        "user_id",
        "name",
        "link",
        "code"
    ];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
