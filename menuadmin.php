<?php
session_start();

// PROTEKSI ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginawal.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-image: url('img/bg1.png');
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
        }

        .menu-card {
            border-radius: 20px;
            transition: transform .3s ease, box-shadow .3s ease;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0,0,0,.25);
        }

        .title h1 {
            font-size: 44px;
            font-weight: 700;
            color: #ffffff;
        }

        .title p {
            font-size: 18px;
            color: #104391;
        }

        .title small {
            color: #104391;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-5 title">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['name']); ?></strong></p>
        <small>Sistem Informasi Perpustakaan</small>
    </div>

    <!-- ROW ATAS (3 MENU) -->
    <div class="row g-4 justify-content-center mb-4">
        <div class="col-md-4">
            <a href="admin.php" class="text-decoration-none">
                <div class="card menu-card text-center p-4">
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                    <h5 class="mt-3">Kelola User</h5>
                    <p class="text-muted">Tambah & atur pengguna</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="rak_buku.php" class="text-decoration-none">
                <div class="card menu-card text-center p-4">
                    <i class="bi bi-bookshelf fs-1 text-success"></i>
                    <h5 class="mt-3">Rak Buku</h5>
                    <p class="text-muted">Kelola rak buku</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="buku.php" class="text-decoration-none">
                <div class="card menu-card text-center p-4">
                    <i class="bi bi-book fs-1 text-warning"></i>
                    <h5 class="mt-3">Data Buku</h5>
                    <p class="text-muted">Kelola koleksi buku</p>
                </div>
            </a>
        </div>
    </div>

    <!-- ROW BAWAH (2 MENU) -->
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <a href="daftarpinjam.php" class="text-decoration-none">
                <div class="card menu-card text-center p-4">
                    <i class="bi bi-journal-check fs-1 text-info"></i>
                    <h5 class="mt-3">Peminjaman</h5>
                    <p class="text-muted">Daftar peminjaman</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="logout.php" class="text-decoration-none">
                <div class="card menu-card text-center p-4">
                    <i class="bi bi-box-arrow-right fs-1 text-danger"></i>
                    <h5 class="mt-3">Logout</h5>
                    <p class="text-muted">Keluar dari sistem</p>
                </div>
            </a>
        </div>
    </div>

</div>

</body>
</html>
