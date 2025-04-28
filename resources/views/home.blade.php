<x-app-layout>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @push('css')
    <style>
    /* Responsive & Modern Chat Bubble */
    #chatWidgetContainer {
        z-index: 9999;
    }
    #activeChatModal {
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        border-radius: 1.2rem;
        border: 1.5px solid #3b82f6;
        width: 350px;
        max-width: 95vw;
        min-height: 350px;
        max-height: 70vh;
        display: flex;
        flex-direction: column;
        background: #fff;
        transition: all 0.2s;
    }
    #activeChatModal .bg-blue-500 {
        border-radius: 1.2rem 1.2rem 0 0;
    }
    #activeChatMessages {
        overflow-y: auto;
        flex: 1;
        padding-bottom: 0.5rem;
    }
    #activeChatModal form {
        background: #f8fafc;
        border-radius: 0 0 1.2rem 1.2rem;
    }
    #activeChatModal input[type="text"] {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
    #activeChatModal .fa-paperclip {
        font-size: 1.2rem;
    }
    #activeChatModal .fa-paper-plane {
        font-size: 1.2rem;
    }
    #activeChatModal .bg-blue-500.text-white {
        background: linear-gradient(90deg, #2563eb 60%, #60a5fa 100%);
    }
    #activeChatModal .bg-gray-100.text-gray-900 {
        background: #f1f5f9;
    }
    #activeChatModal .rounded-lg {
        border-radius: 1rem;
    }
    @media (max-width: 600px) {
        #activeChatModal {
            width: 98vw;
            min-width: 0;
            right: 0;
            left: 0;
            bottom: 0;
            margin: 0 auto;
            border-radius: 1.2rem 1.2rem 0 0;
            max-height: 90vh;
        }
        #chatWidgetContainer {
            right: 0;
            left: 0;
            bottom: 0;
            margin: 0 auto;
            align-items: center;
        }
    }
    </style>
    @endpush

    <!-- Welcome Section -->
    <section class="bg-gradient-to-b from-blue-100 to-white min-h-[70vh] flex items-center justify-center relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-display font-bold mb-6 gradient-text" style="font-family: 'Poppins', sans-serif;">
                    Selamat Datang di Athena E-Sport
                </h1>
                <p class="text-xl md:text-2xl mb-8 leading-relaxed" style="color:#1e293b; font-family: 'Poppins', sans-serif;">
                    Bergabunglah dengan komunitas gaming terbesar dan terbaik. Temukan passion mu dalam dunia E-Sport bersama kami!
                </p>
                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('about') }}" class="btn-primary text-lg px-8 py-4 rounded-xl hover:scale-105 transition-all duration-300" style="font-family: 'Poppins', sans-serif;">
                        Tentang Kami <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Section -->
    <section class="py-20 bg-blue-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="section-title" style="font-family: 'Poppins', sans-serif;">Events</h1>
                <p class="text-lg max-w-2xl mx-auto" style="color:#1e293b; font-family: 'Poppins', sans-serif;">
                    Event dari seluruh Bali termasuk event internal Athena E-Sport
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($latestEvents as $event)
                <div class="card fade-in-up hover:scale-105">
                    <div class="relative">
                        <img src="{{ Storage::url($event->poster_path) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-48 object-cover rounded-t-xl"
                             onerror="this.src='{{ asset('images/default-event.jpg') }}'">
                        <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm shadow">
                            {{ ucfirst($event->status) }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">{{ $event->title }}</h3>
                        <p class="mb-4" style="color:#1e293b; font-family: 'Poppins', sans-serif;">{{ Str::limit($event->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span style="color:#2563eb; font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $event->event_date ? $event->event_date->format('d M, Y') : 'TBA' }}
                            </span>
                            <a href="{{ route('events.show', $event) }}" class="btn-primary btn-sm" style="font-family: 'Poppins', sans-serif;">Daftar</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <div class="text-gray-500">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p class="text-lg" style="font-family: 'Poppins', sans-serif;">Belum ada event yang tersedia</p>
                        @if(config('app.debug'))
                        <div class="mt-4 text-sm text-left bg-gray-100 p-4 rounded">
                            <p>Debug Info:</p>
                            <ul class="list-disc pl-4">
                                <li>Total Events: {{ \App\Models\Event::count() }}</li>
                                <li>Published Events: {{ \App\Models\Event::where('status', 'published')->count() }}</li>
                                <li>Future Events: {{ \App\Models\Event::where('event_date', '>=', now())->count() }}</li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>
            @if($latestEvents->isNotEmpty())
            <div class="text-center mt-12">
                <a href="{{ route('events.index') }}" class="btn-primary" style="font-family: 'Poppins', sans-serif;">
                    Lihat Semua Event <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Games Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="section-title" style="font-family: 'Poppins', sans-serif;">Games</h2>
                <p class="text-lg max-w-2xl mx-auto" style="color:#1e293b; font-family: 'Poppins', sans-serif;">
                    Bertanding di game favoritmu dan jadilah juara!
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Free Fire -->
                <div class="card p-4 fade-in-up hover:scale-105">
                    <img src="{{ asset('storage/images/games/ff.jpg') }}" alt="Free Fire" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Free Fire</h3>
                    <a href="#" class="text-blue-500 hover:text-blue-700 transition-colors inline-flex items-center" style="font-family: 'Poppins', sans-serif;">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <!-- Tekken -->
                <div class="card p-4 fade-in-up hover:scale-105">
                    <img src="{{ asset('storage/images/games/tekken.jpg') }}" alt="Tekken" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Tekken</h3>
                    <a href="#" class="text-blue-500 hover:text-blue-700 transition-colors inline-flex items-center" style="font-family: 'Poppins', sans-serif;">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <!-- Mobile Legends -->
                <div class="card p-4 fade-in-up hover:scale-105">
                    <img src="{{ asset('storage/images/games/ml.jpg') }}" alt="Mobile Legends" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Mobile Legends</h3>
                    <a href="#" class="text-blue-500 hover:text-blue-700 transition-colors inline-flex items-center" style="font-family: 'Poppins', sans-serif;">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <!-- Valorant -->
                <div class="card p-4 fade-in-up hover:scale-105">
                    <img src="{{ asset('storage/images/games/valo.jpg') }}" alt="Valorant" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">Valorant</h3>
                    <a href="#" class="text-blue-500 hover:text-blue-700 transition-colors inline-flex items-center" style="font-family: 'Poppins', sans-serif;">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <!-- PUBG Mobile -->
                <div class="card p-4 fade-in-up hover:scale-105">
                    <img src="{{ asset('storage/images/games/pubg.png') }}" alt="PUBG Mobile" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2" style="color:#2563eb; font-family: 'Poppins', sans-serif;">PUBG Mobile</h3>
                    <a href="#" class="text-blue-500 hover:text-blue-700 transition-colors inline-flex items-center" style="font-family: 'Poppins', sans-serif;">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-20 bg-blue-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="section-title" style="font-family: 'Poppins', sans-serif;">Gallery</h2>
                <p class="text-lg max-w-2xl mx-auto" style="color:#1e293b; font-family: 'Poppins', sans-serif;">
                    Momen terbaik dari turnamen dan event kami
                </p>
            </div>
            <!-- Grid untuk 5 gambar dalam satu baris -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @forelse($galleries ?? [] as $gallery)
                    <div class="relative group overflow-hidden rounded-xl bg-blue-100 fade-in-up">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                             alt="{{ $gallery->title }}" 
                             class="w-full h-48 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-400/80 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end p-4">
                            <div>
                                <h4 class="text-white font-bold text-lg" style="font-family: 'Poppins', sans-serif;">{{ $gallery->title }}</h4>
                                <p class="text-blue-100 text-sm" style="font-family: 'Poppins', sans-serif;">{{ $gallery->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-blue-400 text-lg" style="font-family: 'Poppins', sans-serif;">Belum ada foto di gallery.</p>
                    </div>
                @endforelse
            </div>

            @if($galleries->isNotEmpty())
            <div class="text-center mt-12">
                <a href="{{ route('galleries.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-all duration-300 hover:scale-105" style="font-family: 'Poppins', sans-serif;">
                    Lihat Semua Gallery <i class="fas fa-images ml-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.fade-in-up').forEach((el) => observer.observe(el));
    });
    </script>
    @endpush

    <!-- Floating Chat Button & Form -->
    @auth
        <div id="chatWidgetContainer" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
            <!-- Chat Bubble (Active Chat Modal) -->
            <div id="activeChatModal" class="hidden w-80 max-w-full bg-white rounded-xl shadow-lg mb-2 border border-blue-200 flex flex-col" style="min-height:350px; max-height:70vh;">
                <div class="bg-blue-500 p-4 rounded-t-xl flex justify-between items-center">
                    <h3 class="text-lg font-medium text-white mb-0" id="activeChatSubject"></h3>
                    <button onclick="closeActiveChatModal()" class="text-white hover:text-blue-100 text-xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="activeChatMessages" style="max-height:250px;"></div>
                <form id="chatForm" class="p-4 pt-0 border-t flex flex-col gap-2" enctype="multipart/form-data">
                    <div class="flex gap-2">
                        <input type="text" id="quickReply" class="flex-1 rounded-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors text-gray-900 px-3 py-2" placeholder="Ketik pesan...">
                        <label for="chatFile" class="cursor-pointer flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-full w-10 h-10">
                            <i class="fas fa-paperclip text-gray-600"></i>
                        </label>
                        <input type="file" id="chatFile" name="file" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                        <button type="button" onclick="sendQuickReply()" class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <div id="filePreview" class="text-xs text-gray-600 mt-1 hidden"></div>
                </form>
                <div class="flex justify-end p-4 pt-0">
                    <button onclick="confirmEndChat()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center gap-2">
                        <i class="fas fa-times-circle"></i> Akhiri Chat
                    </button>
                </div>
            </div>
            <!-- Chat Button -->
            <button id="chatToggleBtn" onclick="openModal()" class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-2xl">
                <i id="chatIcon" class="fas fa-comments"></i>
            </button>
        </div>
    @else
        <div class="fixed bottom-6 right-6 z-50">
            <!-- Login Button -->
            <a href="{{ route('login') }}" class="flex items-center justify-center w-14 h-14 md:w-16 md:h-16 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </a>
        </div>
    @endauth

    <!-- Chat Form Modal -->
    <div id="messageModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Hubungi Admin
                            </h3>
                            <form id="messageForm" class="space-y-4">
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700">Subjek</label>
                                    <select name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white">
                                        <option value="" class="text-gray-500">Pilih Subjek</option>
                                        <option value="Permintaan Reset Password" class="text-gray-900">Permintaan Reset Password</option>
                                        <option value="Pengajuan Medpart" class="text-gray-900">Pengajuan Medpart</option>
                                        <option value="Pengajuan Mengikuti Event" class="text-gray-900">Pengajuan Mengikuti Event</option>
                                        <option value="Pengajuan Penambahan Divisi Game" class="text-gray-900">Pengajuan Penambahan Divisi Game</option>
                                        <option value="Lainnya" class="text-gray-900">Lainnya</option>
                                    </select>
                                </div>
                                <div id="otherSubjectDiv" class="hidden">
                                    <label for="otherSubject" class="block text-sm font-medium text-gray-700">Subjek Lainnya</label>
                                    <input type="text" name="otherSubject" id="otherSubject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white" placeholder="Masukkan subjek lainnya">
                                </div>
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Pesan</label>
                                    <textarea id="content" name="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white resize-none" placeholder="Tulis pesan Anda di sini..."></textarea>
                                </div>
                                @auth
                                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                @else
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white" required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white" required>
                                    </div>
                                @endauth
                            </form>
                            <div id="messageSuccess" class="hidden p-4 text-green-700 bg-green-100 rounded mb-4 text-center">
                                Pesan berhasil dikirim! Admin akan segera merespon pesan Anda.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="sendMessageBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Pesan
                    </button>
                    <button type="button" id="cancelMessageBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk dropdown subject
            const subjectSelect = document.getElementById('subject');
            const otherSubjectDiv = document.getElementById('otherSubjectDiv');
            
            if (subjectSelect) {
                subjectSelect.addEventListener('change', function() {
                    if (otherSubjectDiv) {
                        otherSubjectDiv.classList.toggle('hidden', this.value !== 'Lainnya');
                        if (this.value !== 'Lainnya') {
                            const otherSubject = document.getElementById('otherSubject');
                            if (otherSubject) {
                                otherSubject.value = '';
                            }
                        }
                    }
                });
            }

            // Event listener untuk tombol kirim
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            if (sendMessageBtn) {
                sendMessageBtn.addEventListener('click', function() {
                    const form = document.getElementById('messageForm');
                    if (!form) return;

                    const formData = new FormData(form);
                    const selectedSubject = formData.get('subject');
                    
                    // Validasi form
                    if (!selectedSubject) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Silakan pilih subjek pesan',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    // Jika subjek adalah "Lainnya", gunakan nilai dari input otherSubject
                    if (selectedSubject === 'Lainnya') {
                        const otherSubject = formData.get('otherSubject').trim();
                        if (!otherSubject) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Silakan masukkan subjek lainnya',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                        formData.set('subject', otherSubject);
                    }
                    
                    if (!formData.get('content').trim()) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Pesan tidak boleh kosong',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    // Tampilkan loading state
                    const btn = this;
                    const originalText = btn.textContent;
                    btn.disabled = true;
                    btn.textContent = 'Mengirim...';

                    // Kirim pesan
                    fetch('{{ route("admin.messages.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: formData.get('name'),
                            email: formData.get('email'),
                            subject: selectedSubject === 'Lainnya' ? formData.get('otherSubject') : selectedSubject,
                            content: formData.get('content')
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            closeModal();
                            setTimeout(() => {
                                openModal(); // Otomatis buka bubble chat setelah submit sukses
                            }, 500);
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: error.message || 'Terjadi kesalahan saat mengirim pesan',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.textContent = originalText;
                    });
                });
            }

            // Event listener tombol batal
            const cancelBtn = document.getElementById('cancelMessageBtn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    closeModal();
                });
            }
        });

        function openModal() {
            @auth
                // Tampilkan loading
                Swal.fire({
                    title: 'Memeriksa status chat...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Cek status chat
                fetch('{{ route("messages.check-active") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close();

                    if (!data.success) {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }

                    if (data.has_active_chat) {
                        showActiveChat(data.active_chat);
                    } else {
                        showNewChatModal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: error.message || 'Terjadi kesalahan saat memeriksa status chat. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            @else
                window.location.href = '{{ route("login") }}';
            @endauth
        }

        function showActiveChat(chatData) {
            const modal = document.getElementById('activeChatModal');
            const messagesContainer = document.getElementById('activeChatMessages');
            const subjectElement = document.getElementById('activeChatSubject');
            // Set subject
            subjectElement.textContent = chatData.subject;
            // Clear existing messages
            messagesContainer.innerHTML = '';
            // Add initial message
            const initialMessage = createChatMessage(chatData.content, chatData.created_at, true, false);
            messagesContainer.appendChild(initialMessage);
            // Add replies
            if (chatData.replies) {
                chatData.replies.forEach(reply => {
                    const messageElement = createChatMessage(
                        reply.content,
                        reply.created_at,
                        reply.is_admin,
                        true,
                        reply.user_name,
                        reply.file_url ? reply.file_url : null
                    );
                    messagesContainer.appendChild(messageElement);
                });
            }
            // Show modal
            modal.classList.remove('hidden');
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            // Store active chat ID (PASTIKAN SELALU DIISI)
            if (chatData.id) {
                modal.dataset.chatId = chatData.id;
            } else {
                modal.dataset.chatId = '';
            }
        }

        function createChatMessage(content, time, isAdmin, isReply = false, userName = '', fileUrl = null) {
            const div = document.createElement('div');
            div.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'} items-start space-x-2`;
            let fileLink = '';
            if (fileUrl) {
                fileLink = `<a href="${fileUrl}" target="_blank" class="block text-blue-600 underline mt-1">Download Lampiran</a>`;
            }
            const messageContent = `
                <div class="flex flex-col ${isAdmin ? 'items-end' : 'items-start'}">
                    ${userName ? `<span class="text-xs text-gray-500 mb-1">${userName}</span>` : ''}
                    <div class="${isAdmin ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-900'} rounded-lg px-4 py-2 max-w-sm">
                        <p class="text-sm">${content}</p>
                        ${fileLink}
                    </div>
                    <span class="text-xs text-gray-500 mt-1">${time}</span>
                </div>
            `;
            div.innerHTML = messageContent;
            return div;
        }

        function toggleChatWidget() {
            const modal = document.getElementById('activeChatModal');
            const btn = document.getElementById('chatToggleBtn');
            const icon = document.getElementById('chatIcon');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                icon.classList.remove('fa-comments');
                icon.classList.add('fa-times');
            } else {
                modal.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-comments');
            }
        }

        const chatFileInput = document.getElementById('chatFile');
        const filePreview = document.getElementById('filePreview');
        if (chatFileInput) {
            chatFileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    filePreview.textContent = 'File: ' + this.files[0].name;
                    filePreview.classList.remove('hidden');
                } else {
                    filePreview.textContent = '';
                    filePreview.classList.add('hidden');
                }
            });
        }

        function sendQuickReply() {
            const input = document.getElementById('quickReply');
            const modal = document.getElementById('activeChatModal');
            const chatId = modal.dataset.chatId;
            if (!chatId) {
                Swal.fire({
                    title: 'Error',
                    text: 'Chat tidak ditemukan. Silakan refresh halaman.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            const fileInput = document.getElementById('chatFile');
            const messagesContainer = document.getElementById('activeChatMessages');
            const form = document.getElementById('chatForm');
            const content = input.value.trim();
            if (!content && (!fileInput.files || !fileInput.files[0])) return;
            input.disabled = true;
            let formData = new FormData();
            formData.append('content', content);
            if (fileInput.files && fileInput.files[0]) {
                formData.append('file', fileInput.files[0]);
            }
            fetch(`{{ url('messages') }}/${chatId}/reply`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan pesan baru di chat
                    const messageElement = createChatMessage(
                        content,
                        new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                        false,
                        true,
                        @auth
                            '{{ auth()->user()->name }}',
                            data.file_url ? data.file_url : null
                        @else
                            'Guest',
                            data.file_url ? data.file_url : null
                        @endauth
                    );
                    messagesContainer.appendChild(messageElement);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    input.value = '';
                    fileInput.value = '';
                    filePreview.textContent = '';
                    filePreview.classList.add('hidden');
                } else {
                    throw new Error(data.message || 'Gagal mengirim pesan');
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Gagal mengirim pesan',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                input.disabled = false;
                input.focus();
            });
        }

        function confirmEndChat() {
            Swal.fire({
                title: 'Akhiri Chat?',
                text: 'Chat yang sudah diakhiri akan dipindahkan ke history',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Akhiri',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const chatId = document.getElementById('activeChatModal').dataset.chatId;
                    endChat(chatId);
                }
            });
        }

        function endChat(chatId) {
            fetch(`{{ url('messages') }}/${chatId}/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Chat telah diakhiri',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        closeActiveChatModal();
                    });
                } else {
                    throw new Error(data.message || 'Gagal mengakhiri chat');
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Gagal mengakhiri chat',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }

        function closeActiveChatModal() {
            const modal = document.getElementById('activeChatModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function showNewChatModal() {
            const modal = document.getElementById('messageModal');
            if (modal) {
                modal.classList.remove('hidden');
                const subject = document.getElementById('subject');
                if (subject) {
                    subject.focus();
                }
            }
        }

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Fungsi untuk menutup modal, reset form, dan sembunyikan pesan sukses
        function closeModal() {
            const modal = document.getElementById('messageModal');
            if (modal) {
                modal.classList.add('hidden');
                // Reset form dan pesan sukses jika perlu
                const form = document.getElementById('messageForm');
                const success = document.getElementById('messageSuccess');
                if (form) form.reset();
                if (form) form.classList.remove('hidden');
                if (success) success.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>