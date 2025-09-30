<?php
$host = 'bg4ikv5j4exzavzvcmwb-mysql.services.clever-cloud.com';
$port = '3306';
$dbname = 'bg4ikv5j4exzavzvcmwb';
$username = 'uo0yxrgvekb7yhnz';
$password = 'lL6TCCUmkmY9oCsTEYsX';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>