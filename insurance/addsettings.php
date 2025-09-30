<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
?>
<?php


if(isset($_POST['saveCo'])) {
    $co = $conn -> real_escape_string($_POST['co']);
	

    $sql = "INSERT INTO companies (company) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $co);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}



if(isset($_POST['savePolicy'])) {
    $policy = $conn -> real_escape_string($_POST['policy']);
	

    $sql = "INSERT INTO insurance_policies (policy) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $policy);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

if(isset($_POST['savePrinciple'])) {

    $principle = $conn -> real_escape_string($_POST['principle']);

    $sql = "INSERT INTO insurance_principles (principle) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $principle);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}



if(isset($_POST['saveInsuranceMembers'])) {

    $fn = $conn -> real_escape_string($_POST['fn']);
	$mn = $conn -> real_escape_string($_POST['mn']);
	$ln = $conn -> real_escape_string($_POST['ln']);
	$idno = $conn -> real_escape_string($_POST['idno']);
	$phone = $conn -> real_escape_string($_POST['phone']);
	$email = $conn -> real_escape_string($_POST['email']);
	$risk = $conn -> real_escape_string($_POST['risk']);
	$coverage = $conn -> real_escape_string($_POST['covarage']);
	$policy = $conn -> real_escape_string($_POST['policy']);
	$principle = $conn -> real_escape_string($_POST['principle']);
	$premium = $conn -> real_escape_string($_POST['premium']);
	//$coverage = $conn -> real_escape_string($_POST['coverage']);

    $sql = "INSERT INTO insurance_members (fname, mname, lname, id_no, phone, email, risk, coverage, principle, policy, premium) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $fn,$mn,$ln,$idno,$phone,$email,$risk,$coverage,$policy,$principle,$premium);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

?>