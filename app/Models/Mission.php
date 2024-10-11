<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $table = "missions";

    protected $fillable = [
        "user_id",
        "project_id",
        "keyword",
        "url",
        "url_publish",
        "date",
        "date_done",
        "status",
        "deadline",
        "deadline_edit",
        "deadline_publish"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function logMissions()
    {
        return $this->hasMany(LogMission::class);
    }
}

