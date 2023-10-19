<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\Welcome;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.exists' => "No user with the provided email"
        ]);

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Incorrect credentials'
            ], 422);
        }

        $token = $user->createToken('User Token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function register(UserRequest $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $verificationCode = $this->generateCode('verification_code');

        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'verification_code' => $verificationCode,
                'password' => Hash::make($request->password)
            ]);

            Mail::to($user->email)->send(new Welcome($user));

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'User created successfully',
            'user' => new UserResource($user)
        ], 201);
    }

    public function verifyAccount(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|exists:users,verification_code'
        ]);

        $user = User::where('verification_code', $request->verification_code)->first();

        try {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to verify account',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Account verified successfully'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => "No user with the provided email"
        ]);

        $user = User::where('email', $request->email)->first();

        $resetCode = $this->generateCode('reset_code');

        DB::beginTransaction();
        $user->reset_code = $resetCode;
        $user->save();

        try {
            Mail::to($user->email)->send(new ResetPassword($user));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to send password reset email',
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'message' => 'Password reset email sent successfully'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_code' => 'required|exists:users,reset_code',
            'password' => 'required'
        ]);

        $user = User::where('reset_code', $request->reset_code)->first();

        try {
            $user->reset_code = null;
            $user->password = Hash::make($request->password);
            $user->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to reset password',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Password reset successfully'
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        try {
            $user->currentAccessToken()->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error logging user out',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function generateCode(string $field): int
    {
        $code = mt_rand(1000, 9999);

        while (User::where($field, $code)->exists()) {
            $code = mt_rand(1000, 9999);
        }

        return $code;
    }
}
