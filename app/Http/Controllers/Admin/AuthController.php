<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Admin;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AdminResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required'
        ], [
            'email.exists' => "No admin with the provided email"
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'Incorrect credentials'
            ], 422);
        }

        return response()->json([
            'admin' => new AdminResource($admin),
            'token' => $admin->createToken('Admin Token')->plainTextToken,
            'permissions' => $admin->getAllPermissions()->pluck('name')
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ], [
            'email.exists' => "No admin with the provided email"
        ]);

        $admin = Admin::where('email', $request->email)->first();

        $resetCode = $this->generateCode();

        DB::beginTransaction();

        try {
            $admin->reset_code = $resetCode;
            $admin->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }

        try {
            Mail::to($admin->email)->send(new ResetPassword($admin));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send password reset email',
                'error' => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Password reset email sent successfully'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_code' => 'required|exists:admins,reset_code',
            'password' => 'required|confirmed'
        ]);

        $admin = Admin::where('reset_code', $request->reset_code)->first();

        try {
            $admin->reset_code = null;
            $admin->password = Hash::make($request->password);
            $admin->save();
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
        $admin = $request->user();

        try {
            $admin->currentAccessToken()->delete();
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

    public function generateCode(): int
    {
        $code = mt_rand(1000, 9999);

        while (Admin::where('reset_code', $code)->exists()) {
            $code = mt_rand(1000, 9999);
        }

        return $code;
    }
}
