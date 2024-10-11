<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ROLE_SHOP = 'shop';
    const ROLE_ADMIN = 'admin';
    const ROLE_AGENCY = 'agency';

    protected $table = 'roles';

    protected $fillable = [
        'name', // tên quyền
        'code' // mã quyền
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_code', 'code');
    }
}

