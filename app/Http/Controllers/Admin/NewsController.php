<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('user')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string|in:news,announcement',
            'status' => 'required|string|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $news = new News();
            $news->title = $validated['title'];
            $news->content = $validated['content'];
            $news->type = $validated['type'];
            $news->status = $validated['status'];
            $news->created_by = Auth::id();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('news', 'public');
                $news->image = $imagePath;
            }

            $news->save();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Berita berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan berita. ' . $e->getMessage());
        }
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string|in:news,announcement',
            'status' => 'required|string|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $news = News::findOrFail($id);
            $news->title = $validated['title'];
            $news->content = $validated['content'];
            $news->type = $validated['type'];
            $news->status = $validated['status'];

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }
                
                $image = $request->file('image');
                $imagePath = $image->store('news', 'public');
                $news->image = $imagePath;
            }

            $news->save();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Berita berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berita. ' . $e->getMessage());
        }
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News berhasil dihapus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::with('user')->findOrFail($id);
        return view('admin.news.show', compact('news'));
    }
} 