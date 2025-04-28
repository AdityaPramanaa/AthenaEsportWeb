<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        try {
            \Log::info('Memulai pengambilan data untuk halaman events');
            \Log::info('Request parameters:', $request->all());
            
            $query = Event::query();

            // Hanya tampilkan event yang published
            $query->where('status', 'published');

            // Filter berdasarkan kategori
            if ($request->filled('category')) {
                $query->where('category', $request->category);
                \Log::info('Filtering by category: ' . $request->category);
            }

            // Filter berdasarkan tipe
            if ($request->filled('type')) {
                $query->where('type', $request->type);
                \Log::info('Filtering by type: ' . $request->type);
            }

            // Urutkan berdasarkan tanggal event
            $query->orderBy('event_date', 'asc')
                  ->orderBy('event_time', 'asc');

            // Get SQL query for debugging
            \Log::info('SQL Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $events = $query->paginate(9)->withQueryString();

            \Log::info('Events yang akan ditampilkan: ' . $events->count());

            return view('events.index', compact('events'));
        } catch (\Exception $e) {
            \Log::error('Error pada halaman events: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data event');
        }
    }

    public function show(Event $event)
    {
        $event->load(['creator', 'participants', 'galleries']);

        // Mengambil related events berdasarkan kategori yang sama
        // dan memastikan tidak mengambil event yang sedang ditampilkan
        $relatedEvents = Event::where('category', $event->category)
            ->where('id', '!=', $event->id)
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'poster' => ['required', 'image', 'max:2048'],
            'registration_link' => ['nullable', 'url'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required'],
            'location' => ['required', 'string', 'max:255'],
        ]);

        $posterPath = $request->file('poster')->store('events/posters', 'public');

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'poster_path' => $posterPath,
            'registration_link' => $request->registration_link,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.events.edit', $event)
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'registration_link' => ['nullable', 'url'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,completed'],
        ]);

        if ($request->hasFile('poster')) {
            Storage::disk('public')->delete($event->poster_path);
            $posterPath = $request->file('poster')->store('events/posters', 'public');
            $event->poster_path = $posterPath;
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'registration_link' => $request->registration_link,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.events.edit', $event)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        Storage::disk('public')->delete($event->poster_path);
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function participate(Request $request, Event $event)
    {
        $request->validate([
            'notes' => ['nullable', 'string'],
        ]);

        EventParticipant::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('events.show', $event)
            ->with('success', 'Participation request submitted successfully.');
    }

    public function myEvents()
    {
        $participations = EventParticipant::with('event')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('events.my', compact('participations'));
    }

    public function approveParticipants(Request $request, Event $event)
    {
        $request->validate([
            'participant_ids' => ['required', 'array'],
            'participant_ids.*' => ['exists:event_participants,id'],
            'status' => ['required', 'in:approved,rejected'],
        ]);

        EventParticipant::whereIn('id', $request->participant_ids)
            ->where('event_id', $event->id)
            ->update(['status' => $request->status]);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Participants status updated successfully.');
    }
} 