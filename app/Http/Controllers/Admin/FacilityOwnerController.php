<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\FacilityOwner;
use App\Http\Controllers\Controller;

class FacilityOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate = $request->query('paginate', 'true');

        $facilityOwners = FacilityOwner::search($request->search)
            ->firstName($request->first_name)
            ->lastName($request->last_name)
            ->phoneNumber($request->phone_number)
            ->email($request->email)
            ->date($request->from_date, $request->to_date)
            ->latest();

        if ($paginate == 'true') {
            $facilityOwners = $facilityOwners->paginate();
        } else {
            $facilityOwners = $facilityOwners->get();
        }

        return response()->json($facilityOwners);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'nullable',
            'email' => 'required|email|unique:facility_owners,email',
        ]);

        try {
            $facilityOwner = FacilityOwner::create($validated);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create facility owner', $e);
        }

        return response()->json($facilityOwner->fresh(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FacilityOwner $facilityOwner)
    {
        return response()->json($facilityOwner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FacilityOwner $facilityOwner)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'nullable',
            'email' => 'required|email|unique:facility_owners,email,except,' . $facilityOwner,
        ]);

        try {
            $facilityOwner->update($validated);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to update facility owner', $e);
        }

        return response()->json($facilityOwner->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacilityOwner $facilityOwner)
    {
        return $this->destroyModel($facilityOwner);
    }
}
