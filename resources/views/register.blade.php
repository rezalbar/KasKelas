<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Kas Kelas</title>
    <link rel="shortcut icon" href="{{ asset('images/wallet.jpeg') }}" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            height: 100vh;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .card-login {
            width: 400px; border: none; border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2); overflow: hidden; background: white;
        }
        .form-control { border-radius: 10px; padding: 12px 15px; }
        .btn-login {
            background: #4e73df; border: none; border-radius: 50px;
            padding: 12px; font-weight: 700; width: 100%; color: white;
        }
        .btn-login:hover { background: #2e59d9; color: white; }
    </style>
</head>
<body>
    <div class="card-login p-4">
        <h4 class="fw-bold text-center mb-4 text-primary">Daftar Akun Baru</h4>
        <form action="/register" method="POST">
            @csrf
            <div class="mb-3">
                <label class="small fw-bold text-secondary">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required placeholder="Contoh: Budi Santoso">
            </div>
            <div class="mb-3">
                <label class="small fw-bold text-secondary">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Buat username unik">
            </div>
            <div class="mb-4">
                <label class="small fw-bold text-secondary">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
            </div>
            <button type="submit" class="btn-login mb-3">DAFTAR SEKARANG</button>
            <div class="text-center">
                <small>Sudah punya akun? <a href="/login" class="text-decoration-none fw-bold">Login di sini</a></small>
            </div>
        </form>
    </div>
</body>
</html>