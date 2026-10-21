<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Informasi Pasien</title>
</head>
<body>
    <h1>Informasi Pasien</h1>

    <p>
        Nomor Pasien:
        <strong><?= htmlspecialchars($nomor, ENT_QUOTES, 'UTF-8') ?></strong>
    </p>

    <p>Data ini merupakan contoh informasi pasien pada aplikasi Rumah Sakit.</p>

    <p>
        <a href="<?= htmlspecialchars(site_url('home/index'), ENT_QUOTES, 'UTF-8') ?>">
            Kembali ke halaman utama
        </a>
    </p>
</body>
</html>