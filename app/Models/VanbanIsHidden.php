<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanbanIsHidden extends Model
{
    use HasFactory;
    protected $table = 'vanban_is_hidden';

    // Các trường có thể được gán giá trị đại chúng
    protected $fillable = [
        'title',
        'column_name',
        'is_hidden',
    ];

    // Nếu muốn tự động thêm timestamps, bạn có thể để các thuộc tính này
    public $timestamps = true;
}
