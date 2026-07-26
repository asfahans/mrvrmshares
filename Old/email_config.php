<?php
// Email Configuration
return [
    'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
    'port' => getenv('SMTP_PORT') ?: 587,
    'username' => getenv('SMTP_USER') ?: 'info@vrmshares.com',
    'password' => getenv('SMTP_PASS') ?: 'smtp_password_placeholder',
    'from_email' => getenv('FROM_EMAIL') ?: 'info@vrmshares.com',
    'from_name' => getenv('FROM_NAME') ?: 'VRM Share Broking',
    'admin_email' => getenv('ADMIN_EMAIL') ?: 'info@vrmshares.com',
];
?>
