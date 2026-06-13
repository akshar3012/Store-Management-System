<?php

// Database configuration
define('DB_SERVER', 'localhost'); // Usually 'localhost' or your database server IP
define('DB_USERNAME', 'root'); // Your database username
define('DB_PASSWORD', ''); // Your database password
define('DB_NAME', 'store_mng'); // The name of your database

try {
    // Data Source Name (DSN)
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8";

    // Create a PDO instance
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // You can optionally add a success message for testing purposes
    // echo "Database connected successfully (PDO)!";
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

?>
