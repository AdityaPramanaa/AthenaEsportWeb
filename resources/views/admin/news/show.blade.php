@extends('layouts.admin')

@section('title', 'Detail Berita')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Detail Berita</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.news.edit', $news->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $news->title }}</h2>
                        
                        @if($news->image_path)
                            <div class="mb-6">
                                <img src="{{ Storage::url($news->image_path) }}" 
                                     alt="{{ $news->title }}" 
                                     class="w-full h-auto rounded-lg shadow-sm">
                            </div>
                        @endif

                        <div class="prose max-w-none">
                            {!! $news->content !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Berita</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tipe Berita</p>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($news->type == 'news')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Berita
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pengumuman
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($news->status == 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Draft
                                        </span>
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