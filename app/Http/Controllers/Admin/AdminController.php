<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdminResource;
use App\Jobs\SendAccountCreatedEmail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $admins = Admin::with('roles')
            ->search($request->search)
            ->firstName($request->first_name)
            ->lastName($request->last_name)
            ->phoneNumber($request->phone_number)
            ->email($request->email)
            ->status($request->status)
            ->date($request->from_date, $request->to_date)
            ->latest()
            ->paginate();

        return AdminResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $role = Role::find($request->role);

        $password = Str::random(8);

        DB::beginTransaction();

        try {
            $admin = Admin::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($password),
                'enabled' => $request->enabled
            ]);

            $admin->assignRole($role->name);

            SendAccountCreatedEmail::dispatch($admin, $password);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create admin', $e);
        }

        DB::commit();

        return (new AdminResource($admin))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $role = Role::find($request->role);

        try {
            $admin->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'enabled' => $request->enabled
            ]);

            $admin->syncRoles([$role->name]);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to update admin', $e);
        }

        return response()->json([
            'message' => "Admin updated successfully",
            'admin' => new AdminResource($admin->fresh())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Admin $admin)
    {
        if ($request->user()->cannot('destroy', $admin)) {
            return response()->json([
                'message' => 'You cannot delete yourself!'
            ], 403);
        }

        return $this->destroyModel($admin);
    }
}
