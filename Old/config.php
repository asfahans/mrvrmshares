<?php
// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'db_user_placeholder');
define('DB_PASS', getenv('DB_PASS') ?: 'db_password_placeholder');
define('DB_NAME', getenv('DB_NAME') ?: 'db_name_placeholder');

// Define your base URL or directory path
define('BASE_URL', getenv('BASE_URL') ?: 'https://www.mrvrmshare.com/');
?>