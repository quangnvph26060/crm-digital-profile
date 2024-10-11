<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Template\Template;

class ZaloOa extends Model
{
    use HasFactory;

    protected $table = 'zalo_oas';

    protected $fillable = [
        'name',
        'oa_id',
        'access_token',
        'refresh_token',
        'is_active',
    ];

    public function messages()
    {
        return $this->hasMany(ZnsMessage::class, 'oa_id');
    }

    public function templates()
    {
        return $this->hasMany(OaTemplate::class, 'oa_id');
    }
}
