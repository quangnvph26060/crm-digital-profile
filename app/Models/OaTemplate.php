<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OaTemplate extends Model
{
    use HasFactory;

    protected $table = 'oa_templates';

    protected $fillable = [
        'oa_id',
        'template_id',
        'template_name',
        'price',
    ];

    public function zaloOas()
    {
        return $this->belongsTo(ZaloOa::class);
    }

    public function messages()
    {
        return $this->hasMany(ZnsMessage::class);
    }
}
