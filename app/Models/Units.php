<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Units extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','aisle_id','size','dimension','weight','price','available_status'];

    public function aisle(){
        return $this->belongsTo(Aisles::class,'aisle_id');
    }
    public function unit_size()
    {
    return $this->belongsTo(UnitSize::class,'size');
    }
      public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('dimension', 'like', '%' . $keyword . '%')
                ->orWhere('weight', 'like', '%' . $keyword . '%')
                ->orWhere('price', 'like', '%' . $keyword . '%')
                ->orWhereHas('aisle', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
        });
    }
}
