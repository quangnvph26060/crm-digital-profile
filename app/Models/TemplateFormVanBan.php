<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateFormVanBan extends Model
{
    use HasFactory;
    protected $table = 'template_form_vanban';

    // Các trường có thể được gán giá trị (mass assignable)
    protected $fillable = [
        'name',
        'template_form',
        'status',
    ];
}
