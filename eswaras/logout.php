<?php
session_start();
// Hapus semua session yang aktif
session_unset();
session_destroy();

// Alihkan kembali ke halaman login atau beranda
header("Location: login.php");
exit();
?>