<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Settings;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
        'full_name', // họ tên
        'post_number_per_day', // số bài viết dk giao trong ngày
        'email', // email
        'password', // mật khẩu
        'phone', // sđt
        'email_verified_at', // time xác thực email
        'status', // 0 = in_active, 1 = active,
        'type',
        'salary', // mức lương
        'bank',
        'account_number',
        'internship_duration',
        'font_identification_card', // cccd mặt trước 
        'back_identification_card'  // cccd sau trước 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function kpis()
    {
        return $this->hasMany(SettingKpi::class);
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function log_missions()
    {
        return $this->hasMany(LogMission::class);
    }
}

