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
        // Urutkan biar yang butuh tindakan (Pending) ada di paling atas
        $pemasukan = Pemasukan::with('user')
                    ->orderByRaw("FIELD(status, 'pending', 'lunas')")
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('pemasukan', compact('siswa', 'pemasukan'));
    }

    // 1. INPUT TUNAI (ADMIN) -> PASTI LUNAS
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        // Ganti create() dengan new Pemasukan() biar lebih aman
        $pemasukan = new Pemasukan();
        $pemasukan->user_id = $request->user_id;
        $pemasukan->jumlah = $request->jumlah;
        $pemasukan->tanggal = $request->tanggal;
        $pemasukan->keterangan = $request->keterangan;
        $pemasukan->status = 'lunas'; // <--- ADMIN PASTI LUNAS
        $pemasukan->save();

        return back()->with('success', 'Pemasukan tunai berhasil dicatat!');
    }

    // 2. INPUT TRANSFER (SISWA) -> PASTI PENDING
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

        // Ganti create() dengan new Pemasukan() biar status pending PASTI masuk
        $pemasukan = new Pemasukan();
        $pemasukan->user_id = auth()->id();
        $pemasukan->jumlah = $request->jumlah;
        $pemasukan->tanggal = $request->tanggal;
        $pemasukan->keterangan = 'Transfer Bank';
        $pemasukan->foto_bukti = $namaFile;
        $pemasukan->status = 'pending'; // <--- SISWA PASTI PENDING
        $pemasukan->save();

        return back()->with('success', 'Bukti transfer terkirim! Menunggu verifikasi Admin.');
    }

    // 3. FITUR ACC (UBAH JADI LUNAS)
    public function approve($id)
    {
        $data = Pemasukan::findOrFail($id);
        $data->status = 'lunas'; // <--- SAHKAN JADI LUNAS
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