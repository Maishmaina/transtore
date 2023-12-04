<?php

namespace App\Models;

use App\Traits\GlobalScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory, SoftDeletes, GlobalScopesTrait;

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
    public function section(){
        return $this->hasMany(Sections::class);
    }

    public function coordinates(): Attribute
    {
        return Attribute::make(
            get: fn () => "$this->location_latitude, $this->location_longitude"
        );
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('location', 'like', '%' . $keyword . '%')
                ->orWhereHas('owner', function ($query) use ($keyword) {
                    $query->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
        });
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeLocation($query, $location)
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    public function scopeFacilityOwner($query, $facilityOwnerId)
    {
        return $query->when($facilityOwnerId, function ($query) use ($facilityOwnerId) {
            return $query->whereHas('owner', function ($query) use ($facilityOwnerId) {
                return $query->where('id', $facilityOwnerId);
            });
        });
    }

    public function scopeFacilityReview($query){
        return $query->withCount(['reviews' => function ($query) { $query->select(\DB::raw('coalesce(sum(stars), 0)')); }]);
    }
     public function scopeFacilityReviewAvg($query){
        return $query->withCount(['reviews' => function ($query) { $query->select(\DB::raw('coalesce(avg(stars), 0)')); }]);
    }
}
