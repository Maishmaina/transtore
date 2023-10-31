<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $facilities = Facility::with('owner')
            ->search($request->search)
            ->facilityOwner($request->facility_owner_id)
            ->name($request->name)
            ->location($request->location)
            ->date($request->form_date, $request->to_date)
            ->latest()
            ->paginate();

        return response()->json($facilities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_owner_id' => 'required',
            'name' => 'required',
            'location' => 'required',
            'location_latitude' => 'required',
            'location_longitude' => 'required',
            'access_period' => 'required',
        ]);

        try {
            $facility = Facility::create($validated);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create facility',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Facility created successfully',
            'facility' => $facility
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return response()->json($facility);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'facility_owner_id' => 'required',
            'name' => 'required',
            'location' => 'required',
            'location_latitude' => 'required',
            'location_longitude' => 'required',
            'access_period' => 'required',
        ]);

        try {
            $facility->update($validated);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update facility',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Facility updated successfully',
            'facility' => $facility->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        return $this->destroyModel($facility);
    }
}
