<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacilityReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'facility_id',
        'user_id',
        'message',
        'stars',
    ];
}
