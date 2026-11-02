<?php
include 'config/koneksi.php';

if (isset($_GET['menu']) && isset($_GET['harga'])) {
    // Pastikan mengambil parameter 'nama' dari URL
    $nama_pelanggan = !empty($_GET['nama']) ? mysqli_real_escape_string($koneksi, $_GET['nama']) : "Pelanggan";
    $menu = mysqli_real_escape_string($koneksi, $_GET['menu']);
    $harga = intval($_GET['harga']);
    $nomor_wa = "6287787959992";

    // Simpan ke kolom nama_pembeli
    $query = "INSERT INTO tb_pesanan (nama_pembeli, menu_dipilih, total_harga, status, tanggal) 
              VALUES ('$nama_pelanggan', '$menu', '$harga', 'Belum Bayar', NOW())";

    mysqli_query($koneksi, $query);

    $pesan = "Halo Es Waras, saya " . $nama_pelanggan . " mau pesan " . $menu;
    $url_wa = "https://wa.me/" . $nomor_wa . "?text=" . urlencode($pesan);

    header("Location: " . $url_wa);
    exit();
}
?>