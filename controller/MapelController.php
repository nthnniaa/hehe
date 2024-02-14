<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Mengajar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mapel.index', [
            'mapel' => Mapel::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data_mapel = $request->validate([
            'nama_mapel' => ['required', 'unique:mapels']
        ]);
        Mapel::create($data_mapel);
        return redirect('/mapel/index')->with('success', 'Data Mapel Berhasil Di Tambah!');

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
    public function edit(Mapel $mapel)
    {
        return view('mapel.edit', [
            'mapel' => $mapel
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $data_mapel = $request->validate([
            'nama_mapel' => ['required', Rule::unique('mapels')->ignore($mapel->id)],
        ]);
        $mapel->update($data_mapel);
        return redirect('/mapel/index')->with('success', 'Data mapel Berhasil Di Ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        $mengajar = Mengajar::where('mapel_id', $mapel->id)->first();

        if ($mengajar){
            return back()->with('error', "$mapel->nama_mapel masih digunakan di menu mengajar");
        }

        $mapel->delete();
        return back()->with('success', 'Data Mapel Berhasil di Hapus');
    }
}
