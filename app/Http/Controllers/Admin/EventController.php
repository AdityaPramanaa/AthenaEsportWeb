<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required|string|max:255',
            'category' => 'required|in:kampus,luar kampus',
            'type' => 'required|in:tournament,gathering,workshop',
            'registration_link' => 'nullable|url',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,completed'
        ]);

        try {
            \Log::info('Mencoba menyimpan event baru');
            
            // Upload dan simpan poster
            $posterPath = $request->file('poster')->store('events/posters', 'public');
            \Log::info('Poster berhasil diupload', ['path' => $posterPath]);

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'event_time' => $request->event_time,
                'location' => $request->location,
                'category' => $request->category,
                'type' => $request->type,
                'registration_link' => $request->registration_link,
                'poster_path' => $posterPath,
                'status' => $request->status,
                'created_by' => auth()->id(),
                'views_count' => 0
            ]);

            \Log::info('Event berhasil disimpan', ['event_id' => $event->id]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan event: ' . $e->getMessage());
            
            // Hapus file yang sudah terupload jika ada error
            if (isset($posterPath)) {
                Storage::disk('public')->delete($posterPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required|string|max:255',
            'category' => 'required|in:kampus,luar kampus',
            'type' => 'required|in:tournament,gathering,workshop',
            'registration_link' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,completed'
        ]);

        try {
            \Log::info('Mencoba memperbarui event', ['event_id' => $event->id]);
            
            $data = $request->except('poster');

            if ($request->hasFile('poster')) {
                \Log::info('Mengunggah poster baru');
                
                // Hapus poster lama
                if ($event->poster_path) {
                    Storage::disk('public')->delete($event->poster_path);
                }
                
                // Upload poster baru
                $posterPath = $request->file('poster')->store('events/posters', 'public');
                $data['poster_path'] = $posterPath;
                
                \Log::info('Poster baru berhasil diunggah', ['path' => $posterPath]);
            }

            $event->update($data);
            \Log::info('Event berhasil diperbarui');

            return redirect()->route('admin.events.index')
                ->with('success', 'Event berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui event: ' . $e->getMessage());
            
            // Hapus file yang sudah terupload jika ada error
            if (isset($posterPath)) {
                Storage::disk('public')->delete($posterPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Event $event)
    {
        try {
            // Hapus gambar jika ada
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }

            $event->delete();

            return redirect()->route('admin.events.index')
                ->with('success', 'Event berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function incrementViews(Event $event)
    {
        try {
            \Log::info('Incrementing views for event: ' . $event->id);
            $event->increment('views_count');
            \Log::info('New view count: ' . $event->views_count);
            return response()->json(['success' => true, 'views' => $event->views_count]);
        } catch (\Exception $e) {
            \Log::error('Error incrementing views: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Event $event)
    {
        try {
            return view('admin.events.show', compact('event'));
        } catch (\Exception $e) {
            return redirect()->route('admin.events.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 