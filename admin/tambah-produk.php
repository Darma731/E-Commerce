<?php
require_once '../config/koneksi.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : NULL;
    $badge = $_POST['badge'];
    $badge_type = ($badge === 'Diskon') ? 'badge-sale' : (($badge === 'Terlaris') ? 'badge-hot' : '');
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, old_price, badge, badge_type, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sddsss", $name, $price, $old_price, $badge, $badge_type, $image_url);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $message = "Gagal menambah produk!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - LuminaAdmin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans', sans-serif; background:#f4f6f9; padding:2rem; }
        .form-card { max-width:500px; margin:2rem auto; background:#fff; padding:2rem; border-radius:12px; border:1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        h2 { margin-bottom:1.5rem; font-size:1.3rem; color:#0f172a; }
        label { display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.4rem; color:#475569; }
        input, select { width:100%; padding:0.7rem; margin-bottom:1.2rem; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-family:inherit; }
        input:focus, select:focus { border-color:#6366f1; }
        .btn-submit { background:#6366f1; color:#fff; border:none; padding:0.8rem; width:100%; border-radius:8px; font-weight:700; cursor:pointer; transition:0.3s; }
        .btn-submit:hover { background:#4f46e5; }
        .btn-back { display:inline-block; margin-bottom:1rem; color:#64748b; text-decoration:none; font-size:0.85rem; font-weight:600; }
        .btn-back:hover { color:#0f172a; }
    </style>
</head>
<body>
    <div class="form-card">
        <a href="index.php" class="btn-back">&larr; Kembali ke Dashboard</a>
        <h2>Tambah Produk Baru</h2>
        
        <?php if($message): ?><p style="color:red; margin-bottom:1rem;"><?php echo $message; ?></p><?php endif; ?>

        <form method="POST">
            <label>Nama Produk</label>
            <input type="text" name="name" placeholder="Contoh: Jam Tangan Elegan" required>

            <label>Harga (Rp)</label>
            <input type="number" name="price" placeholder="450000" required>

            <label>Harga Coret / Asli (Opsional)</label>
            <input type="number" name="old_price" placeholder="600000">

            <label>Badge / Label</label>
            <select name="badge">
                <option value="">Tanpa Badge</option>
                <option value="Diskon">Diskon</option>
                <option value="Terlaris">Terlaris</option>
            </select>

            <label>URL Gambar / Link Foto Produk</label>
            <input type="text" name="image_url" placeholder="https://images.unsplash.com/..." required>

            <button type="submit" class="btn-submit">Simpan Produk</button>
        </form>
    </div>
</body>
</html>