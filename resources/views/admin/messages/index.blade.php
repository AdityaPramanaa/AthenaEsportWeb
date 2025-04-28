@extends('layouts.admin-tailwind')
@section('title', 'Pesan Masuk')
@section('content')
<div class="flex flex-col md:flex-row h-[80vh] bg-white rounded-lg shadow overflow-hidden">
    <!-- Sidebar daftar pesan -->
    <div class="w-full md:w-1/3 lg:w-1/4 border-r bg-gray-50 flex flex-col min-h-0">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Pesan Masuk</h2>
        </div>
        <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
            @forelse($messages as $msg)
            <a href="{{ route('admin.messages.index', ['selected' => $msg->id]) }}" class="block group focus:outline-none">
                <div class="flex items-center gap-3 px-4 py-3 cursor-pointer transition {{ $selectedMessage && $selectedMessage->id == $msg->id ? 'bg-blue-100' : 'hover:bg-blue-50' }}">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold text-lg">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-900 truncate">{{ $msg->name }}</span>
                            <span class="text-xs text-gray-400 ml-2">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                        <div class="text-xs text-gray-600 truncate">{{ $msg->subject }}</div>
                    </div>
                    @if($msg->read_status == 'unread')
                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                    @endif
                </div>
            </a>
            @empty
            <div class="p-4 text-center text-gray-400">Tidak ada pesan.</div>
            @endforelse
        </div>
    </div>
    <!-- Chat area -->
    <div class="flex-1 flex flex-col min-h-0 bg-gray-100">
        @if($selectedMessage)
        <div class="flex items-center justify-between p-4 border-b bg-white">
            <div>
                <div class="font-semibold text-gray-900">{{ $selectedMessage->name }}</div>
                <div class="text-xs text-gray-500">{{ $selectedMessage->email }}</div>
            </div>
            <div class="flex gap-2">
                @if($selectedMessage->subject == 'Permintaan Reset Password')
                <form action="{{ route('admin.messages.resetPassword', $selectedMessage) }}" method="POST" onsubmit="return confirm('Reset password user?')">
                    @csrf
                    <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">Reset Password</button>
                </form>
                @endif
                <form action="{{ route('admin.messages.destroy', $selectedMessage) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Hapus</button>
                </form>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 flex flex-col-reverse">
            <!-- Balasan -->
            @foreach($selectedMessage->replies->reverse() as $reply)
            <div class="flex items-end gap-3 {{ $reply->user_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-700 font-bold text-base">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <div class="bg-blue-100 rounded-lg px-4 py-2 shadow text-gray-900 max-w-xs md:max-w-md lg:max-w-lg break-words">
                        <div class="text-sm">{{ $reply->content }}</div>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">{{ $reply->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>
            @endforeach
            <!-- Pesan utama -->
            <div class="flex items-end gap-3">
                <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold text-base">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <div class="bg-white rounded-lg px-4 py-2 shadow text-gray-900 max-w-xs md:max-w-md lg:max-w-lg break-words">
                        <div class="font-semibold mb-1">{{ $selectedMessage->subject }}</div>
                        <div class="text-sm">{{ $selectedMessage->content }}</div>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">{{ $selectedMessage->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
        <!-- Form balas pesan -->
        <form action="{{ route('admin.messages.reply', $selectedMessage) }}" method="POST" class="p-4 border-t bg-white flex gap-2">
            @csrf
            <input type="text" name="content" class="flex-1 rounded-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors text-gray-900 px-3 py-2" placeholder="Ketik balasan..." required autocomplete="off">
            <button type="submit" class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="bi bi-send"></i>
            </button>
        </form>
        @else
        <div class="flex-1 flex items-center justify-center text-gray-400">
            <span>Pilih pesan untuk melihat detail</span>
        </div>
        @endif
    </div>
</div>
@endsection 