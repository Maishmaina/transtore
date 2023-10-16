<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\AccountCreated;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {
            $password = Str::random(8);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($password),
            ]);
        } catch (Exception $e) {
            return $this->respondWithError('Failed to create user', $e);
        }

        try {
            Mail::to($user->email)->send(new AccountCreated($user, $password));
        } catch (Exception $e) {
            DB::rollBack();

            return $this->respondWithError('Failed to send email', $e);
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
