<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\StorageType;
use Illuminate\Http\Request;

class StoreRentController extends Controller
{
    //
    public function getStorageType(){
        return response()->json(StorageType::with('subtypes')->withCount('subtypes')->get());
    }
}
