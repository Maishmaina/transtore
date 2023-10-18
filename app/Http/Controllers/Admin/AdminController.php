<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin;
use Illuminate\Support\Str;
use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $admins = Admin::query()
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
        DB::beginTransaction();

        try {
            $password = Str::random(8);

            $admin = Admin::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($password),
                'enabled' => $request->enabled
            ]);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create admin', $e);
        }

        try {
            Mail::to($admin->email)->send(new AccountCreated($admin, $password));
        } catch (Exception $e) {
            return $this->respondWithError('Failed to send email', $e);
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
        try {
            $admin->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'enabled' => $request->enabled
            ]);
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
