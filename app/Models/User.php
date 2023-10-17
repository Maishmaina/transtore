<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'verification_code',
        'password',
        'enabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'verification_code',
        'reset_code',
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
        'password' => 'hashed',
        'enabled' => 'boolean'
    ];

    protected $appends = [
        'full_name'
    ];

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "$this->first_name $this->last_name"
        );
    }

    public function scopeFirstName($query, $keyword)
    {
        return $query->where('first_name', 'like', '%' . $keyword . '%');
    }

    public function scopeLastName($query, $keyword)
    {
        return $query->where('last_name', 'like', '%' . $keyword . '%');
    }

    public function scopePhoneNumber($query, $keyword)
    {
        return $query->where('phone_number', 'like', '%' . $keyword . '%');
    }

    public function scopeEmail($query, $keyword)
    {
        return $query->where('email', 'like', '%' . $keyword . '%');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('first_name', 'like', '%' . $keyword . '%')
            ->orWhere('last_name', 'like', '%' . $keyword . '%')
            ->orWhere('phone_number', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%');
    }

    public function scopeStatus($query, $keyword)
    {
        return $query->when($keyword == 'enabled', function ($query) {
            $query->where('enabled', true);
        })
            ->when($keyword == 'disabled', function ($query) {
                $query->where('enabled', false);
            });
    }

    public function scopeDate($query, $from, $to)
    {
        if ($from && $to) {
            return $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)->addDay()]);
        } elseif (!$from && $to) {
            return $query->whereDate('created_at', '<=', Carbon::parse($to)->addDay());
        } else {
            return $query;
        }
    }
}
