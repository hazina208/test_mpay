<?php  
// Retrieve environment variables
$host = getenv('DB_HOST'); // e.g., bg4ikv5j4exzavzvcmwb-mysql.services.clever-cloud.com
$port = getenv('DB_PORT') ?: '3306'; // Default to 3306 if not set
$dbname = getenv('DB_NAME'); // e.g., bg4ikv5j4exzavzvcmwb
$username = getenv('DB_USER'); // e.g., uo0yxrgvekb7yhnz
$password = getenv('DB_PASS'); // e.g., lL6TCCUmkmY9oCsTEYsX

try {
    // Construct PDO connection string
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: Log success for debugging (remove in production)
    error_log("Connected successfully to database");
} catch (PDOException $e) {
    // Log error for debugging
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}
?>