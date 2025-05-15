<?php
require_once __DIR__ . '/../../models/Detail_pesanan.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM detail_pesanan WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php?msg=deleted");
    exit;
} catch (PDOException $e) {
    echo "Gagal menghapus: " . $e->getMessage();
}
