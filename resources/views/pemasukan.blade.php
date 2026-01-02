<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan - Kas Kelas</title>
    <!-- FIX: Pastikan gambar wallet.png ada di public/images -->
    <link rel="shortcut icon" href="{{ asset('images/wallet.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #e3e6f0; font-family: 'Inter', sans-serif; }
        .navbar { background-color: #ffffff !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .nav-link { color: #5a5c69 !important; font-weight: 600; }
        .nav-link.active { color: #4e73df !important; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .card-header { background-color: #fff; border-bottom: 1px solid #e3e6f0; padding: 1.5rem; border-top-left-radius: 15px !important; border-top-right-radius: 15px !important; font-weight: bold; }
        .text-success-theme { color: #1cc88a; }
        .btn-success-theme { background-color: #1cc88a; border: none; color: white; border-radius: 10px; padding: 10px; font-weight: 600; }
        .btn-success-theme:hover { background-color: #17a673; color: white; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #d1d3e2; }
        .table th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: #b7b9cc; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/dashboard">
                <i class="fas fa-wallet me-2"></i>KAS KELAS
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-start align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                    
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link" href="/siswa">Data Siswa</a></li>
                        <li class="nav-item"><a class="nav-link active text-success-theme" href="/pemasukan">Pemasukan</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pengeluaran">Pengeluaran</a></li>
                    @endif

                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 w-100 w-lg-auto">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm px-4 rounded-pill w-100">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <div class="row g-4">
            <!-- Form Input Tunai (Hanya Admin yang lihat) -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header text-success-theme">
                        <i class="fas fa-plus-circle me-2"></i>Catat Tunai (F2F)
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-3 small">
                                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif
                        <form action="/pemasukan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Nama Siswa</label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Jumlah Uang (Rp)</label>
                                <input type="number" name="jumlah" class="form-control" placeholder="5000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Tanggal Bayar</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Minggu ke-1"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success-theme w-100 mt-2">Simpan Pemasukan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Lengkap -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header text-success-theme">
                        <i class="fas fa-history me-2"></i>Daftar Pemasukan & Verifikasi
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Tanggal</th>
                                        <th class="py-3">Nama Siswa</th>
                                        <th class="py-3">Jumlah</th>
                                        <th class="py-3">Bukti</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pemasukan as $p)
                                    <!-- Logika Warna: Kalau Pending jadi Kuning -->
                                    <tr class="{{ $p->status == 'pending' ? 'table-warning' : '' }}">
                                        <td class="ps-4 text-muted small">{{ $p->tanggal }}</td>
                                        <td class="fw-bold text-dark">{{ $p->user->nama_lengkap }}</td>
                                        <td class="text-success fw-bold">+ Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                        
                                        <!-- Kolom Bukti -->
                                        <td>
                                            @if($p->foto_bukti)
                                                <a href="{{ asset('bukti_transfer/'.$p->foto_bukti) }}" target="_blank" class="badge bg-info text-decoration-none">
                                                    <i class="fas fa-image me-1"></i>Lihat Foto
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        <!-- Kolom Status -->
                                        <td>
                                            @if($p->status == 'lunas')
                                                <span class="badge bg-success rounded-pill">Lunas</span>
                                            @else
                                                <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                            @endif
                                        </td>

                                        <!-- Kolom Aksi -->
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Tombol ACC (Hanya muncul kalau Pending) -->
                                                @if($p->status == 'pending')
                                                    <form action="/pemasukan/{{ $p->id }}/approve" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success rounded-circle" title="Terima Pembayaran">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Tombol Hapus -->
                                                <form action="/pemasukan/{{ $p->id }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>