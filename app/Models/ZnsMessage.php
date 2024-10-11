<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZnsMessage extends Model
{
    use HasFactory;

    protected $table = 'zns_messages';

    protected $fillable = [
        'name',
        'phone',
        'sent_at',
        'status',
        'note',
        'template_id',
        'oa_id',
    ];

    public function template()
    {
        return $this->belongsTo(OaTemplate::class, 'template_id');
    }

    public function zaloOa()
    {
        return $this->belongsTo(ZaloOa::class, 'oa_id');
    }
}
