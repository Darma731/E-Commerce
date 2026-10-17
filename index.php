<?php
require_once 'config/koneksi.php';

// Ambil Katalog Produk dari Database phpMyAdmin
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuminaStore - Toko Online Modern</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- PEMANGGILAN CSS DARI FOLDER TAMPILAN -->
    <link rel="stylesheet" href="assets/tampilan/app-thema.css">
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container nav-container">
            <a href="#" class="logo">Lumina<span>Store</span></a>

            <!-- FITUR PENCARIAN DI NAVBAR -->
            <div class="nav-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="navSearchInput" placeholder="Cari produk favoritmu..." onkeyup="filterProducts()">
            </div>

            <!-- TOGGLE MENU CHECKBOX -->
            <input type="checkbox" id="menu-toggle" class="menu-toggle">

            <!-- SUB MENU NAVIGASI (GARIS TIGA) -->
            <nav class="nav-links">
                <a href="#beranda"><i class="fa-solid fa-house"></i> Beranda</a>
                
                <!-- DROPDOWN KATALOG PRODUK -->
                <div class="dropdown">
                    <a href="#produk" class="dropdown-toggle">
                        <i class="fa-solid fa-layer-group"></i> Katalog <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="#produk" onclick="filterCategory('all')"><i class="fa-solid fa-border-all"></i> Semua Produk</a>
                        <a href="#produk" onclick="filterCategory('Diskon')"><i class="fa-solid fa-tags"></i> Produk Diskon</a>
                        <a href="#produk" onclick="filterCategory('Terlaris')"><i class="fa-solid fa-fire"></i> Produk Terlaris</a>
                    </div>
                </div>
            </nav>

            <!-- ACTION BUTTONS & TOMBOL GARIS TIGA -->
            <div class="nav-actions">
                <button class="icon-btn cart-btn" id="openCartBtn" title="Keranjang Pesanan">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="badge" id="cartCount">0</span>
                </button>

                <!-- TOMBOL GARIS TIGA (HAMBURGER) -->
                <label for="menu-toggle" class="hamburger-btn" title="Menu Navigasi">
                    <i class="fa-solid fa-bars"></i>
                </label>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero" id="beranda">
        <div class="container hero-container">
            <div class="hero-content">
                <span class="hero-badge"><i class="fa-solid fa-sparkles"></i> Koleksi Terbaru 2026</span>
                <h1 class="hero-title">Temukan Gaya <span class="gradient-text">Terbaikmu</span></h1>
                <p>Belanja produk pilihan berkualitas langsung dari katalog eksklusif kami dengan penawaran harga terbaik.</p>
                <a href="#produk" class="btn btn-primary" style="margin-top: 1rem;">
                    Mulai Belanja <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="hero-img-wrapper">
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=800&q=80"
                    class="hero-img" alt="Hero LuminaStore">
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN LAYANAN (VALUE PROPOSITIONS) -->
    <section class="features">
        <div class="container features-grid">
            <div class="feature-card">
                <i class="fa-solid fa-truck-fast"></i>
                <div>
                    <h4>Gratis Ongkir</h4>
                    <p>Ke seluruh Indonesia</p>
                </div>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <h4>100% Original</h4>
                    <p>Jaminan kualitas produk</p>
                </div>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-wallet"></i>
                <div>
                    <h4>Pembayaran COD</h4>
                    <p>Bayar saat barang sampai</p>
                </div>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-headset"></i>
                <div>
                    <h4>Layanan 24/7</h4>
                    <p>Customer Support Ramah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- KATALOG PRODUK -->
    <section class="products" id="produk">
        <div class="container">
            <div class="section-header">
                <h2>Katalog Produk</h2>
                <p>Pilih produk favoritmu dan tentukan jumlah pesanan.</p>
            </div>

            <!-- FILTER CATEGORY BUTTONS -->
            <div class="catalog-filter-wrapper">
                <div class="category-buttons">
                    <button class="cat-btn active" onclick="filterCategory('all')">Semua Produk</button>
                    <button class="cat-btn" onclick="filterCategory('Diskon')">Promo Diskon</button>
                    <button class="cat-btn" onclick="filterCategory('Terlaris')">Paling Terlaris</button>
                </div>
            </div>

            <div class="products-grid" id="productsGrid">
                <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <article class="product-card" data-badge="<?php echo htmlspecialchars($row['badge'] ?? ''); ?>">
                    <?php if (!empty($row['badge'])): ?>
                    <div class="product-badge <?php echo htmlspecialchars($row['badge_type']); ?>">
                        <?php echo htmlspecialchars($row['badge']); ?>
                    </div>
                    <?php endif; ?>

                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </div>

                    <div class="product-info">
                        <div class="product-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                            <span>(4.8)</span>
                        </div>

                        <h3 class="product-name"><?php echo htmlspecialchars($row['name']); ?></h3>

                        <div>
                            <span class="current-price">Rp
                                <?php echo number_format($row['price'], 0, ',', '.'); ?></span>
                            <?php if (!empty($row['old_price'])): ?>
                            <span class="old-price">Rp
                                <?php echo number_format($row['old_price'], 0, ',', '.'); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Input Jumlah Pesanan -->
                        <div class="qty-control-wrapper">
                            <label for="qty-<?php echo $row['id']; ?>">Jumlah:</label>
                            <input type="number" id="qty-<?php echo $row['id']; ?>" class="qty-input" value="1" min="1" max="99">
                        </div>

                        <button class="btn btn-primary add-to-cart-full"
                            onclick="addToCart(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', <?php echo $row['price']; ?>, '<?php echo $row['image_url']; ?>')">
                            <i class="fa-solid fa-cart-plus"></i> Tambah Pesanan
                        </button>
                    </div>
                </article>
                <?php endwhile; ?>
                <?php else: ?>
                <p>Belum ada produk di katalog database.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- MODAL KERANJANG -->
    <div class="cart-modal" id="cartModal">
        <div class="cart-content">
            <div class="cart-header">
                <h3>Keranjang Pesanan</h3>
                <button class="close-modal" id="closeCartBtn">&times;</button>
            </div>

            <div class="cart-body" id="cartItemsContainer"></div>

            <div class="cart-footer">
                <div class="total-row">
                    <span>Total Pembayaran:</span>
                    <strong id="cartTotalText">Rp 0</strong>
                </div>

                <form id="checkoutForm" onsubmit="processCheckout(event)">
                    <h4>Data Pemesan:</h4>
                    <input type="text" id="custName" placeholder="Nama Lengkap" required>
                    <input type="tel" id="custPhone" placeholder="Nomor WhatsApp" required>
                    <textarea id="custAddress" placeholder="Alamat Pengiriman" required></textarea>

                    <select id="custPayment" required>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS">QRIS / E-Wallet</option>
                        <option value="COD">Bayar di Tempat (COD)</option>
                    </select>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Kirim Pesanan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-container">
            <div>
                <h3>Lumina<span>Store</span></h3>
                <p>Toko online modern pilihan keluarga Indonesia dengan produk berkualitas dan garansi terbaik.</p>
            </div>
            <div>
                <h4>Navigasi</h4>
                <a href="#beranda">Beranda</a> | <a href="#produk">Katalog Produk</a>
            </div>
            <div>
                <h4>Pembayaran</h4>
                <p><i class="fa-solid fa-qrcode"></i> QRIS, Transfer Bank, COD</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 LuminaStore. All rights reserved.</p>
        </div>
    </footer>

    <!-- TOMBOL WA MELAYANG -->
    <a href="https://wa.me/6287893953237?text=Halo%20LuminaStore,%20saya%20ingin%20tanya%20produk" 
       class="floating-wa-btn" target="_blank" title="Chat Admin via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- JAVASCRIPT FITUR PENCARIAN & FILTER -->
    <script>
    function filterProducts() {
        const input = document.getElementById('navSearchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.querySelector('.product-name').textContent.toLowerCase();
            if (name.includes(input)) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }
        });
    }

    function filterCategory(badgeType) {
        const buttons = document.querySelectorAll('.cat-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (event && event.target && event.target.classList.contains('cat-btn')) {
            event.target.classList.add('active');
        }

        const cards = document.querySelectorAll('.product-card');
        cards.forEach(card => {
            const badge = card.getAttribute('data-badge');
            if (badgeType === 'all' || badge === badgeType) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }
        });
    }
    </script>

    <!-- PEMANGGILAN JS UTAMA -->
    <script src="assets/logika/app-script.js"></script>
</body>

</html>