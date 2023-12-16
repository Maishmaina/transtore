<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Facility;
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
                                 ->FacilityReviewAvg()
                                 ->ReturnBasicUnits()
                                 ->where('location', 'LIKE', '%'.$loc.'%')
                                 ->orderBy('id','DESC')
                                 ->paginate(10);


        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Sorry, No result found for this query'.$th
            ], 404);
        }
        return response()->json($getFacility);
    }

    public function fetchUnitBySizeForFacility(Facility $facility){

        $unit_by_size = [];
        $result = $facility->load(['section.aisle.units' => function ($q){
            $q->where('available_status','1');}]);

            foreach ($result->section as  $value){

            foreach ($value->aisle as $units){

                foreach ($units->units as  $cell){

                    $propertyValues = array_column($unit_by_size, 'size');

                    if (!in_array($cell->size, $propertyValues)){
                        array_push($unit_by_size,$cell);
                    }

                }
             }
            }
        return response()->json($unit_by_size);
    }
}
