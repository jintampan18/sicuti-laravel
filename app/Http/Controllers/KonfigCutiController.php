<?php

namespace App\Http\Controllers;

use App\Models\KonfigCuti;
use Illuminate\Http\Request;

class KonfigCutiController extends Controller
{
    public function index()
    {
        $konfigCuti = KonfigCuti::orderBy('tahun', 'asc')->get();

        return view('pages.staff_admin.manage_konfig_cuti.index', compact('konfigCuti'));
    }

    public function create()
    {
        return view('pages.staff_admin.manage_konfig_cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|unique:konfig_cuti,tahun',
            'jumlah_cuti' => 'required|integer|min:1',
        ], [
            'tahun.unique' => 'Tahun ini sudah ada dalam konfigurasi cuti!',
            'tahun.required' => 'Tahun harus diisi.',
            'jumlah_cuti.required' => 'Jumlah cuti harus diisi.',
        ]);

        KonfigCuti::create($request->all());

        return redirect()->route('konfig_cuti.index')->with('success', 'Konfig Cuti berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $konfigCuti = KonfigCuti::findOrFail($id);

        return view('pages.staff_admin.manage_konfig_cuti.edit', compact('konfigCuti'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|integer|unique:konfig_cuti,tahun,' . $id,
            'jumlah_cuti' => 'required|integer|min:1',
        ],  [
            'tahun.unique' => 'Tahun ini sudah ada dalam konfigurasi cuti!',
            'tahun.required' => 'Tahun harus diisi.',
            'jumlah_cuti.min' => 'Jumlah cuti minimal 1.',
        ]);

        $konfigCuti = KonfigCuti::findOrFail($id);
        $konfigCuti->update($request->all());

        return redirect()->route('konfig_cuti.index')->with('success', 'Konfig Cuti berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $konfigCuti = KonfigCuti::findOrFail($id);
        $konfigCuti->delete();

        return redirect()->route('konfig_cuti.index')->with('success', 'Konfig Cuti berhasil dihapus!');
    }
}
