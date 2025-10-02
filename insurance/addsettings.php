<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "../DB_connection.php";
?>
<?php
if(isset($_POST['saveCo'])) {
	// Retrieve and sanitize input
	$co = trim($_POST['co'] ?? '');
	// Insert new user
    $query = "INSERT INTO companies (company) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $co, PDO::PARAM_STR); 
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



if(isset($_POST['savePolicy'])) {
	// Retrieve and sanitize input
	$policy = trim($_POST['policy'] ?? '');
	// Insert new user
    $query = "INSERT INTO insurance_policies (policy) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $policy, PDO::PARAM_STR); 
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

if(isset($_POST['savePrinciple'])) {
	// Retrieve and sanitize input
	$principle = trim($_POST['principle'] ?? '');
	// Insert new user
    $query = "INSERT INTO insurance_principles (principle) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $principle, PDO::PARAM_STR); 
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



if(isset($_POST['saveInsuranceMembers'])) {
	// Retrieve and sanitize input
	$fn = trim($_POST['fn'] ?? '');
	$mn = trim($_POST['mn'] ?? '');
	$ln = trim($_POST['ln'] ?? '');
	$idno = trim($_POST['idno'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$risk = trim($_POST['risk'] ?? '');
	$coverage = trim($_POST['covarage'] ?? '');
	$policy = trim($_POST['policy'] ?? '');
	$principle = trim($_POST['principle'] ?? '');
	$premium = trim($_POST['premium'] ?? '');
	// Insert new user
    $query = "INSERT INTO insurance_members (fname, mname, lname, id_no, phone, email, risk, coverage, principle, policy, premium) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR); 
	$stmt->bindParam(2, $mn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ln, PDO::PARAM_STR); 
	$stmt->bindParam(4, $idno, PDO::PARAM_STR);
	$stmt->bindParam(5, $phone, PDO::PARAM_STR); 
	$stmt->bindParam(6, $email, PDO::PARAM_STR);
	$stmt->bindParam(7, $risk, PDO::PARAM_STR); 
	$stmt->bindParam(8, $coverage, PDO::PARAM_STR);
	$stmt->bindParam(9, $policy, PDO::PARAM_STR); 
	$stmt->bindParam(10, $principle, PDO::PARAM_STR);
	$stmt->bindParam(11, $premium, PDO::PARAM_STR); 
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