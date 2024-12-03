<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    public function index()
    {
        $jenisCuti = JenisCuti::all();

        return view('pages.staff_admin.manage_jenis_cuti.index', compact('jenisCuti'));
    }

    public function create()
    {
        return view('pages.staff_admin.manage_jenis_cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_jenis_cuti' => 'required|string|max:255',
        ]);

        JenisCuti::create([
            'name_jenis_cuti' => $request->name_jenis_cuti,
        ]);

        return redirect()->route('jenis_cuti.index')->with('success', 'Jenis Cuti berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenisCuti = JenisCuti::findOrFail($id);

        return view('pages.staff_admin.manage_jenis_cuti.edit', compact('jenisCuti'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_jenis_cuti' => 'required|string|max:255',
        ]);

        $jenisCuti = JenisCuti::findOrFail($id);
        $jenisCuti->update([
            'name_jenis_cuti' => $request->name_jenis_cuti,
        ]);

        return redirect()->route('jenis_cuti.index')->with('success', 'Jenis Cuti berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jenisCuti = JenisCuti::findOrFail($id);
        $jenisCuti->delete();

        return redirect()->route('jenis_cuti.index')->with('success', 'Jenis Cuti berhasil dihapus!');
    }
}
