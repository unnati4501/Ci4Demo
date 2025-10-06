<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

<?php if(session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if(session('errors')): ?>
    <div style="color:red;">
        <?php foreach(session('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="/login" method="post">
    <?= csrf_field() ?>
    <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>
    <button type="submit">Login</button>
</form>
<a href="/register">Register</a>
</body>
</html>
