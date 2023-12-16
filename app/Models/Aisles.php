<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aisles extends Model
{
    use HasFactory;

    protected $fillable = ['section_id','name', 'number_of_units'];

     public function section(){
        return $this->belongsTo(Sections::class,'section_id');
    }
    public function units(){
        return $this->hasMany(Units::class,'aisle_id');
    }
}
