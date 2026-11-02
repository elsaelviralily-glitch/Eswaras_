<?php
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Waras - Beranda</title>
    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        /* HEADER DENGAN TOMBOL NAVIGASI KAPSUL FIGMA */
        header {
            background: #ffffff;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-bottom: 2px solid #c8e6c9;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
            color: #2e7d32;
        }
        header nav {
            display: flex;
            gap: 10px;
        }
        header nav a {
            color: #2e7d32;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }
        header nav a.active, header nav a:hover {
            background: #25d366;
            color: white;
        }

        /* KONTAINER BERANDA DENGAN LATAR BINTIK-BINTIK (DOT PATTERN) */
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            
            /* Efek Latar Bintik-Bintik Hijau Soft */
            background-color: #eaf5ea;
            background-image: radial-gradient(#a5d6a7 15%, transparent 16%);
            background-size: 18px 18px;
            border: 2px solid #c8e6c9;
        }

        .banner-box {
            background: #ffffff;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            border: 1px solid #c8e6c9;
        }

        .banner-box img {
            width: 100%;
            max-height: 380px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }

        .btn-katalog {
            background: #25d366;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 15px;
            display: inline-block;
            box-shadow: 0 3px 8px rgba(37,211,102,0.3);
            transition: 0.3s;
        }
        .btn-katalog:hover {
            background: #128c7e;
            transform: translateY(-2px);
        }

        footer {
            background-color: #1b5e20;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <!-- Header & Navigasi -->
   <header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 30px; background-color: #ffffff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div style="display: flex; align-items: center; gap: 12px;">
        <img src="assets/logo_eswaras.jpeg" alt="Logo Es Waras" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
        <h1 style="margin: 0; font-size: 22px; color: #1b5e20;">Es Waras</h1>
    </div>
    <nav>
        <a href="index.php" class="active">Beranda</a>
        <a href="menu.php">Katalog Menu</a>
        <a href="login.php">Admin Login</a>
    </nav>
</header>

    <!-- Konten Beranda -->
    <div class="container">
        
        <!-- FOTO BANNER DALAM BINGKAI -->
        <div class="banner-box">
            <img src="assets/banner.jpeg" alt="Banner Es Waras">
        </div>

        <h2 style="color: #1b5e20; font-size: 28px; margin-bottom: 8px;">Selamat Datang di Es Waras!</h2>
        <p style="color: #555; font-size: 15px; margin-bottom: 25px;">Nikmati berbagai pilihan es segar berkualitas yang siap menyegarkan harimu.</p>

        <a href="menu.php" class="btn-katalog">Lihat Katalog Menu</a>
    </div>

    <!-- Footer -->
    <footer>
        <p style="margin: 0; font-size: 14px;">&copy; 2026 Es Waras. Hak Cipta Dilindungi.</p>
        <p style="margin: 5px 0 0 0; font-size: 12px; color: #c8e6c9;">Dikembangkan oleh Elsa Elvira Lily | NIM: 24404173</p>
    </footer>

</body>
</html>