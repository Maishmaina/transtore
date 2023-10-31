<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait UserScopesTrait
{
    public function scopeFirstName($query, $keyword)
    {
        return $query->where('first_name', 'like', '%' . $keyword . '%');
    }

    public function scopeLastName($query, $keyword)
    {
        return $query->where('last_name', 'like', '%' . $keyword . '%');
    }

    public function scopePhoneNumber($query, $keyword)
    {
        if ($keyword) {
            return $query->where('phone_number', 'like', '%' . $keyword . '%');
        } else {
            return $query;
        }
    }

    public function scopeEmail($query, $keyword)
    {
        return $query->where('email', 'like', '%' . $keyword . '%');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('first_name', 'like', '%' . $keyword . '%')
            ->orWhere('last_name', 'like', '%' . $keyword . '%')
            ->orWhere('phone_number', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%');
    }
}
