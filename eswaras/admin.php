
<?php
include 'config/koneksi.php';

// Fitur ubah status pembayaran (Aman jika tabel tidak punya kolom id)
if (isset($_GET['action']) && $_GET['action'] == 'set_status') {
    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
    $menu = mysqli_real_escape_string($koneksi, $_GET['menu']);
    mysqli_query($koneksi, "UPDATE tb_pesanan SET status='$status' WHERE menu_dipilih='$menu' LIMIT 1");
    header("Location: admin.php");
    exit();
}

// Fitur hapus menu
if (isset($_GET['action']) && $_GET['action'] == 'hapus_menu') {
    $nama = mysqli_real_escape_string($koneksi, $_GET['nama']);
    mysqli_query($koneksi, "DELETE FROM tb_menu WHERE nama_menu='$nama'");
    header("Location: admin.php");
    exit();
}

// Fitur tambah menu baru
if (isset($_POST['tambah_menu'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = intval($_POST['harga']);
    $foto = mysqli_real_escape_string($koneksi, $_POST['foto']);

    mysqli_query($koneksi, "INSERT INTO tb_menu (nama_menu, kategori, harga, foto) VALUES ('$nama', '$kategori', '$harga', '$foto')");
    header("Location: admin.php");
    exit();
}

// Query Tanpa ORDER BY id agar TIDAK ERROR lagi!
$pesanan_query = mysqli_query($koneksi, "SELECT * FROM tb_pesanan");
$menu_query = mysqli_query($koneksi, "SELECT * FROM tb_menu");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Es Waras</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #e8f5e9; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1150px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2, h3 { color: #1b5e20; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #e0e0e0; }
        th { background: #c8e6c9; color: #1b5e20; padding: 12px; font-size: 13px; text-align: left; }
        td { padding: 10px; font-size: 13px; }
        .btn-status { padding: 5px 10px; border-radius: 4px; text-decoration: none; color: white; font-size: 11px; font-weight: bold; }
        .btn-lunas { background: #2e7d32; }
        .btn-belum { background: #d32f2f; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
        .badge-lunas { background: #e8f5e9; color: #2e7d32; }
        .badge-belum { background: #ffebee; color: #c62828; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 5px; }
        .btn-submit { background: #2e7d32; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-logout { background: #d32f2f; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 13px; }
    </style>
</head>
<body>

<div class="header-top" style="display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <img src="assets/logo_eswaras.jpeg" alt="Logo Es Waras" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;">
        <h2 style="margin: 0;">ES WARAS ADMIN</h2>
    </div>
    <a href="login.php" class="btn-logout">Logout</a>
</div>
    
    <a href="index.php" style="text-decoration: none; color: #555; font-size: 13px;">&larr; Kembali ke Katalog Utama</a>
    <br><br>

    <h3>Rekapitulasi Data Pelanggan & Waktu Pesan</h3>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA PELANGGAN</th>
                <th>MENU DIPILIH</th>
                <th>TOTAL HARGA</th>
                <th>WAKTU PEMESANAN</th>
                <th>STATUS</th>
                <th>AKSI PEMBAYARAN</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        if ($pesanan_query && mysqli_num_rows($pesanan_query) > 0) {
            while ($p = mysqli_fetch_assoc($pesanan_query)) {
                $status = isset($p['status']) ? $p['status'] : 'Belum Bayar';
                $status_class = ($status == 'Lunas') ? 'badge-lunas' : 'badge-belum';
                
                // Cek kolom tanggal
                $tgl_raw = isset($p['tanggal']) ? $p['tanggal'] : (isset($p['waktu']) ? $p['waktu'] : null);
                $tgl_formatted = $tgl_raw ? date('d/m/Y H:i', strtotime($tgl_raw)) : date('d/m/Y H:i');
                
                $nama_p = isset($p['nama_pembeli']) ? $p['nama_pembeli'] : 'Pelanggan';
                $menu_p = isset($p['menu_dipilih']) ? $p['menu_dipilih'] : (isset($p['nama_menu']) ? $p['nama_menu'] : '-');
                $harga_p = isset($p['total_harga']) ? $p['total_harga'] : (isset($p['harga']) ? $p['harga'] : 0);
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($nama_p); ?></td>
                <td><?= htmlspecialchars($menu_p); ?></td>
                <td>Rp <?= number_format($harga_p, 0, ',', '.'); ?></td>
                <td><strong><?= $tgl_formatted; ?> WITA</strong></td>
                <td><span class="status-badge <?= $status_class; ?>"><?= htmlspecialchars($status); ?></span></td>
                <td>
                    <a href="admin.php?action=set_status&menu=<?= urlencode($menu_p); ?>&status=Lunas" class="btn-status btn-lunas">Set Lunas</a>
                    <a href="admin.php?action=set_status&menu=<?= urlencode($menu_p); ?>&status=Belum Bayar" class="btn-status btn-belum">Set Belum</a>
                </td>
            </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center;'>Belum ada data pesanan.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">

    <h3>+ Tambah Menu Baru</h3>
    <form action="admin.php" method="POST" style="max-width: 500px; margin-bottom: 30px;">
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="nama_menu" required placeholder="Contoh: Alpukat Kocok Original">
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" required placeholder="Contoh: Alpukat / Pokamilk / Cincau">
        </div>
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" required placeholder="Contoh: 15000">
        </div>
        <div class="form-group">
            <label>Nama File Foto (di folder assets/)</label>
            <input type="text" name="foto" required placeholder="Contoh: alpukat_kocok.jpeg">
        </div>
        <button type="submit" name="tambah_menu" class="btn-submit">Simpan Menu Baru</button>
    </form>

    <h3>Daftar Menu Saat Ini</h3>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA MENU</th>
                <th>KATEGORI</th>
                <th>HARGA</th>
                <th>FILE FOTO</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no_m = 1;
        while ($m = mysqli_fetch_assoc($menu_query)) {
            $nama_m = isset($m['nama_menu']) ? $m['nama_menu'] : '';
        ?>
            <tr>
                <td><?= $no_m++; ?></td>
                <td><?= htmlspecialchars($nama_m); ?></td>
                <td><?= htmlspecialchars(isset($m['kategori']) ? $m['kategori'] : '-'); ?></td>
                <td>Rp <?= number_format(isset($m['harga']) ? $m['harga'] : 0, 0, ',', '.'); ?></td>
                <td><?= htmlspecialchars(isset($m['foto']) ? $m['foto'] : '-'); ?></td>
                <td>
                    <a href="admin.php?action=hapus_menu&nama=<?= urlencode($nama_m); ?>" onclick="return confirm('Yakin hapus menu ini?')" class="btn-status btn-belum">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>