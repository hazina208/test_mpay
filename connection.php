
<?php

$host = getenv("bg4ikv5j4exzavzvcmwb-mysql.services.clever-cloud.com");
$db   = getenv("bg4ikv5j4exzavzvcmwb");
$user = getenv("uo0yxrgvekb7yhnz");
$pass = getenv("lL6TCCUmkmY9oCsTEYsX");

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

