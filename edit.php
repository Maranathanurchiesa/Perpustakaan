<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $book_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Buku tidak ditemukan.";
        exit;
    }

    $shelves = $conn->query("SELECT * FROM shelves");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_book'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $shelf_id = $_POST['shelf_id'];
    $year = $_POST['publication_year'];

    $stmt = $conn->prepare(
        "UPDATE books SET title=?, author=?, shelf_id=?, publication_year=? WHERE id=?"
    );
    $stmt->bind_param("ssiii", $title, $author, $shelf_id, $year, $book_id);

    if ($stmt->execute()) {
        header("Location: buku.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Buku</title>

<style>
body {
    font-family: 'Poppins', Arial, sans-serif;
    background: url('img/bg1.png') center/cover no-repeat;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
.form-card {
    background: rgba(255,255,255,.95);
    max-width: 520px;
    width: 100%;
    padding: 35px 40px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,.2);
}

/* TITLE */
.form-card h1 {
    text-align: center;
    color: #0d6efd;
    margin-bottom: 30px;
}

/* LABEL */
label {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
    color: #333;
}

/* INPUT */
input, select {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 20px;
    border-radius: 12px;
    border: 1px solid #ccc;
    font-size: 15px;
    transition: .3s;
}

input:focus, select:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 2px rgba(13,110,253,.15);
}

/* BUTTON */
.btn-save {
    width: 100%;
    padding: 12px;
    border-radius: 14px;
    border: none;
    background: linear-gradient(135deg, #28a745, #218838);
    color: white;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: .3s;
}

.btn-save:hover {
    opacity: .9;
    transform: translateY(-1px);
}

/* RESPONSIVE */
@media (max-width: 600px) {
    .form-card {
        padding: 25px;
    }
}
</style>
</head>

<body>

<div class="form-card">
    <h1>📚 Edit Buku</h1>

    <form method="POST">
        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

        <label>Judul Buku</label>
        <input type="text" name="book_title" 
               value="<?= htmlspecialchars($book['title']) ?>" required>

        <label>Penulis</label>
        <input type="text" name="book_author" 
               value="<?= htmlspecialchars($book['author']) ?>" required>

        <label>Tahun Terbit</label>
        <input type="number" name="publication_year" 
               value="<?= htmlspecialchars($book['publication_year']) ?>" 
               min="1000" max="<?= date('Y') ?>" required>

        <label>Rak Buku</label>
        <select name="shelf_id" required>
            <?php while($shelf = $shelves->fetch_assoc()): ?>
                <option value="<?= $shelf['id'] ?>"
                    <?= ($shelf['id'] == $book['shelf_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($shelf['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="edit_book" class="btn-save">
            💾 Simpan Perubahan
        </button>
    </form>
</div>

</body>
</html>
