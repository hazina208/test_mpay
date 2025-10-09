<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
?>
<?php

if(isset($_POST['saveBusSacco'])) {
	// Retrieve and sanitize input
	$ssaco = trim($_POST['sacco'] ?? '');
	// Insert new user
    $query = "INSERT INTO bus_saccos (sacco) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $ssaco, PDO::PARAM_STR); 
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

if(isset($_POST['saveMatFleetNo'])) {
	// Retrieve and sanitize input
	$ssaco = trim($_POST['sacco'] ?? '');
	$flno = trim($_POST['fno'] ?? '');
	// Insert new user
    $query = "INSERT INTO fleet_no (sacco, fleet_no) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $ssaco, PDO::PARAM_STR); 
	$stmt->bindParam(2, $flno, PDO::PARAM_STR); 
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



if(isset($_POST['saveMatStaff'])) {
	// Retrieve and sanitize input
	$fn = trim($_POST['fname'] ?? '');
	$mn = trim($_POST['mname'] ?? '');
	$ln = trim($_POST['lname'] ?? '');
	$phone = trim($_POST['phoneno'] ?? '');
	$id_no = trim($_POST['idno'] ?? '');
	$ssaco = trim($_POST['sacco'] ?? '');
	$flno = trim($_POST['fleetno'] ?? '');
	$mat_name = trim($_POST['matname'] ?? '');
	$position = trim($_POST['position'] ?? '');
	// Insert new user
    $query = "INSERT INTO mat_staff (first_name, middle_name, last_name, phone, id_no, sacco, fleet_no, mat_name, position) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR); 
	$stmt->bindParam(2, $mn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ln, PDO::PARAM_STR); 
	$stmt->bindParam(4, $phone, PDO::PARAM_STR);
	$stmt->bindParam(5, $id_no, PDO::PARAM_STR); 
	$stmt->bindParam(6, $ssaco, PDO::PARAM_STR);
	$stmt->bindParam(7, $flno, PDO::PARAM_STR); 
	$stmt->bindParam(8, $mat_name, PDO::PARAM_STR);
	$stmt->bindParam(9, $position, PDO::PARAM_STR); 
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


if(isset($_POST['saveRegMatBus'])) {
	// Retrieve and sanitize input
	$phone = trim($_POST['phone'] ?? '');
	$privy = trim($_POST['privy'] ?? '');
	$ssaco = trim($_POST['trasacco'] ?? '');
	$flno = trim($_POST['fleet_no'] ?? '');
	$mat_name = trim($_POST['matname'] ?? '');
	$reg = trim($_POST['regno'] ?? '');
	// Insert new user
    $query = "INSERT INTO mat_registration (sacco, fleet_no, matatu_name, contact_person, phone_number, reg_no) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $phone, PDO::PARAM_STR); 
	$stmt->bindParam(2, $privy, PDO::PARAM_STR);
	$stmt->bindParam(3, $ssaco, PDO::PARAM_STR); 
	$stmt->bindParam(4, $flno, PDO::PARAM_STR);
	$stmt->bindParam(5, $mat_name, PDO::PARAM_STR); 
	$stmt->bindParam(6, $reg, PDO::PARAM_STR);
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