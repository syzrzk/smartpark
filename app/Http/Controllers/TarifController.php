<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('tarif.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:50|unique:tarifs,jenis_kendaraan',
            'tarif_awal' => 'required|numeric|min:0',
            'jam_awal' => 'required|numeric|min:1',
            'harga_per_jam' => 'required|numeric|min:0',
        ]);

        Tarif::create($request->all());

        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        return view('tarif.form', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:50|unique:tarifs,jenis_kendaraan,'.$tarif->id,
            'tarif_awal' => 'required|numeric|min:0',
            'jam_awal' => 'required|numeric|min:1',
            'harga_per_jam' => 'required|numeric|min:0',
        ]);

        $tarif->update($request->all());

        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif)
    {
        Tarif::destroy($tarif->id);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
