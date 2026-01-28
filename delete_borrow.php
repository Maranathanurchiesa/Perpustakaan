<?php
session_start();

include 'database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow_id'])) {
    $borrow_id = $_POST['borrow_id'];

    $stmt = $conn->prepare("DELETE FROM borrowers WHERE id = ?");
    $stmt->bind_param("i", $borrow_id);
    
    if ($stmt->execute()) {
        echo "Peminjaman berhasil dihapus!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ID peminjaman tidak diberikan.";
}
?>
