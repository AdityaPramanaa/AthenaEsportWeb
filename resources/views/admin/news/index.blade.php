@extends('layouts.admin-tailwind')

@section('title', 'Kelola Berita')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Berita</h1>
        <a href="{{ route('admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> Tambah Berita</a>
    </div>
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">No</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Thumbnail</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Judul</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Kategori</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-900 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($news as $item)
                <tr>
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-20 h-12 object-cover rounded shadow">
                        @else
                            <span class="text-gray-400">No image</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-gray-900">{{ $item->title }}</td>
                    <td class="px-4 py-2 text-gray-900">{{ ucfirst($item->type) }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $item->status == 'published' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">{{ ucfirst($item->status) }}</span>
                    </td>
                    <td class="px-4 py-2 text-gray-900">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-2 flex flex-wrap gap-2">
                        <a href="{{ route('admin.news.show', $item->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600 flex items-center gap-1"><i class="fas fa-eye"></i> Detail</a>
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 flex items-center gap-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 flex items-center gap-1"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-400 py-4">Tidak ada data berita</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $news->links() }}</div>
    </div>
</div>
@endsection 