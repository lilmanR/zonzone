<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat Datang di Dashboard</h1>
    <p>Halo, <?= session()->get('username'); ?>! Anda berhasil login.</p>

    <a href="<?= site_url('/logout') ?>">Logout</a>
</body>
</html>
