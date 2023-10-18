<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait UserTrait
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

    public function scopeStatus($query, $keyword)
    {
        return $query->when($keyword == 'enabled', function ($query) {
            $query->where('enabled', true);
        })
            ->when($keyword == 'disabled', function ($query) {
                $query->where('enabled', false);
            });
    }

    public function scopeDate($query, $from, $to)
    {
        if ($from && $to) {
            return $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)->addDay()]);
        } elseif (!$from && $to) {
            return $query->whereDate('created_at', '<=', Carbon::parse($to)->addDay());
        } else {
            return $query;
        }
    }
}
