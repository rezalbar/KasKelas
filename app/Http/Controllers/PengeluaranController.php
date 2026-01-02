<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;

class PengeluaranController extends Controller
{
    public function index()
    {
        // Ambil data pengeluaran terbaru
        $pengeluaran = Pengeluaran::latest()->get();
        
        // PERBAIKAN UTAMA DISINI:
        // Kita panggil 'pengeluaran' karena nama file kamu pengeluaran.blade.php
        return view('pengeluaran', compact('pengeluaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        Pengeluaran::create([
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    // Fungsi Hapus (Destroy)
    public function destroy($id)
    {
        $data = Pengeluaran::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}