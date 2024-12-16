<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'parent_id',
        'mobile',
        'whatsapp',
        'country_code',
        'referal_id',
        'wallet_balance',
        'is_blocked',
        'expiry_date',
        'package_id',
        'domain',
        'white_label_webhook',
        'is_white_label',
        'webhook',
        'logo',
        'software_name',
        'software_update_path',
        'version_number',
        'support_number',
        'device_id'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function totalTime($date)
    {
        return $this->attendanceSessions()
            ->where('date', $date)
            ->sum('total_minutes');
    }
}
