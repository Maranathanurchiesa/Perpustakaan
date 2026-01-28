<?php
session_start();

// Cek apakah user sudah login dan role = user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../loginawal.php");
    exit();
}

// Pastikan name ada
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard User | Perpustakaan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background-image: url('../img/bg1.png');
    background-size: cover;
    background-position: center;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

.overlay {
    min-height: 100vh;
    background: rgba(0, 0, 0, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 0;
}

.welcome-title {
    font-size: 48px;
    font-weight: 700;
    letter-spacing: 1px;
}

.welcome-name {
    font-size: 22px;
    font-weight: 500;
}

.card {
    border-radius: 22px;
}

.menu-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.menu-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0,0,0,0.35);
}

.menu-card i {
    font-size: 52px;
}

.menu-card h5 {
    font-size: 20px;
    font-weight: 600;
}

.menu-card p {
    font-size: 15px;
}
</style>
</head>
<body>

<div class="overlay">
    <div class="container">
        <!-- HEADER -->
        <div class="text-center text-white mb-5">
            <h1 class="welcome-title">📚 SELAMAT DATANG</h1>
            <p class="welcome-name mt-2">
                Halo, <strong><?= htmlspecialchars($user_name); ?></strong>
            </p>
            <p class="opacity-75">Sistem Informasi Perpustakaan</p>
        </div>

        <!-- MENU -->
        <div class="row g-4 justify-content-center">
            <!-- Daftar Buku -->
            <div class="col-md-4">
                <a href="daftar_buku.php" class="text-decoration-none">
                    <div class="card menu-card text-center p-4">
                        <i class="bi bi-book text-primary"></i>
                        <h5 class="mt-3">Daftar Buku</h5>
                        <p class="text-muted">
                            Lihat seluruh koleksi buku perpustakaan
                        </p>
                    </div>
                </a>
            </div>

            <!-- Peminjaman -->
            <div class="col-md-4">
                <a href="peminjaman.php" class="text-decoration-none">
                    <div class="card menu-card text-center p-4">
                        <i class="bi bi-journal-arrow-up text-success"></i>
                        <h5 class="mt-3">Pinjam Buku</h5>
                        <p class="text-muted">
                            Ajukan peminjaman buku dengan mudah
                        </p>
                    </div>
                </a>
            </div>

            <!-- Logout -->
            <div class="col-md-4">
                <a href="logout.php" class="text-decoration-none">
                    <div class="card menu-card text-center p-4">
                        <i class="bi bi-box-arrow-right text-danger"></i>
                        <h5 class="mt-3">Logout</h5>
                        <p class="text-muted">
                            Keluar dari akun Anda
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
