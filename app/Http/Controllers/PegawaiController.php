<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('user', 'jabatan')->get();

        return view('pages.staff_admin.manage_pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();

        return view('pages.staff_admin.manage_pegawai.create', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'nip' => 'required|string|unique:pegawai,nip|max:255',
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'tahun_masuk' => 'required|date',
            'status_pegawai' => 'required|in:aktif,nonaktif',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt('password'),
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'jabatan_id' => $request->jabatan_id,
            'alamat' => $request->alamat,
            'tahun_masuk' => $request->tahun_masuk,
            'status_pegawai' => $request->status_pegawai,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pegawai = Pegawai::with('user', 'jabatan')->findOrFail($id);

        return view('pages.staff_admin.manage_pegawai.detail', compact('pegawai'));
    }


    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatan = Jabatan::all();

        return view('pages.staff_admin.manage_pegawai.edit', compact('pegawai', 'jabatan')); // Pass data to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'nip' => 'required|numeric',
            'jabatan_id' => 'required|exists:jabatan,id',
            'alamat' => 'required|string',
            'tahun_masuk' => 'required|date',
            'sisa_cuti' => 'required',
            'status_pegawai' => 'required|in:aktif,nonaktif',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->nip = $request->nip;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->alamat = $request->alamat;
        $pegawai->tahun_masuk = $request->tahun_masuk;
        $pegawai->sisa_cuti = $request->sisa_cuti;
        $pegawai->status_pegawai = $request->status_pegawai;
        $pegawai->save();

        $user = $pegawai->user;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->save();

        return redirect()->route('pegawai.index', $pegawai->id)->with('success', 'Data Pegawai berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        if ($pegawai->user) {
            $pegawai->user->delete();
        }
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil dihapus!');
    }

    public function resetPassword($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = $pegawai->user;
        $user->password = bcrypt('password');
        $user->save();

        return redirect()->route('pegawai.index', $pegawai->id)->with('success', 'Password pegawai berhasil direset!');
    }
}
