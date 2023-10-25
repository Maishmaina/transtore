<?php

namespace App\Models;

use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacilityOwner extends Model
{
    use HasFactory, SoftDeletes, UserTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
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

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
}
