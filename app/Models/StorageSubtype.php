<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorageSubtype extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'storage_type_id',
        'name'
    ];

    public function facilities(){

        return $this->belongsToMany(Facility::class,'facility_storage_subtype');

    }
}
