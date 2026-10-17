<?php
require_once '../config/koneksi.php';

// Ambil Total Produk
$total_produk = 0;
$res_p = $conn->query("SELECT COUNT(*) as total FROM products");
if ($res_p) {
    $total_produk = $res_p->fetch_assoc()['total'];
}

// Cek dan Ambil Data Pesanan secara Aman
$total_pesanan = 0;
$total_pendapatan = 0;

$check_orders = $conn->query("SHOW TABLES LIKE 'orders'");
if ($check_orders && $check_orders->num_rows > 0) {
    // Cek jumlah pesanan
    $res_o = $conn->query("SELECT COUNT(*) as total FROM orders");
    if ($res_o) $total_pesanan = $res_o->fetch_assoc()['total'];

    // Cek apakah kolom total_price ada
    $check_col = $conn->query("SHOW COLUMNS FROM orders LIKE 'total_price'");
    if ($check_col && $check_col->num_rows > 0) {
        $res_s = $conn->query("SELECT SUM(total_price) as total FROM orders");
        if ($res_s) $total_pendapatan = $res_s->fetch_assoc()['total'] ?? 0;
    }
}

// Ambil Data Produk untuk Tabel
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LuminaStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- CDN Chart.js untuk Grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Plus Jakarta Sans', sans-serif; }
        body { background:#f4f6f9; color:#334155; display:flex; min-height:100vh; }
        
        .sidebar { width:250px; background:#0f172a; color:#fff; padding:1.5rem; flex-shrink: 0; }
        .sidebar h2 { font-size:1.3rem; margin-bottom:2rem; color:#fff; }
        .sidebar h2 span { color:#6366f1; }
        .sidebar a { display:flex; align-items:center; gap:0.8rem; color:#94a3b8; text-decoration:none; padding:0.8rem 1rem; border-radius:8px; margin-bottom:0.5rem; transition:0.3s; font-size: 0.9rem; font-weight: 600; }
        .sidebar a:hover, .sidebar a.active { background:#1e293b; color:#fff; }
        
        .main-content { flex:1; padding:2rem; overflow-y:auto; }
        .header-title { font-size:1.5rem; font-weight:800; margin-bottom:1.5rem; color:#0f172a; }
        
        /* Cards Stats */
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem; margin-bottom:2rem; }
        .stat-card { background:#fff; padding:1.2rem; border-radius:12px; border:1px solid #e2e8f0; display:flex; align-items:center; gap:1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .stat-card i { font-size:1.8rem; color:#6366f1; background:#eef2ff; padding:0.8rem; border-radius:10px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
        .stat-card h3 { font-size:1.2rem; font-weight:800; color:#0f172a; }
        .stat-card p { font-size:0.8rem; color:#64748b; font-weight: 600; }

        /* Chart & Table Container */
        .dashboard-grid { display:grid; grid-template-columns: 2fr 1fr; gap:1.5rem; margin-bottom:2rem; }
        .card-box { background:#fff; padding:1.5rem; border-radius:12px; border:1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .card-box h3 { font-size:1.1rem; margin-bottom:1rem; font-weight:700; color:#0f172a; display: flex; align-items: center; gap: 0.5rem; }

        /* Table */
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        th, td { padding:0.8rem; text-align:left; border-bottom:1px solid #e2e8f0; font-size:0.85rem; }
        th { background:#f8fafc; font-weight:700; color: #475569; }
        .btn-add { background:#6366f1; color:#fff; padding:0.6rem 1.2rem; border-radius:8px; text-decoration:none; font-weight:600; display:inline-flex; align-items: center; gap: 0.4rem; font-size: 0.85rem; transition: 0.3s; }
        .btn-add:hover { background: #4f46e5; }
        .btn-delete { color:#e11d48; cursor:pointer; border:none; background:none; font-size:1rem; padding: 0.4rem; transition: 0.2s; }
        .btn-delete:hover { color: #9f1239; }
        .img-thumb { width:45px; height:45px; border-radius:8px; object-fit:cover; }

        @media (max-width: 992px) {
            .dashboard-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Lumina<span>Admin</span></h2>
        <a href="index.php" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="tambah-produk.php"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
        <a href="../index.php" target="_blank"><i class="fa-solid fa-store"></i> Lihat Toko</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h1 class="header-title">Dashboard Penjualan & Produk</h1>

        <!-- RINGKASAN STATISTIK -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fa-solid fa-box"></i>
                <div>
                    <p>Total Produk</p>
                    <h3><?php echo $total_produk; ?> Barang</h3>
                </div>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-cart-shopping"></i>
                <div>
                    <p>Total Pesanan</p>
                    <h3><?php echo $total_pesanan; ?> Pesanan</h3>
                </div>
            </div>
            <div class="stat-card">
                <i class="fa-solid fa-wallet"></i>
                <div>
                    <p>Total Pendapatan</p>
                    <h3>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>

        <!-- GRAFIK PENJUALAN & KATEGORI -->
        <div class="dashboard-grid">
            <div class="card-box">
                <h3><i class="fa-solid fa-chart-line" style="color:#6366f1;"></i> Grafik Penjualan Bulanan</h3>
                <canvas id="salesChart" height="120"></canvas>
            </div>
            <div class="card-box">
                <h3><i class="fa-solid fa-pie-chart" style="color:#6366f1;"></i> Kategori Produk</h3>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>

        <!-- TABEL KELOLA PRODUK -->
        <div class="card-box">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3>Daftar Katalog Produk</h3>
                <a href="tambah-produk.php" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Harga Coret</th>
                        <th>Badge</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($products && $products->num_rows > 0): ?>
                        <?php while($row = $products->fetch_assoc()): ?>
                        <tr>
                            <td><img src="../<?php echo htmlspecialchars($row['image_url']); ?>" class="img-thumb" onerror="this.src='<?php echo $row['image_url']; ?>'"></td>
                            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                            <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['old_price'] ? 'Rp '.number_format($row['old_price'], 0, ',', '.') : '-'; ?></td>
                            <td><span style="background:#eef2ff; color:#6366f1; padding:0.2rem 0.6rem; border-radius:20px; font-weight:700; font-size:0.75rem;"><?php echo $row['badge'] ?: 'Normal'; ?></span></td>
                            <td>
                                <a href="hapus-produk.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="btn-delete" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center; color:#94a3b8; padding:2rem;">Belum ada produk di database.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SCRIPT GRAFIK CHART.JS -->
    <script>
        // Grafik Penjualan (Line Chart)
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: [1200000, 1900000, 3000000, 2500000, 4200000, 3800000, 5100000, 4800000, 6000000, 7500000],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

        // Grafik Kategori (Doughnut Chart)
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: ['Diskon', 'Terlaris', 'Normal'],
                datasets: [{
                    data: [12, 19, 7],
                    backgroundColor: ['#e11d48', '#f97316', '#6366f1']
                }]
            }
        });
    </script>
</body>
</html>