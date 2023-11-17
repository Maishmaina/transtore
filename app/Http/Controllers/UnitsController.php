<?php

namespace App\Http\Controllers;

use App\Models\Aisles;
use App\Models\Sections;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //fetch all units and their
        $units=Units::with(['aisle','aisle.section','unit_size'])
            ->search($request->search)
            ->whereHas('aisle.section', function ($q) use ($request) {$q->where('facility_id',$request->facility);})
            ->latest()
            ->paginate(10);
            return response()->json($units);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        DB::transaction(function () use ($request) {
            $section = Sections::create([
                'name'=>$request->section['section'],
                'facility_id'=>(int)$request->facility
            ]);
            foreach ($request->result_aisle as $value) {
            $aisle = Aisles::create([
                'name'=>$value['name'],
                'number_of_units'=>$value['units'],
                'section_id'=>$section->id,
            ]);
                foreach ($value['unitsDetails'] as $value2) {
                    Units::create([
                        'name'=>$value2['unitName'],
                        'aisle_id'=>$aisle->id,
                        'size'=>$value2['size'],
                        'dimension'=>$value2['dimension'],
                        'weight'=>$value2['weight'],
                        'price'=>(int)$value2['price'],
                    ]);
                }
            }
        });
          return response()->json([
            'message' => 'success'
        ], 201);
        } catch (\Throwable $th){
             return response()->json([
            'message' => 'error'
        ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
