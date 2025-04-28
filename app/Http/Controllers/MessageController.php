<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\NewMessageReply;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        try {
            \Log::info('Incoming message request', [
                'request_data' => $request->all(),
                'user_authenticated' => auth()->check(),
                'user_id' => auth()->id()
            ]);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'content' => 'required|string'
            ]);

            $messageData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'content' => $request->content,
                'is_active' => true,
                'read_status' => 'unread'
            ];

            // Jika user sudah login, tambahkan user_id
            if (auth()->check()) {
                $messageData['user_id'] = auth()->id();
            }

            \Log::info('Creating message with data', [
                'message_data' => $messageData
            ]);

            $message = Message::create($messageData);

            \Log::info('Message created successfully', [
                'message_id' => $message->id
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim',
                    'data' => $message
                ]);
            }

            return redirect()->route('home')->with('success', 'Pesan berhasil dikirim');
        } catch (ValidationException $e) {
            \Log::error('Validation error in store message', [
                'errors' => $e->errors()
            ]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Error in store message: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim pesan',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengirim pesan. Silakan coba lagi.');
        }
    }

    public function index(Request $request)
    {
        $messages = Message::with('replies')->latest()->get();
        $selectedMessage = null;
        if ($request->has('selected')) {
            $selectedMessage = $messages->where('id', $request->selected)->first();
            if ($selectedMessage && $selectedMessage->read_status == 'unread') {
                $selectedMessage->update(['read_status' => 'read']);
            }
        }
        return view('admin.messages.index', compact('messages', 'selectedMessage'));
    }

    public function show(Message $message)
    {
        $message->update(['status' => 'read']);
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus!');
    }

    public function getLatestReplies(Message $message, Request $request)
    {
        $lastReplyId = $request->query('last_reply_id', 0);
        
        $replies = $message->replies()
            ->where('id', '>', $lastReplyId)
            ->with('user')
            ->get()
            ->map(function($reply) {
                return [
                    'id' => $reply->id,
                    'content' => $reply->content,
                    'created_at' => $reply->created_at->format('H:i'),
                    'message_id' => $reply->message_id,
                    'user' => [
                        'name' => $reply->user->name
                    ]
                ];
            });

        return response()->json(['replies' => $replies]);
    }

    public function reply(Request $request, Message $message)
    {
        try {
            // Hapus semua validasi

            if (!$message->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat membalas chat yang sudah diakhiri'
                ], 400);
            }

            $attachment = null;
            $fileUrl = null;
            if ($request->hasFile('file')) {
                try {
                    $attachment = $request->file('file')->store('chat_attachments', 'public');
                    $fileUrl = asset('storage/' . $attachment);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal upload file: ' . $e->getMessage()
                    ], 500);
                }
            }

            $reply = $message->replies()->create([
                'content' => $request->content,
                'user_id' => auth()->id(),
                'attachment' => $attachment
            ]);

            $reply->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim',
                'reply' => [
                    'id' => $reply->id,
                    'content' => $reply->content,
                    'created_at' => $reply->created_at->format('Y-m-d H:i:s'),
                    'user_name' => $reply->user->name,
                    'file_url' => $fileUrl
                ],
                'file_url' => $fileUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim balasan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function userMessages()
    {
        $messages = Message::where('user_id', auth()->id())
            ->with(['replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messages.index', compact('messages'));
    }

    public function checkActiveChat()
    {
        try {
            \Log::info('Checking active chat', [
                'user_authenticated' => auth()->check(),
                'user_id' => auth()->id()
            ]);

            if (!auth()->check()) {
                return response()->json([
                    'success' => true,
                    'has_active_chat' => false,
                    'message' => 'Silakan login terlebih dahulu untuk memeriksa status chat'
                ]);
            }

            $activeChat = Message::where('user_id', auth()->id())
                               ->where('is_active', true)
                               ->with(['replies' => function($query) {
                                   $query->with('user');
                               }])
                               ->first();

            \Log::info('Active chat found', [
                'has_active_chat' => !is_null($activeChat),
                'chat_id' => $activeChat ? $activeChat->id : null
            ]);

            return response()->json([
                'success' => true,
                'has_active_chat' => !is_null($activeChat),
                'message' => !is_null($activeChat) 
                    ? 'Anda memiliki chat yang sedang aktif' 
                    : 'Tidak ada chat aktif',
                'active_chat' => $activeChat ? [
                    'id' => $activeChat->id,
                    'subject' => $activeChat->subject,
                    'content' => $activeChat->content,
                    'created_at' => $activeChat->created_at->format('H:i'),
                    'replies' => $activeChat->replies->map(function($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'created_at' => $reply->created_at->format('H:i'),
                            'user_name' => $reply->user->name,
                            'is_admin' => $reply->user->role === 'admin'
                        ];
                    })
                ] : null
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in checkActiveChat: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memeriksa status chat. Silakan coba lagi.'
            ], 500);
        }
    }

    public function endChat(Message $message)
    {
        try {
            if (!$message->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat sudah diakhiri sebelumnya'
                ], 400);
            }

            $message->update([
                'is_active' => false,
                'ended_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Chat berhasil diakhiri'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengakhiri chat'
            ], 500);
        }
    }

    public function chatHistory()
    {
        $messages = Message::where('user_id', auth()->id())
            ->where('chat_status', 'ended')
            ->with(['replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messages.history', compact('messages'));
    }

    public function adminChatHistory()
    {
        $messages = Message::where('chat_status', 'ended')
            ->with(['replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.messages.history', compact('messages'));
    }

    public function resetPassword(Request $request, Message $message)
    {
        try {
            // Cari user berdasarkan email pesan
            $user = User::where('email', $message->email)->first();
            if (!$user) {
                return back()->with('error', 'User dengan email ini tidak ditemukan.');
            }
            $newPassword = Str::random(8);
            $user->password = Hash::make($newPassword);
            $user->save();

            // Kirim password baru ke email user
            try {
                Mail::send('emails.reset-password', [
                    'password' => $newPassword
                ], function($mail) use ($user) {
                    $mail->to($user->email)
                        ->subject('Password Anda Telah Direset');
                });
            } catch (\Exception $mailEx) {
                \Log::error('Gagal mengirim email reset password: ' . $mailEx->getMessage());
            }

            // Kirim password baru ke chat user (balasan pesan)
            $message->replies()->create([
                'content' => 'Password baru Anda: ' . $newPassword,
                'user_id' => auth()->id()
            ]);

            return back()->with('success', 'Password berhasil direset dan dikirim ke email serta chat user.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
