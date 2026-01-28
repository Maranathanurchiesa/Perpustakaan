<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: loginawal.php");
    exit();
}

include 'database.php';

$excluded_title = "Buku yang Ingin Dihapus";
$books = $conn->query("
    SELECT b.*, s.name AS shelf_name 
    FROM books b 
    LEFT JOIN shelves s ON b.shelf_id = s.id 
    WHERE b.title != '$excluded_title'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Buku | Perpustakaan</title>

<style>
/* Full-screen background */
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

body {
    background: url('img/bg2.png') no-repeat center center fixed;
    background-size: cover;
}

/* Container card */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 15px; /* responsif padding */
}

/* Top bar with title + back button */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

h1 {
    margin: 0;
    color: #4a148c;
}

/* Back button */
.btn-back {
    background: #0d6efd;
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 500;
    box-shadow: 0 6px 14px rgba(13,110,253,.35);
    transition: background 0.3s;
}

.btn-back:hover {
    background: #084298;
}

/* Card styling */
.card {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 15px 30px rgba(0,0,0,.15);
    overflow-x: auto; /* buat tabel responsif */
}

/* Table styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.table th {
    background: #0d6efd;
    color: #fff;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.table tr:hover td {
    background: #f4f8ff;
}

@media (max-width: 768px) {
    .table th, .table td {
        font-size: 14px;
        padding: 10px;
    }
    .top-bar {
        flex-direction: column;
        align-items: flex-start;
    }
    .btn-back {
        margin-top: 10px;
    }
}
</style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <h1>📚 Daftar Buku</h1>
        <a href="usermenu.php" class="btn-back">
            ⬅ Kembali ke User Menu
        </a>
    </div>

    <div class="card">
        <table class="table">
            <tr>
                <th>ID Buku</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Rak</th>
            </tr>
            <?php while ($row = $books->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['publication_year']) ?></td>
                <td><?= htmlspecialchars($row['shelf_name']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
