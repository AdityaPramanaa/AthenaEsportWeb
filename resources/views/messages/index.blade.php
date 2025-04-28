<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Pesan Saya</h2>
                        <button onclick="openModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Kirim Pesan Baru
                        </button>
                    </div>

                    @if($messages->isEmpty())
                        <p class="text-gray-500 text-center py-8">Belum ada pesan.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($messages as $message)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ $message->subject }}</h3>
                                            <p class="text-sm text-gray-500">{{ $message->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $message->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($message->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="prose max-w-none mb-4">
                                        <p class="text-gray-700">{{ $message->content }}</p>
                                    </div>

                                    @if($message->replies->isNotEmpty())
                                        <div class="mt-4 space-y-4">
                                            <h4 class="text-sm font-medium text-gray-900">Balasan:</h4>
                                            @foreach($message->replies as $reply)
                                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $reply->user->name }}
                                                            <span class="text-gray-500 text-xs ml-2">{{ $reply->created_at->format('d M Y H:i') }}</span>
                                                        </p>
                                                    </div>
                                                    <p class="text-gray-700">{{ $reply->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($message->status === 'open')
                                        <div class="mt-4">
                                            <form action="{{ route('messages.reply', $message) }}" method="POST" class="space-y-4">
                                                @csrf
                                                <div>
                                                    <textarea name="content" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis balasan..."></textarea>
                                                </div>
                                                <div class="flex justify-end">
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        Kirim Balasan
                                                    </button>
                                                </div>
                                            </form>
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

    <!-- Modal Kirim Pesan -->
    <div id="messageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 100;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Kirim Pesan ke Admin</h3>
                <form action="{{ route('admin-messages.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700">Subjek</label>
                        <input type="text" name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Pesan</label>
                        <textarea name="content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('messageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }
    </script>
</x-app-layout> 