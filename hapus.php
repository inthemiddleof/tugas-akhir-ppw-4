<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit();
}

try {
    $sql = "DELETE FROM contacts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    $_SESSION['message'] = "Kontak berhasil dihapus.";

} catch (PDOException $e) {
    $_SESSION['message'] = "Gagal menghapus kontak: " . $e->getMessage();
}

header("Location: index.php");
exit();
?>