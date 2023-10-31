<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait GlobalScopesTrait
{
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
