<?php
session_start();
include 'database.php';

// TAMBAH USER
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (strlen($password) < 8) {
        $msg = "Password minimal 8 karakter!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, role)
                VALUES ('$name', '$email', '$hashed_password', '$role')";
        $msg = $conn->query($sql) ? "User berhasil ditambahkan!" : "Gagal menambah user!";
    }
}

// HAPUS USER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

// PAGINATION
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(id) AS total FROM users")->fetch_assoc()['total'];
$pages = ceil($total / $limit);

$users = $conn->query("SELECT * FROM users LIMIT $start, $limit");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola User</title>

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
    text-align: center;
    margin-bottom: 30px;
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
.btn-primary { background: #0d6efd; color: #fff; }
.btn-warning { background: #ffc107; }
.btn-danger  { background: #dc3545; color: #fff; }

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

.pagination {
    text-align: center;
    margin-top: 20px;
}

.pagination a {
    margin: 0 4px;
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid #0d6efd;
    text-decoration: none;
    color: #0d6efd;
}

.pagination a:hover {
    background: #0d6efd;
    color: #fff;
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

    <div class="top-bar">
        <h1>👥 Kelola User</h1>
        <a href="menuadmin.php" class="btn-primary" style="padding:10px 16px;border-radius:8px;text-decoration:none;color:#fff;">
            ⬅ Kembali ke Menu Admin
        </a>
    </div>

    <?php if (!empty($msg)): ?>
        <div class="card"><?= $msg ?></div>
    <?php endif; ?>

    <!-- FORM -->
    <div class="card">
        <h3>Tambah User</h3>
        <form method="POST">
            <label>Nama</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" minlength="8" required>

            <label>Role</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button class="btn-success" name="add_user">Tambah User</button>
        </form>
    </div>

    <!-- TABEL -->
    <div class="card">
        <h3>Daftar User</h3>
        <table class="table">
            <tr>
                <th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th>
            </tr>
            <?php while ($u = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['role'] ?></td>
                <td class="actions">
                    <a class="btn-primary" href="user_detail.php?id=<?= $u['id'] ?>">Lihat</a>
                    <a class="btn-warning" href="edit_user.php?id=<?= $u['id'] ?>">Edit</a>
                    <a class="btn-danger" href="?delete=<?= $u['id'] ?>" onclick="return confirm('Hapus user?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="pagination">
            <?php for ($i=1; $i<=$pages; $i++): ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>

</div>
</body>
</html>
