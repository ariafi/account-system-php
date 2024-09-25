<?php

// Define database connection parameters
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'database');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_PORT', getenv('DB_PORT') ?: '3306');

/**
 * Create a PDO database connection
 *
 * @return PDO|null Returns PDO instance or null on failure
 */
function createDatabaseConnection(): ?PDO {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Log the error message instead of echoing it
        error_log('Database connection error: ' . $e->getMessage());
        return null; // Return null on failure
    }
}

// Usage example
$conn = createDatabaseConnection();
if ($conn === null) {
    // Handle the error, e.g., show an error message to the user
    echo 'Unable to connect to the database. Please try again later.';
    exit();
}
