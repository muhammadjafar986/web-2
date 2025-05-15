<?php
$host = 'localhost';
$dbname = 'dbkoperasi1';
$username = 'root'; // Sesuaikan dengan username database
$password = ''; // Sesuaikan dengan password database

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cek apakah koneksi berhasil
    echo "Koneksi berhasil!";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
