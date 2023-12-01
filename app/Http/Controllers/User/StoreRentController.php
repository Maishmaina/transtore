<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\StorageSubtype;
use App\Models\StorageType;
use Illuminate\Http\Request;

class StoreRentController extends Controller
{
    //
    public function getStorageType(){
        return response()->json(StorageType::with('subtypes')->withCount('subtypes')->get());
    }

    public function filterFacilityUnit(Request $request){

        //get all units with storage type $[request]
        $getFacility = [];
        $loc=$request->location;
        try {
             $getStore = StorageSubtype::find($request->store_sub_type);
             $getFacility = $getStore->facilities()
                                ->where('location', 'LIKE', '%'.$loc.'%')
                                ->paginate(10);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Sorry, No result found for this query'
            ], 404);
        }
        return response()->json($getFacility);
    }
}
