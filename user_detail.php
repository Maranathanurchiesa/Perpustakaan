<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Pengguna tidak ditemukan.";
        exit();
    }
} else {
    echo "ID pengguna tidak ada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pengguna</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: url('img/bg1.png') center/cover no-repeat;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
.card {
    background: rgba(255,255,255,.95);
    max-width: 520px;
    width: 100%;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,.2);
}

/* TITLE */
h1 {
    text-align: center;
    margin-bottom: 25px;
    color: #0d6efd;
}

/* DATA */
.detail {
    font-size: 16px;
    margin-bottom: 14px;
}

.detail span {
    font-weight: 600;
    color: #333;
}

/* BUTTON */
.btn-back {
    display: block;
    margin-top: 30px;
    padding: 12px;
    text-align: center;
    border-radius: 12px;
    background: #0d6efd;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: .3s;
}

.btn-back:hover {
    background: #084298;
}
</style>
</head>

<body>

<div class="card">
    <h1>👤 Detail Pengguna</h1>

    <div class="detail">
        <span>Nama:</span> <?= htmlspecialchars($user['name']) ?>
    </div>

    <div class="detail">
        <span>Email:</span> <?= htmlspecialchars($user['email']) ?>
    </div>

    <div class="detail">
        <span>Role:</span> <?= htmlspecialchars($user['role']) ?>
    </div>

    <a href="admin.php" class="btn-back">
        ⬅ Kembali ke Dashboard
    </a>
</div>

</body>
</html>
