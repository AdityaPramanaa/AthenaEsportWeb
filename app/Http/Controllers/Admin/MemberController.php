<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan anggota baru
        $request->validate([
            'name' => 'required',
            'ktm_photo' => 'required|image',
        ]);

        $path = $request->file('ktm_photo')->store('ktm_photos', 'public');

        Member::create([
            'name' => $request->name,
            'ktm_photo' => $path,
        ]);

        return redirect()->route('admin.members.index');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        // Validasi dan update anggota
        $request->validate([
            'name' => 'required',
            'ktm_photo' => 'image',
        ]);

        if ($request->hasFile('ktm_photo')) {
            $path = $request->file('ktm_photo')->store('ktm_photos', 'public');
            $member->ktm_photo = $path;
        }

        $member->name = $request->name;
        $member->save();

        return redirect()->route('admin.members.index');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index');
    }
} 