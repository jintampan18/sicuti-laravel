<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::all();

        return view('pages.staff_admin.manage_jabatan.index', compact('jabatan'));
    }

    public function create()
    {
        return view('pages.staff_admin.manage_jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_jabatan' => 'required|string|max:255',
        ]);

        Jabatan::create([
            'name_jabatan' => $request->name_jabatan,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('pages.staff_admin.manage_jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_jabatan' => 'required|string|max:255',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update([
            'name_jabatan' => $request->name_jabatan,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
