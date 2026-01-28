<?php
session_start();

// Cek apakah user sudah login dan role = user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../loginawal.php");
    exit();
}

include 'database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_borrower'])) {
    $user_id = $_SESSION['user_id'];
    $book_id = $_POST['book_id'];

    // cek apakah user valid
    $user_check = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $user_check->bind_param("i", $user_id);
    $user_check->execute();
    $user_check_result = $user_check->get_result();

    if ($user_check_result->num_rows > 0) {
        $return_date = date('Y-m-d', strtotime('+7 days'));
        $borrow_date = date('Y-m-d');

        $stmt = $conn->prepare("INSERT INTO borrowers (user_id, book_id, return_date, borrow_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $book_id, $return_date, $borrow_date);

        if ($stmt->execute()) {
            header("Refresh:1; url=usermenu.php"); // redirect otomatis
            $message = "✅ Peminjaman berhasil! Tanggal pengembalian: $return_date";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "❌ Error: Pengguna dengan ID $user_id tidak terdaftar.";
    }

    $user_check->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman Buku | Perpustakaan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

body {
    background: url('img/bg1.png') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Card Form */
.form-card {
    background: rgba(255,255,255,0.97);
    padding: 35px 30px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.35);
    width: 360px;
}

/* Heading */
h1 {
    margin-bottom: 25px;
    color: #001F3F;
    text-align: center;
}

/* Label & Input */
label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    text-align: left;
    font-size: 15px;
}

input[type="number"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 18px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 15px;
    box-sizing: border-box;
    transition: all 0.3s;
}

input[type="number"]:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
    outline: none;
}

/* Button */
button {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: none;
    background-color: #28a745;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}

button:hover {
    background-color: #218838;
}

/* Alert Messages */
.alert {
    margin-bottom: 15px;
    padding: 14px;
    border-radius: 10px;
    font-weight: 500;
    text-align: center;
}

.alert-success {
    background-color: #e9f7ef;
    color: #2f6627;
}

.alert-error {
    background-color: #fdecea;
    color: #b71c1c;
}
</style>
</head>
<body>

<div class="form-card">
    <h1>📖 Peminjaman Buku</h1>

    <?php if ($message): ?>
        <div class="alert <?= strpos($message, '✅') === 0 ? 'alert-success' : 'alert-error' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form action="peminjaman.php" method="POST">
        <label for="user_id">ID Pengguna</label>
        <input type="number" id="user_id" name="user_id" value="<?= $_SESSION['user_id'] ?>" readonly required>

        <label for="book_id">ID Buku</label>
        <input type="number" id="book_id" name="book_id" placeholder="Masukkan ID Buku" required>

        <button type="submit" name="add_borrower">➕ Tambah Peminjaman</button>
    </form>
</div>

</body>
</html>
