<?php
session_start();
include 'database.php';

/* PROTEKSI ADMIN */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: loginawal.php");
    exit();
}

/* TAMBAH RAK */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_shelf'])) {
    $name = $_POST['shelf_name'];
    $location = $_POST['shelf_location'];

    $stmt = $conn->prepare("INSERT INTO shelves (name, location) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $location);
    $stmt->execute();
    $stmt->close();

    header("Location: rak_buku.php");
    exit();
}

/* HAPUS RAK */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM shelves WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: rak_buku.php");
    exit();
}

$shelves = $conn->query("SELECT * FROM shelves ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Rak Buku</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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

h1 {
    margin: 0;
}

label {
    font-weight: 500;
}

input {
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
.btn-primary { background: #0d6efd; color: #fff; }
.btn-danger  { background: #dc3545; color: #fff; }
.btn-warning { background: #ffc107; }

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

.actions a {
    margin-right: 6px;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
</style>
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="top-bar">
        <h1>📚 Rak Buku</h1>
        <a href="menuadmin.php" class="btn-primary" style="padding:10px 16px;border-radius:8px;text-decoration:none;color:#fff;">
            ⬅ Kembali ke Menu Admin
        </a>
    </div>

    <!-- FORM TAMBAH -->
    <div class="card">
        <h3>Tambah Rak Buku</h3>
        <form method="POST">
            <label>Nama Rak</label>
            <input type="text" name="shelf_name" required>

            <label>Lokasi Rak</label>
            <input type="text" name="shelf_location" required>

            <button class="btn-success" name="add_shelf">Tambah Rak</button>
        </form>
    </div>

    <!-- TABEL -->
    <div class="card">
        <h3>Daftar Rak Buku</h3>
        <table class="table">
            <tr>
                <th>Nama Rak</th>
                <th>Lokasi</th>
                <th width="180">Aksi</th>
            </tr>

            <?php while ($r = $shelves->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($r['name']); ?></td>
                <td><?= htmlspecialchars($r['location']); ?></td>
                <td class="actions">
                    <a class="btn-warning" href="edit_shelf.php?id=<?= $r['id'] ?>">Edit</a>
                    <a class="btn-danger" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Hapus rak ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</body>
</html>
