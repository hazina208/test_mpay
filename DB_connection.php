<?php  

$sName = "localhost";
$uName = "root";
$pass  = "";
$db_name = "m_pay";

try {
	$conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
	echo "Connection failed: ". $e->getMessage();
	exit;
}


$host = getenv('bg4ikv5j4exzavzvcmwb-mysql.services.clever-cloud.com');
//$port = getenv('DB_PORT') ?: '3306';
$dbname = getenv('bg4ikv5j4exzavzvcmwb');
$username = getenv('uo0yxrgvekb7yhnz');
$password = getenv('lL6TCCUmkmY9oCsTEYsX');

try {
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
	$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}