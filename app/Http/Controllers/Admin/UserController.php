<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function resetPassword(Request $request, User $user)
    {
        try {
            // Tentukan password baru
            $newPassword = $request->manual_password ?? Str::random(8);
            
            // Update password user
            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            // Kirim password baru ke email user (try-catch terpisah)
            try {
                Mail::send('emails.reset-password', [
                    'password' => $newPassword,
                    'is_manual' => !is_null($request->manual_password)
                ], function($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Password Anda Telah Direset');
                });
            } catch (\Exception $mailEx) {
                // Log error email, tapi lanjutkan proses
                \Log::error('Gagal mengirim email reset password: ' . $mailEx->getMessage());
            }

            // Kirim password baru ke chat user (jika ada chat aktif)
            $message = \App\Models\Message::where('user_id', $user->id)->where('is_active', true)->first();
            if ($message) {
                $message->replies()->create([
                    'content' => 'Password baru Anda: ' . $newPassword,
                    'user_id' => auth()->id()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset dan dikirim ke email user'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
} 