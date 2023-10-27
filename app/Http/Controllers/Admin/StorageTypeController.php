<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\StorageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StorageSubtype;

class StorageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(StorageType::with('subtypes')->withCount('subtypes')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        try {
            $storageType = StorageType::create($validated);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create storage type', $e);
        }

        return response()->json($storageType->fresh(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(StorageType $storageType)
    {
        return response()->json($storageType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StorageType $storageType)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        try {
            $storageType->update($validated);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to update storage type', $e);
        }

        return response()->json($storageType->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StorageType $storageType)
    {
        return $this->destroyModel($storageType);
    }
}
