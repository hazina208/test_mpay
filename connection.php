
<?php

$host = getenv("bg4ikv5j4exzavzvcmwb-mysql.services.clever-cloud.com");
$db   = getenv("bg4ikv5j4exzavzvcmwb");
$user = getenv("uo0yxrgvekb7yhnz");
$pass = getenv("lL6TCCUmkmY9oCsTEYsX");
$port = getenv("3306");

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

