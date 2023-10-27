<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'facility_owner_id',
        'name',
        'location',
        'location_latitude',
        'location_longitude',
        'access_period',
    ];

    protected $appends = [
        'coordinates'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public function owner()
    {
        return $this->belongsTo(FacilityOwner::class, 'facility_owner_id');
    }

    public function storageTypes()
    {
        return $this->belongsToMany(StorageType::class);
    }

    public function storageSubtypes()
    {
        return $this->belongsToMany(StorageSubtype::class);
    }

    public function images()
    {
        return $this->hasMany(FacilityImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(FacilityReview::class);
    }

    public function coordinates(): Attribute
    {
        return Attribute::make(
            get: fn () => "$this->location_latitude, $this->location_longitude"
        );
    }
}
