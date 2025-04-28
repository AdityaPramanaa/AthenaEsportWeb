<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function store(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'content' => 'required|string'
            ]);

            $message = Message::create([
                'subjek' => $validated['subject'],
                'content' => $validated['content'],
                'user_id' => auth()->id(),
                'nama_lengkap' => auth()->user()->name,
                'email' => auth()->user()->email,
                'status' => 'unread',
                'chat_status' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
                'data' => $message
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in store message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
} 