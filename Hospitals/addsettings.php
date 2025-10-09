<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "../DB_connection.php";
?>
<?php
if(isset($_POST['saveEvent'])) {
	// Retrieve and sanitize input
	$ev = trim($_POST['event'] ?? '');
	// Insert new user
    $query = "INSERT INTO event (event_name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $ev, PDO::PARAM_STR); 
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


if(isset($_POST['saveEventDetails'])) {
	// Retrieve and sanitize input
	$ev = trim($_POST['event'] ?? '');
	$vn = trim($_POST['venue'] ?? '');
	$ed = trim($_POST['e_date'] ?? '');
	$et = trim($_POST['e_time'] ?? '');
	$reg_prc = trim($_POST['r_price'] ?? '');
	$vip_reg_prc = trim($_POST['vip_r_price'] ?? '');
	$vip_prc = trim($_POST['vip_price'] ?? '');
	$vvip_reg_prc = trim($_POST['vvip_r_price'] ?? '');
	// Insert new user
    $query = "INSERT INTO events (event,venue,date,time,regular_price,vip_regular_price,vip_price,vvip_regular) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $ev, PDO::PARAM_STR); 
	$stmt->bindParam(2, $vn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ed, PDO::PARAM_STR); 
	$stmt->bindParam(4, $et, PDO::PARAM_STR);
	$stmt->bindParam(5, $reg_prc, PDO::PARAM_STR); 
	$stmt->bindParam(6, $vip_reg_prc, PDO::PARAM_STR);
	$stmt->bindParam(7, $vip_prc, PDO::PARAM_STR); 
	$stmt->bindParam(8, $vvip_reg_prc, PDO::PARAM_STR);
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