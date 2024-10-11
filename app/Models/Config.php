<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_name',
        'agency_code',
        'font_name',
        'font_code',
        'toc_name',
    ];
}
