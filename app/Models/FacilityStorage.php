<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityStorage extends Model
{
    use HasFactory;

    protected $table = 'facility_storage_type';
    protected $fillable = ['facility_id','storage_type_id'];
}
