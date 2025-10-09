<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "../DB_connection.php";
?>

<?php
if(isset($_POST['saveChama'])) {
	// Retrieve and sanitize input
	$chama = trim($_POST['Chama'] ?? '');
	// Insert new user
    $query = "INSERT INTO chamas (chama_name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $chama, PDO::PARAM_STR); 
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Data inserted successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to insert data.";
        $_SESSION['status_code'] = "error";
        header("Location: dashboard.php");
        exit();
    }	
}


if(isset($_POST['saveChamaMembers'])) {
	// Retrieve and sanitize input
	$fn = trim($_POST['fn'] ?? '');
	$mn = trim($_POST['mn'] ?? '');
	$ln = trim($_POST['ln'] ?? '');
	$idno = trim($_POST['idno'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$chama = trim($_POST['chama'] ?? '');
	// Insert new user
    $query = "INSERT INTO chama_members (first_name,middle_name,last_name,id_no,phone,email,chama) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR); 
	$stmt->bindParam(2, $mn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ln, PDO::PARAM_STR); 
	$stmt->bindParam(4, $idno, PDO::PARAM_STR);
	$stmt->bindParam(5, $phone, PDO::PARAM_STR); 
	$stmt->bindParam(6, $email, PDO::PARAM_STR);
	$stmt->bindParam(7, $chama, PDO::PARAM_STR);  
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Data inserted successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to insert data.";
        $_SESSION['status_code'] = "error";
        header("Location: dashboard.php");
        exit();
    }
}


?>