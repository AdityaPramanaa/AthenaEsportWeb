<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'type' => ['required', 'in:news,announcement'],
            'status' => ['required', 'in:draft,published'],
        ]);

        try {
            \Log::info('Mencoba menyimpan berita baru');
            
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('news', 'public');
                \Log::info('Image berhasil diupload:', ['path' => $imagePath]);
            }

            $news = News::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imagePath,
                'type' => $request->type,
                'status' => $request->status,
                'created_by' => auth()->id(),
            ]);

            \Log::info('Berita berhasil disimpan:', ['news' => $news->toArray()]);

            return redirect()->route('news.index')
                ->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan berita:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan berita.');
        }
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'type' => ['required', 'in:news,announcement'],
            'status' => ['required', 'in:draft,published'],
        ]);

        try {
            \Log::info('Mencoba mengupdate berita:', ['id' => $news->id]);

            if ($request->hasFile('image')) {
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }
                $imagePath = $request->file('image')->store('news', 'public');
                $news->image = $imagePath;
                \Log::info('Image baru berhasil diupload:', ['path' => $imagePath]);
            }

            $news->update([
                'title' => $request->title,
                'content' => $request->content,
                'type' => $request->type,
                'status' => $request->status,
            ]);

            \Log::info('Berita berhasil diupdate:', ['news' => $news->toArray()]);

            return redirect()->route('news.index')
                ->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error saat mengupdate berita:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat mengupdate berita.');
        }
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News deleted successfully.');
    }
} 