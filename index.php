<?php
session_start();
include "db.php"; // ubah sesuai lokasi file koneksi kamu

// === Fungsi untuk mendapatkan IP Real (bukan localhost) ===
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return trim(explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    }
    return $_SERVER['REMOTE_ADDR'];
}

$userIP = getUserIP();

// if ($userIP == "::1" || $userIP == "127.0.0.1") {
//     $userIP = "10.10.183.13"; // ganti otomatis ke IP WiFi kamu
// }


// === Cek IP ke database ===
$q = mysqli_query($conn, "
    SELECT *
    FROM wifi_allowed
    WHERE INET_ATON('$userIP') BETWEEN INET_ATON(ip_start) AND INET_ATON(ip_end)
");

$isValid = mysqli_num_rows($q) > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Presensi IP WiFi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f6ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,.1);
            text-align: center;
            width: 350px;
        }
        .success {
            background: #d4ffd8;
            color: #0f6d1c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .failed {
            background: #ffd4d4;
            color: #8d0000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        small {
            opacity: .6;
        }
        button {
            padding: 10px 16px;
            background: #4a78ff;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #355fe0;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Presensi Berdasarkan WiFi</h2>
    <p>IP Anda: <b><?= $userIP ?></b></p>

    <?php if ($isValid): ?>
        <div class="success">✔ IP Valid — Presensi berhasil!</div>
    <?php else: ?>
        <div class="failed">✖ IP Tidak Valid — Anda bukan di jaringan yang diizinkan!</div>
    <?php endif; ?>

    <small>Gunakan WiFi JTI untuk presensi</small>
    <br><br>

    <button onclick="location.reload()">Coba Lagi</button>
</div>

</body>
</html>
