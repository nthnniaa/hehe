<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('siswa.index', [
            'siswa' => Siswa::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.create', [
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data_siswa = $request->validate([
            'nis' => ['required', 'numeric', 'unique:siswas'],
            'nama_siswa' => ['required'],
            'jk' => ['required'],
            'alamat' => ['required'],
            'kelas_id' => ['required'],
            'password' => ['required']
        ]);
        Siswa::create($data_siswa);
        return redirect('/siswa/index')->with('success', 'Data Siswa Berhasil Di Tambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', [
            'siswa' => $siswa,
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $data_siswa = $request->validate([
            'nis' => ['required', 'numeric', Rule::unique('siswas')->ignore($siswa->id)],
            'nama_siswa' => ['required'],
            'jk' => ['required'],
            'alamat' => ['required'],
            'kelas_id' => ['required'],
            'password' => ['required']
        ]);
        $siswa->update($data_siswa);
        return redirect('/siswa/index')->with('success', 'Data Siswa Berhasil Di Ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $nilai = Nilai::where('siswa_id', $siswa->id)->first();

        if ($nilai){
            return back()->with('error', "$siswa->nama_siswa masih digunakan di menu nilai");
        }

        $siswa->delete();
        return back()->with('success', 'Data Siswa Berhasil di Hapus');

    }
}
