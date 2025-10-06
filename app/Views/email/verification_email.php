<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; }
        .container { background-color: #fff; padding: 20px; margin: 30px auto; border-radius: 8px; width: 90%; max-width: 600px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .button { display: inline-block; background-color: #007bff; color: #fff !important; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
        .footer { font-size: 12px; color: #999; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Verify Your Email Address</h2>
    <p>Hi <?= esc($username) ?>,</p>
    <p>Thank you for registering. Please verify your email address by clicking the button below:</p>

    <p style="text-align:center;">
        <a href="<?= esc($verification_link) ?>" class="button">Verify Email</a>
    </p>

    <p>If the button doesn't work, copy and paste this link into your browser:</p>
    <p><?= esc($verification_link) ?></p>

    <div class="footer">
        <p>Best regards,<br>Team <?= esc($app_name) ?></p>
    </div>
</div>
</body>
</html>
