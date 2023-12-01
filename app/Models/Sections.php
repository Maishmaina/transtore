<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $fillable = ['facility_id','name'];

    public function aisle(){
        return $this->hasMany(Aisles::class,'section_id');
    }
}
