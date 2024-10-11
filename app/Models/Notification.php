<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        "name",
        "user_id",
        "admin_id",
        "url",
        "type",
        "status"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
