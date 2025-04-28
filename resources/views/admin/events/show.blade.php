@extends('layouts.admin-tailwind')

@section('title', 'Detail Event')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Detail Event</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.events.edit', $event) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Event
                </a>
                <a href="{{ route('admin.events.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow mb-6">
                    <div class="p-6">
                        @if($event->poster_path)
                            <img src="{{ Storage::url($event->poster_path) }}" alt="{{ $event->title }}" class="w-full max-h-72 object-cover rounded mb-6 shadow">
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Judul Event</label>
                                <p class="mt-1 text-gray-900 font-semibold">{{ $event->title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                                <p class="mt-1 text-gray-900">{{ $event->location }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal</label>
                                <p class="mt-1 text-gray-900">{{ $event->event_date->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Waktu</label>
                                <p class="mt-1 text-gray-900">{{ $event->event_time->format('H:i') }} WITA</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Kategori</label>
                                <p class="mt-1 text-gray-900">{{ ucfirst($event->category) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tipe</label>
                                <p class="mt-1 text-gray-900">{{ ucfirst($event->type) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $event->status == 'published' ? 'bg-green-100 text-green-600' : ($event->status == 'completed' ? 'bg-gray-200 text-gray-600' : 'bg-yellow-100 text-yellow-600') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Link Pendaftaran</label>
                                @if($event->registration_link)
                                    <a href="{{ $event->registration_link }}" target="_blank" class="text-blue-600 underline break-all">{{ $event->registration_link }}</a>
                                @else
                                    <p class="text-gray-400 italic">Tidak ada link pendaftaran</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="mt-1 text-gray-900 text-justify">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="bg-white rounded-xl shadow mb-6">
                    <div class="p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-500">Dibuat Oleh</label>
                            <p class="mt-1 text-gray-900">{{ $event->creator->name ?? 'Unknown' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                            <p class="mt-1 text-gray-900">{{ $event->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                            <p class="mt-1 text-gray-900">{{ $event->updated_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-500">Jumlah Peserta</label>
                            <p class="mt-1 text-gray-900">{{ $event->participants->count() }} Peserta</p>
                        </div>
                    </div>
                </div>
                @if($event->participants->count() > 0)
                <div class="bg-white rounded-xl shadow">
                    <div class="p-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Daftar Peserta</label>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Nama</th>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($event->participants as $participant)
                                    <tr>
                                        <td class="px-4 py-2">{{ $participant->user->name }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $participant->status == 'approved' ? 'bg-green-100 text-green-600' : ($participant->status == 'rejected' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                                                {{ ucfirst($participant->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Increment view counter saat halaman detail dimuat
        const eventId = '{{ $event->id }}';
        fetch(`/admin/events/${eventId}/increment-views`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Views updated successfully:', data.views);
            } else {
                console.error('Failed to update views:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
@endpush
@endsection 