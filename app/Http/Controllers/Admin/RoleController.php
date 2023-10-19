<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate = $request->query('paginate', 'true');

        $roles = Role::with('permissions')->withCount('permissions', 'users');

        if ($paginate == 'true') {
            $roles = $roles->paginate();
        } else {
            $roles = $roles->get();
        }

        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $role = Role::create([
                'guard_name' => 'admin_api',
                'name' => $request->name
            ]);
        } catch (Exception $e) {
            $this->respondWithError('Failed to create role', $e);
        }

        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $role->update([
                'name' => $request->name
            ]);
        } catch (Exception $e) {
            $this->respondWithError('Failed to update role', $e);
        }

        return response()->json([
            'message' => "Role updated successfully",
            "role" => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->id == 1) {
            return response()->json([
                'message' => 'Cannot delete Super Admin role!'
            ], 403);
        }
        return $this->destroyModel($role);
    }

    public function syncPermissions(Request $request)
    {
        $role = Role::find($request->role_id);

        try {
            $role->syncPermissions($request->permissions);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to sync permissions', $e);
        }

        return response()->json([
            'message' => 'Permissions synced successfully'
        ]);
    }
}
