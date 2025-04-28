@extends('layouts.admin-tailwind')

@section('title', 'Kelola Event')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Events</h1>
        <a href="{{ route('admin.events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> Tambah Event</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Nama Event</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Lokasi</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Status</th>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-900 uppercase">Total View</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                <tr>
                    <td class="px-4 py-2">
                        <div class="flex items-center gap-2">
                            @if($event->poster_path)
                                <img src="{{ Storage::url($event->poster_path) }}" alt="{{ $event->title }}" class="w-12 h-12 object-cover rounded shadow">
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900">{{ $event->title }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2">
                        <div class="text-black font-semibold">{{ optional($event->event_date)->format('d M Y') ?? 'Belum ditentukan' }}</div>
                        <div class="text-xs text-gray-400">Selesai: {{ optional($event->event_time)->format('H:i') ?? 'Belum ditentukan' }}</div>
                    </td>
                    <td class="px-4 py-2 text-black">{{ $event->location }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $event->status == 'published' ? 'bg-green-100 text-green-600' : ($event->status == 'completed' ? 'bg-gray-200 text-gray-600' : 'bg-yellow-100 text-yellow-600') }}">{{ ucfirst($event->status) }}</span>
                    </td>
                    <td class="px-4 py-2 text-center text-black">{{ $event->views_count ?? 0 }}</td>
                    <td class="px-4 py-2 flex flex-wrap gap-2">
                        <a href="{{ route('admin.events.show', $event->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 flex items-center gap-1"><i class="fas fa-eye"></i> View</a>
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 flex items-center gap-1"><i class="fas fa-edit"></i> Edit</a>
                        <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 flex items-center gap-1"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-4">Tidak ada event</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $events->links() }}</div>
    </div>
</div>
@endsection 