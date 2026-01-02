<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\User;

class PemasukanController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')->get();
        // Urutkan status: Pending dulu, baru Lunas
        $pemasukan = Pemasukan::with('user')
                    ->orderByRaw("FIELD(status, 'pending', 'lunas')")
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('pemasukan', compact('siswa', 'pemasukan'));
    }

    // Input Tunai oleh Admin
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        // JURUS PAKSA: Pakai new object biar status 'lunas' pasti masuk
        $pemasukan = new Pemasukan();
        $pemasukan->user_id = $request->user_id;
        $pemasukan->jumlah = $request->jumlah;
        $pemasukan->tanggal = $request->tanggal;
        $pemasukan->keterangan = $request->keterangan;
        $pemasukan->status = 'lunas'; // Admin = Langsung Lunas
        $pemasukan->save();

        return back()->with('success', 'Pemasukan tunai berhasil dicatat!');
    }

    // Input Transfer oleh Siswa
    public function storeTransfer(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('foto_bukti');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti_transfer'), $namaFile);

        // JURUS PAKSA: Pakai new object biar status 'pending' PASTI masuk
        $pemasukan = new Pemasukan();
        $pemasukan->user_id = auth()->id(); // Pakai ID siswa yg login
        $pemasukan->jumlah = $request->jumlah;
        $pemasukan->tanggal = $request->tanggal;
        $pemasukan->keterangan = 'Transfer Bank';
        $pemasukan->foto_bukti = $namaFile;
        $pemasukan->status = 'pending'; // <--- KITA PAKSA JADI PENDING
        $pemasukan->save();

        return back()->with('success', 'Bukti transfer terkirim! Menunggu verifikasi Admin.');
    }

    // ACC Pembayaran
    public function approve($id)
    {
        $data = Pemasukan::findOrFail($id);
        
        // Update manual biar aman
        $data->status = 'lunas'; 
        $data->save();
        
        return back()->with('success', 'Pembayaran berhasil diverifikasi (Lunas)!');
    }

    public function destroy($id)
    {
        $data = Pemasukan::findOrFail($id);
        if ($data->foto_bukti && file_exists(public_path('bukti_transfer/' . $data->foto_bukti))) {
            unlink(public_path('bukti_transfer/' . $data->foto_bukti));
        }
        $data->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}