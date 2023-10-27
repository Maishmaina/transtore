<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\StorageSubtype;
use App\Http\Controllers\Controller;

class StorageSubtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'storage_type_id' => 'required',
            'name' => 'required'
        ]);

        try {
            $storageSubtype = StorageSubtype::create($validated);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create storage subtype', $e);
        }

        return response()->json($storageSubtype->fresh(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StorageSubtype $storageSubtype)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        try {
            $storageSubtype->update($validated);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to update storage subtype', $e);
        }

        return response()->json($storageSubtype->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StorageSubtype $storageSubtype)
    {
        return $this->destroyModel($storageSubtype);
    }
}
