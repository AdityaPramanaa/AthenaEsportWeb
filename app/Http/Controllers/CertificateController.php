<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['event', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate)
    {
        $this->authorize('view', $certificate);
        return view('certificates.show', compact('certificate'));
    }

    public function create()
    {
        $events = Event::where('status', 'completed')->get();
        $users = User::where('role', 'anggota')->get();
        return view('certificates.create', compact('events', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'event_id' => ['required', 'exists:events,id'],
            'certificate' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $certificatePath = $request->file('certificate')->store('certificates', 'public');
        $certificateNumber = 'CERT-' . strtoupper(Str::random(10));

        Certificate::create([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'certificate_number' => $certificateNumber,
            'certificate_path' => $certificatePath,
            'issue_date' => now(),
        ]);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate created successfully.');
    }

    public function edit(Certificate $certificate)
    {
        $events = Event::where('status', 'completed')->get();
        $users = User::where('role', 'anggota')->get();
        return view('certificates.edit', compact('certificate', 'events', 'users'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'event_id' => ['required', 'exists:events,id'],
            'certificate' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'issue_date' => ['required', 'date'],
        ]);

        if ($request->hasFile('certificate')) {
            Storage::disk('public')->delete($certificate->certificate_path);
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
            $certificate->certificate_path = $certificatePath;
        }

        $certificate->update([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'issue_date' => $request->issue_date,
        ]);

        return redirect()->route('admin.certificates.edit', $certificate)
            ->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        Storage::disk('public')->delete($certificate->certificate_path);
        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }
} 