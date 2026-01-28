<?php
session_start();
include 'database.php';

// PROTEKSI ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginawal.php");
    exit();
}

// TAMBAH BUKU
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $shelf_id = $_POST['shelf_id'];
    $year = $_POST['publication_year'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, shelf_id, publication_year) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $title, $author, $shelf_id, $year);
    $msg = $stmt->execute() ? "Buku berhasil ditambahkan!" : "Gagal menambahkan buku!";
    $stmt->close();
}

// HAPUS BUKU
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_book'])) {
    $book_id = $_POST['book_id'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $msg = $stmt->execute() ? "Buku berhasil dihapus!" : "Gagal menghapus buku!";
    $stmt->close();
}

$shelves = $conn->query("SELECT * FROM shelves");
$books = $conn->query("SELECT b.*, s.name AS shelf_name FROM books b 
                       LEFT JOIN shelves s ON b.shelf_id = s.id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Buku</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: url('img/bg2.png') center/cover no-repeat;
    margin: 0;
    padding: 30px;
}

.container {
    max-width: 1100px;
    margin: auto;
}

.card {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 15px 30px rgba(0,0,0,.15);
    margin-bottom: 30px;
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

label {
    font-weight: 500;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    padding: 10px 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.btn-success { background: #28a745; color: #fff; }
.btn-warning { background: #ffc107; }
.btn-danger  { background: #dc3545; color: #fff; }

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

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #0d6efd;
    color: #fff;
    padding: 12px;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.table tr:hover {
    background: #f4f8ff;
}

.actions a,
.actions button {
    margin-right: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
}

.alert {
    background: #e9f2ff;
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 20px;
}
</style>
</head>

<body>
<div class="container">

    <div class="top-bar">
        <h1>📚 Kelola Buku</h1>
        <a href="menuadmin.php" class="btn-back">
            ⬅ Kembali ke Menu Admin
        </a>
    </div>

    <?php if (!empty($msg)): ?>
        <div class="alert"><?= $msg ?></div>
    <?php endif; ?>

    <div class="card">
        <h3>Tambah Buku</h3>
        <form method="POST">
            <label>Judul Buku</label>
            <input type="text" name="book_title" required>

            <label>Penulis</label>
            <input type="text" name="book_author" required>

            <label>Tahun Terbit</label>
            <input type="number" name="publication_year" min="1000" max="<?= date('Y') ?>" required>

            <label>Rak Buku</label>
            <select name="shelf_id" required>
                <?php while ($s = $shelves->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <button class="btn-success" name="add_book">Tambah Buku</button>
        </form>
    </div>

    <div class="card">
        <h3>Daftar Buku</h3>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Rak</th>
                <th>Aksi</th>
            </tr>
            <?php while ($b = $books->fetch_assoc()): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= htmlspecialchars($b['title']) ?></td>
                <td><?= htmlspecialchars($b['author']) ?></td>
                <td><?= $b['publication_year'] ?></td>
                <td><?= htmlspecialchars($b['shelf_name']) ?></td>
                <td class="actions">
                    <a class="btn-warning" href="edit.php?id=<?= $b['id'] ?>">Edit</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?= $b['id'] ?>">
                        <button class="btn-danger" name="delete_book"
                            onclick="return confirm('Hapus buku ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</body>
</html>
