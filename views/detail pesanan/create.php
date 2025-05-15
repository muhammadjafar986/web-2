<?php
include_once '../../config.php';
require_once __DIR__ . '/../../models/Detail_pesanan.php';



// Ambil data pesanan dan produk untuk dropdown
$pesanan = $pdo->query("SELECT p.id, CONCAT(pg.nama, ' - ', a.pegawai_id) AS nama_pemesan FROM pesanan p
                        JOIN anggota a ON p.anggota_id = a.id
                        JOIN pegawai pg ON a.pegawai_id = pg.id")->fetchAll(PDO::FETCH_ASSOC);

$produk = $pdo->query("SELECT id, nama FROM produk")->fetchAll(PDO::FETCH_ASSOC);

// Proses simpan data detail_pesanan
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pesanan_id = $_POST['pesanan_id'] ?? null;
    $produk_id = $_POST['produk_id'] ?? null;
    $jumlah = $_POST['jumlah'] ?? null;

    if ($pesanan_id && $produk_id && $jumlah) {
        try {
            $stmt = $pdo->prepare("INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah) VALUES (?, ?, ?)");
            $stmt->execute([$pesanan_id, $produk_id, $jumlah]);
            $message = "✅ Data berhasil disimpan.";
        } catch (PDOException $e) {
            $message = "❌ Gagal menyimpan data: " . $e->getMessage();
        }
    } else {
        $message = "❗ Semua field harus diisi.";
    }
}
?>

<?php include_once __DIR__ . '/../template/header.php'; ?>

<div class="container mt-4">
    <h2>Tambah Detail Pesanan</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="pesanan_id" class="form-label">Pilih Pesanan</label>
            <select name="pesanan_id" id="pesanan_id" class="form-select" required>
                <option value="">-- Pilih Pesanan --</option>
                <?php foreach ($pesanan as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nama_pemesan'] ?> (ID: <?= $p['id'] ?>)</option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="mb-3">
            <label for="produk_id" class="form-label">Pilih Produk</label>
            <select name="produk_id" id="produk_id" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                <?php foreach ($produk as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nama'] ?> (ID: <?= $p['id'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include_once __DIR__ . '/../template/footer.php'; ?>