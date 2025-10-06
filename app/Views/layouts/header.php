<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyApp</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?= base_url('/') ?>">MyApp</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto">
      <?php if(session()->get('isLoggedIn')): ?>
        <li class="nav-item"><span class="nav-link">Hello, <?= session()->get('userName') ?></span></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('logout') ?>">Logout</a></li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
