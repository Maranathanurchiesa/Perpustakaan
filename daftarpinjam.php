<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

$borrowers = $conn->query("
    SELECT b.*, u.name AS user_name, bk.title AS book_title 
    FROM borrowers b 
    LEFT JOIN users u ON b.user_id = u.id 
    LEFT JOIN books bk ON b.book_id = bk.id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Peminjaman Buku</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: url('img/bg2.png') center/cover no-repeat;
    margin: 0;
    padding: 30px;
}

.container {
    max-width: 1200px;
    margin: auto;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

h1 {
    margin: 0;
}

.card {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 15px 30px rgba(0,0,0,.15);
}

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

.table tr:hover {
    background: #f4f8ff;
}

.actions a {
    margin-right: 8px;
    padding: 6px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
}

.btn-warning {
    background: #ffc107;
    color: #000;
}

.btn-danger {
    background: #dc3545;
    color: #fff;
}

.btn-back {
    background: #0d6efd;
    color: #fff;
    padding: 12px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 500;
    box-shadow: 0 6px 14px rgba(13,110,253,.35);
}

.btn-back:hover {
    background: #084298;
}

.alert {
    background: #e9f2ff;
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 20px;
    color: green;
}
</style>

<script>
function deleteBorrowing(borrowId) {
    if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_borrow.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            const messageDiv = document.getElementById('message');
            if (xhr.status === 200) {
                const row = document.getElementById('row-' + borrowId);
                if (row) row.remove();
                messageDiv.innerText = "Peminjaman berhasil dihapus!";
                messageDiv.style.color = "green";
            } else {
                messageDiv.innerText = "Terjadi kesalahan!";
                messageDiv.style.color = "red";
            }
        };

        xhr.send("borrow_id=" + borrowId);
    }
}
</script>
</head>

<body>
<div class="container">

    <div class="top-bar">
        <h1>📄 Daftar Peminjaman Buku</h1>
        <a href="menuadmin.php" class="btn-back">
            ⬅ Kembali ke Menu Admin
        </a>
    </div>

    <div id="message"></div>

    <div class="card">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = $borrowers->fetch_assoc()): ?>
            <tr id="row-<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><?= htmlspecialchars($row['book_title']) ?></td>
                <td><?= $row['borrow_date'] ?></td>
                <td><?= $row['return_date'] ?></td>
                <td class="actions">
                    <a class="btn-warning" href="edit_borrow.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="btn-danger" href="#" onclick="deleteBorrowing(<?= $row['id'] ?>)">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>

</div>
</body>
</html>
