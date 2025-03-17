<?php

namespace App\Models\Users;

use App\Models\General\Location;
use App\Models\Users\Patient;
use App\Models\Notifications\Notification;
use App\Services\MessageService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'status',
        'verified',
        'otp',
        'otp_expide_at',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'role' => 'string',
        'phone' => 'string',
        'avatar' => 'string',
        'status' => 'string',
        'verified' => 'boolean',
        'otp' => 'string',
        'otp_expide_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $dates = [
        'otp_expide_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value !== null ? asset("storage/{$value}") : null,
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->first_name} {$this->last_name}",
        );
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }

    public function isGuardian()
    {
        return $this->role === 'guardian';
    }

    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function notificationsUnreadCount()
    {
        return Notification::where('user_id', $this->id)->whereNull('read_at')->count();
    }



    public static function auth()
    {
        if (Auth::check()) {
            return User::find(Auth::user()->id);
        }

        Log::error('Unauthenticated access attempt', [
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'referer' => request()->header('referer'),
            'stack_trace' => debug_backtrace(),
        ]);
        MessageService::abort(503, 'أنت غير مسجل الدخول');
    }


    // Relationships

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class, 'user_id')->withTrashed();
    }


    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'addressable');
    }
}
