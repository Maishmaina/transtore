<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitySubStorage extends Model
{
    use HasFactory;

    protected $table = 'facility_storage_subtype';
    protected $fillable = ['facility_id','storage_subtype_id'];

}
