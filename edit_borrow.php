<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $borrow_id = $_GET['id'];

    $stmt = $conn->prepare("
        SELECT b.*, u.name AS user_name, bk.title AS book_title 
        FROM borrowers b 
        LEFT JOIN users u ON b.user_id = u.id 
        LEFT JOIN books bk ON b.book_id = bk.id 
        WHERE b.id = ?
    ");
    $stmt->bind_param("i", $borrow_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $borrow = $result->fetch_assoc();
    } else {
        echo "Peminjaman tidak ditemukan.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_borrow'])) {
    $borrow_id = $_POST['borrow_id'];
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $return_date = $_POST['return_date'];

    $stmt = $conn->prepare("UPDATE borrowers SET user_id = ?, book_id = ?, return_date = ? WHERE id = ?");
    $stmt->bind_param("iisi", $user_id, $book_id, $return_date, $borrow_id);

    if ($stmt->execute()) {
        header("Location: daftarpinjam.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Peminjaman Buku</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

body {
    font-family: 'Roboto', sans-serif;
    background: url('img/bg1.png') center/cover no-repeat;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
}

.card {
    background-color: rgba(255,255,255,0.95);
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 520px;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

h1 {
    text-align: center;
    margin-bottom: 25px;
    color: #4a148c;
    font-size: 26px;
}

label {
    font-weight: 500;
    display: block;
    margin-bottom: 6px;
}

input[type="number"],
input[type="date"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 18px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 15px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="number"]:focus,
input[type="date"]:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 8px rgba(13,110,253,0.2);
}

button {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: none;
    background: #0d6efd;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #084298;
}

@media (max-width: 500px) {
    .card {
        padding: 30px 20px;
    }

    input[type="number"],
    input[type="date"],
    button {
        font-size: 15px;
        padding: 12px;
    }

    h1 {
        font-size: 22px;
    }
}
</style>
</head>
<body>
<div class="card">
    <h1>✏️ Edit Peminjaman Buku</h1>

    <form action="edit_borrow.php?id=<?= $borrow['id'] ?>" method="POST">
        <input type="hidden" name="borrow_id" value="<?= $borrow['id'] ?>">

        <label>ID Pengguna</label>
        <input type="number" name="user_id" 
               value="<?= htmlspecialchars($borrow['user_id']) ?>" 
               placeholder="Masukkan ID pengguna" required>

        <label>ID Buku</label>
        <input type="number" name="book_id" 
               value="<?= htmlspecialchars($borrow['book_id']) ?>" 
               placeholder="Masukkan ID buku" required>

        <label>Tanggal Pengembalian</label>
        <input type="date" name="return_date" 
               value="<?= htmlspecialchars($borrow['return_date']) ?>" required>

        <button type="submit" name="edit_borrow">💾 Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
