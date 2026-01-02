<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Kas Kelas</title>
    <link rel="shortcut icon" href="{{ asset('images/wallet.jpeg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #e3e6f0; font-family: 'Inter', sans-serif; }
        .navbar { background-color: #ffffff !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .nav-link { color: #5a5c69 !important; font-weight: 600; }
        .nav-link.active { color: #4e73df !important; }
        .table th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: #b7b9cc; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/dashboard">
                <i class="fas fa-wallet me-2"></i>KAS KELAS
            </a>

            <!-- Tombol Hamburger -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <!-- PERUBAHAN ADA DI SINI: pakai 'align-items-lg-center' (bukan align-items-center biasa) -->
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('siswa') ? 'active' : '' }}" href="/siswa">Data Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pemasukan') ? 'active' : '' }}" href="/pemasukan">Pemasukan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pengeluaran') ? 'active' : '' }}" href="/pengeluaran">Pengeluaran</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <form action="/logout" method="POST" class="d-inline">
                            @csrf
                            <!-- Tombol Logout Full Width di HP, Kecil di Laptop -->
                            <button type="submit" class="btn btn-outline-danger btn-sm px-4 rounded-pill w-100">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <div class="me-3 bg-white p-2 rounded-circle text-info">
                <i class="fas fa-info-circle fa-lg"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0">Info Kesepakatan Kas</h6>
                <small>Wajib bayar <strong>Rp 5.000</strong> setiap Jumat. Target minggu ini: <strong>Rp {{ number_format($wajibBayar, 0, ',', '.') }}</strong></small>
            </div>
        </div>

        <div class="card h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-users me-2"></i>Status Keuangan Siswa</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">No</th>
                                <th class="py-3">Nama Siswa</th>
                                <th class="py-3">Total Bayar</th>
                                <th class="py-3">Info Tagihan</th>
                                <th class="py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataSiswa as $key => $s)
                            @php
                                $selisih = $s->pemasukan_sum_jumlah - $wajibBayar;
                            @endphp
                            <tr>
                                <td class="ps-4 text-secondary">{{ $key + 1 }}</td>
                                
                                <td>
                                    <div class="fw-bold text-dark">{{ $s->nama_lengkap }}</div>
                                    <div class="small text-muted">
                                        <i class="fas fa-user-circle me-1"></i>{{ $s->username }}
                                    </div>
                                </td>
                                
                                <td class="fw-bold text-primary">
                                    Rp {{ number_format($s->pemasukan_sum_jumlah, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if($selisih < 0)
                                        <span class="text-danger fw-bold">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Kurang Rp {{ number_format(abs($selisih), 0, ',', '.') }}
                                        </span>
                                    @elseif($selisih > 0)
                                        <span class="text-success fw-bold">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Simpanan Rp {{ number_format($selisih, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-secondary fw-bold">
                                            <i class="fas fa-check me-1"></i> Pas (Lunas)
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($selisih < 0)
                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Nunggak</span>
                                    @else
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">Aman</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>