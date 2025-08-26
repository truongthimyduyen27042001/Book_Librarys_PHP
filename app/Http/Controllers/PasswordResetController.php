<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Helpers\LogHelper;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        LogHelper::api('Password Reset: Requesting reset link', 'info', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        try {
            $status = Password::sendResetLink($request->only('email'));

            if ($status === Password::RESET_LINK_SENT) {
                LogHelper::api('Password Reset: Reset link sent successfully', 'info', [
                    'email' => $request->email,
                ]);

                return response()->json([
                    'message' => 'Password reset link sent to your email.',
                    'status' => 'success'
                ]);
            } else {
                LogHelper::api('Password Reset: Failed to send reset link', 'error', [
                    'email' => $request->email,
                    'status' => $status,
                ]);

                return response()->json([
                    'message' => 'Unable to send password reset link.',
                    'status' => 'error'
                ], 400);
            }
        } catch (\Exception $e) {
            LogHelper::error('Password Reset: Exception occurred', $e, [
                'email' => $request->email,
            ]);

            return response()->json([
                'message' => 'An error occurred while processing your request.',
                'status' => 'error'
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        LogHelper::api('Password Reset: Attempting to reset password', 'info', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    LogHelper::api('Password Reset: Password updated successfully', 'info', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                    ]);
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'message' => 'Password has been reset successfully.',
                    'status' => 'success'
                ]);
            } else {
                LogHelper::api('Password Reset: Failed to reset password', 'error', [
                    'email' => $request->email,
                    'status' => $status,
                ]);

                return response()->json([
                    'message' => 'Unable to reset password. Please check your token and try again.',
                    'status' => 'error'
                ], 400);
            }
        } catch (\Exception $e) {
            LogHelper::error('Password Reset: Exception occurred during reset', $e, [
                'email' => $request->email,
            ]);

            return response()->json([
                'message' => 'An error occurred while resetting your password.',
                'status' => 'error'
            ], 500);
        }
    }
}
