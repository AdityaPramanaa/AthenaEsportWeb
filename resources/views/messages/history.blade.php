<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Riwayat Chat</h2>
                    
                    @if($messages->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada riwayat chat.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($messages as $message)
                                <div class="bg-gray-50 rounded-lg p-6 shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $message->subject }}</h3>
                                            <p class="text-sm text-gray-500">
                                                Dibuat: {{ $message->created_at->format('d M Y H:i') }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Diakhiri: {{ $message->ended_at->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                            Selesai
                                        </span>
                                    </div>

                                    <!-- Pesan Awal -->
                                    <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                        <p class="text-gray-700">{{ $message->content }}</p>
                                    </div>

                                    <!-- Balasan -->
                                    @if($message->replies->isNotEmpty())
                                        <div class="space-y-4">
                                            @foreach($message->replies as $reply)
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                                            <span class="text-white text-sm">{{ substr($reply->user->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div class="bg-white rounded-lg p-4 shadow-sm">
                                                            <div class="flex justify-between items-center mb-2">
                                                                <span class="font-medium text-gray-900">{{ $reply->user->name }}</span>
                                                                <span class="text-sm text-gray-500">{{ $reply->created_at->format('H:i') }}</span>
                                                            </div>
                                                            <p class="text-gray-700">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 