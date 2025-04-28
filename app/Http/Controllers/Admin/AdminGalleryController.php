<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::with('event')->latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::all();
        return view('admin.galleries.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'status' => 'required|in:draft,published'
        ]);

        $image = $request->file('image');
        $path = $image->store('public/galleries');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => str_replace('public/', '', $path),
            'event_id' => $request->event_id,
            'status' => $request->status,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $events = Event::all();
        return view('admin.galleries.edit', compact('gallery', 'events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'status' => 'required|in:draft,published'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'event_id' => $request->event_id,
            'status' => $request->status
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($gallery->image_path) {
                Storage::delete('public/' . $gallery->image_path);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $path = $image->store('public/galleries');
            $data['image_path'] = str_replace('public/', '', $path);
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) {
            Storage::delete('public/' . $gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus');
    }
}
