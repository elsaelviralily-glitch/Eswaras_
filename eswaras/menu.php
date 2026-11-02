\<?php
include 'config/koneksi.php';

$kategori_pilih = isset($_GET['kategori']) ? $_GET['kategori'] : 'semua';

if ($kategori_pilih == 'semua') {
    $menu_query = mysqli_query($koneksi, "SELECT * FROM tb_menu");
} else {
    $kategori_aman = mysqli_real_escape_string($koneksi, $kategori_pilih);
    $menu_query = mysqli_query($koneksi, "SELECT * FROM tb_menu WHERE LOWER(kategori) = LOWER('$kategori_aman')");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu - Es Waras</title>
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; color: #333; }
        
        /* Navbar Atas */
        .navbar { background: #ffffff; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .navbar h1 { margin: 0; font-size: 20px; color: #1b5e20; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; color: #333; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 6px; transition: 0.3s; }
        .nav-links a:hover { background: #e8f5e9; color: #2e7d32; }
        .nav-links a.active { background: #2e7d32; color: white; }

        /* Container Utama dengan Dot Pattern Hijau Lembut khas Figma */
        .container-utama { max-width: 1100px; margin: 30px auto; background-color: #ffffff; background-image: radial-gradient(#c8e6c9 1.5px, transparent 1.5px); background-size: 22px 22px; padding: 40px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #dcedc8; }
        
        /* Header Katalog Tengah */
        .header-katalog-center { text-align: center; margin-bottom: 25px; }
        .header-katalog-center h2 { margin: 0 0 5px 0; color: #1b5e20; font-size: 24px; font-weight: bold; }
        .header-katalog-center p { margin: 0; color: #555; font-size: 13px; }

        /* Kotak Filter Kategori */
        .filter-box { display: flex; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 30px; background: rgba(255, 255, 255, 0.95); padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #dcedc8; }
        .filter-box .label-katalog { font-weight: bold; color: #333; font-size: 14px; }
        .filter-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-filter { padding: 6px 14px; border-radius: 20px; text-decoration: none; font-size: 13px; font-weight: 600; transition: 0.3s; }
        .btn-filter.active { background-color: #2e7d32; color: white; }
        .btn-filter.inactive { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .btn-filter.inactive:hover { background-color: #c8e6c9; }
        
        /* Grid Menu */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .menu-card { background: #ffffff; border: 1px solid #c8e6c9; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s; }
        .menu-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); }
        .menu-card img { width: 100%; height: 150px; object-fit: cover; }
        .menu-info { padding: 15px; text-align: center; }
        .menu-info h3 { margin: 0 0 5px 0; color: #2e7d32; font-size: 16px; }
        .menu-info p { margin: 0 0 10px 0; color: #666; font-size: 13px; }
        .price { font-weight: bold; color: #e65100; font-size: 15px; margin-bottom: 12px; }
        
        .btn-action-container { padding: 0 15px 15px 15px; display: flex; flex-direction: column; gap: 8px; }
        .btn-wa { display: block; text-align: center; background-color: #25d366; color: white; padding: 8px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; transition: 0.3s; cursor: pointer; border: none; }
        .btn-wa:hover { background-color: #128c7e; }
        
        .btn-qris { display: block; text-align: center; background-color: #ffa000; color: white; padding: 8px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; font-weight: bold; transition: 0.3s; }
        .btn-qris:hover { background-color: #ff8f00; }

        /* Modal QRIS */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: #fff; padding: 25px; border-radius: 12px; text-align: center; max-width: 320px; width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
        .modal-content img { width: 200px; height: 200px; object-fit: cover; margin: 15px 0; border-radius: 8px; border: 1px solid #ddd; }
        .close-btn { background-color: #e53935; color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 13px; }
    </style>
</head>
<body>

<!-- Navbar Atas -->
<div class="navbar">
    <h1>Es Waras</h1>
    <div class="nav-links">
        <a href="index.php">Beranda</a>
        <a href="menu.php" class="active">Katalog Menu</a>
        <a href="login.php">Admin Login</a>
    </div>
</div>

<div class="container-utama">
    <div class="header-katalog-center">
        <h2>KATALOG MENU ES WARAS</h2>
        <p>Pilih kategori kesegaran favoritmu di bawah ini.</p>
    </div>

    <div class="filter-box">
        <span class="label-katalog">Katalog Menu:</span>
        <div class="filter-buttons">
            <a href="menu.php?kategori=semua" class="btn-filter <?= ($kategori_pilih == 'semua') ? 'active' : 'inactive'; ?>">Semua</a>
            <a href="menu.php?kategori=Alpukat" class="btn-filter <?= ($kategori_pilih == 'Alpukat') ? 'active' : 'inactive'; ?>">Alpukat</a>
            <a href="menu.php?kategori=Pokamilk" class="btn-filter <?= ($kategori_pilih == 'Pokamilk') ? 'active' : 'inactive'; ?>">Pokamilk</a>
            <a href="menu.php?kategori=Cincau" class="btn-filter <?= ($kategori_pilih == 'Cincau') ? 'active' : 'inactive'; ?>">Cincau</a>
        </div>
    </div>

    <div class="menu-grid">
    <?php
    if ($menu_query && mysqli_num_rows($menu_query) > 0) {
        while ($row = mysqli_fetch_assoc($menu_query)) {
            $nama_menu = $row['nama_menu'] ?? 'Menu';
            $harga = $row['harga'] ?? 0;
            $kategori = $row['kategori'] ?? 'Umum';
            $foto = $row['foto'] ?? 'default.jpg';
            $format_harga_teks = "Rp " . number_format($harga, 0, ',', '.');
    ?>
        <div class="menu-card">
            <div>
                <img src="assets/<?= htmlspecialchars($foto); ?>" alt="<?= htmlspecialchars($nama_menu); ?>">
                <div class="menu-info">
                    <h3><?= htmlspecialchars($nama_menu); ?></h3>
                    <p>Kategori: <?= htmlspecialchars($kategori); ?></p>
                    <div class="price"><?= $format_harga_teks; ?></div>
                </div>
            </div>
            <div class="btn-action-container">
                <!-- Tombol Pesan dengan Input Nama Otomatis -->
                <button onclick="pesanWa('<?= htmlspecialchars($nama_menu, ENT_QUOTES); ?>', '<?= $harga; ?>')" class="btn-wa">Pesan Sekarang</button>
                <button onclick="bukaQris('<?= htmlspecialchars($nama_menu, ENT_QUOTES); ?>', '<?= $format_harga_teks; ?>')" class="btn-qris">Bayar via QRIS</button>
            </div>
        </div>
    <?php 
        }
    } else {
        echo "<p style='grid-column: 1/-1; text-align: center; color: #777;'>Belum ada menu.</p>";
    }
    ?>
    </div>
</div>

<div id="qrisModal" class="modal">
    <div class="modal-content">
        <h3 id="modalMenu" style="margin: 0 0 5px 0; color: #2e7d32;"></h3>
        <p id="modalHarga" style="font-weight: bold; color: #e65100; margin: 0 0 10px 0;"></p>
        <p style="font-size: 12px; color: #666; margin: 0;">Scan QRIS di bawah ini untuk membayar:</p>
        <img src="assets/qris.jpeg" alt="Barcode QRIS Es Waras">
        <br>
        <button onclick="tutupQris()" class="close-btn">Tutup</button>
    </div>
</div>

<script>
function pesanWa(menu, harga) {
    let namaPembeli = prompt("Masukkan Nama Anda:");
    if (namaPembeli !== null && namaPembeli.trim() !== "") {
        window.location.href = "simpan_pesanan.php?menu=" + encodeURIComponent(menu) + "&harga=" + harga + "&nama=" + encodeURIComponent(namaPembeli);
    } else if (namaPembeli !== null) {
        alert("Nama tidak boleh kosong!");
    }
}
function bukaQris(nama, harga) {
    document.getElementById('modalMenu').innerText = nama;
    document.getElementById('modalHarga').innerText = harga;
    document.getElementById('qrisModal').style.display = 'flex';
}
function tutupQris() {
    document.getElementById('qrisModal').style.display = 'none';
}
</script>

</body>
</html>