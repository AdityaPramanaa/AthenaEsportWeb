@extends('layouts.admin-tailwind')

@section('title', 'Detail Berita')

@section('content')
<div class="px-2 md:px-6 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Detail Berita</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.news.edit', $news->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.news.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $news->title }}</h2>
                        @if($news->image_path)
                            <div class="mb-6">
                                <img src="{{ Storage::url($news->image_path) }}" alt="{{ $news->title }}" class="w-full h-auto rounded-lg shadow">
                            </div>
                        @endif
                        <div class="prose max-w-none text-black">
                            {!! $news->content !!}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Berita</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tipe Berita</p>
                                <p class="mt-1 text-sm">
                                    @if($news->type == 'news')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-600">Berita</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">Pengumuman</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="mt-1 text-sm">
                                    @if($news->status == 'published')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">Published</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Draft</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Dibuat Oleh</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $news->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tanggal Dibuat</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $news->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Terakhir Diperbarui</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $news->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 