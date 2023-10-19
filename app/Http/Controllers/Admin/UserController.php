<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\SendAccountCreatedEmail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::search($request->search)
            ->firstName($request->first_name)
            ->lastName($request->last_name)
            ->phoneNumber($request->phone_number)
            ->email($request->email)
            ->status($request->status)
            ->date($request->from_date, $request->to_date)
            ->latest()
            ->paginate();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $password = Str::random(8);

        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($password),
                'enabled' => $request->enabled
            ]);

            SendAccountCreatedEmail::dispatch($user, $password);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create user', $e);
        }

        DB::commit();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'enabled' => $request->enabled
            ]);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to update user', $e);
        }

        return response()->json([
            'message' => "User updated successfully",
            'user' => new UserResource($user->fresh())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $this->destroyModel($user);
    }
}
