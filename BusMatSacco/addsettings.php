<?php 
session_start();
include("../connection.php");
?>
<?php

if(isset($_POST['saveBusSacco'])) {
    $ssaco = $conn -> real_escape_string($_POST['sacco']);
	

    $sql = "INSERT INTO bus_saccos (sacco) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ssaco);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

if(isset($_POST['saveMatFleetNo'])) {
    $ssaco = $conn -> real_escape_string($_POST['sacco']);
	$flno = $conn -> real_escape_string($_POST['fno']);
	

    $sql = "INSERT INTO fleet_no (sacco,fleet_no) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $ssaco,$flno);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}



if(isset($_POST['saveMatStaff'])) {
	$fn = $conn -> real_escape_string($_POST['fname']);
	$mn = $conn -> real_escape_string($_POST['mname']);
	$ln = $conn -> real_escape_string($_POST['lname']);
	$phone = $conn -> real_escape_string($_POST['phoneno']);
	$id_no = $conn -> real_escape_string($_POST['idno']);
    $ssaco = $conn -> real_escape_string($_POST['sacco']);
	$flno = $conn -> real_escape_string($_POST['fleetno']);
	$mat_name = $conn -> real_escape_string($_POST['matname']);
	$position = $conn -> real_escape_string($_POST['position']);

    $sql = "INSERT INTO mat_staff (first_name, middle_name, last_name, phone, id_no, sacco, fleet_no, mat_name, position) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $fn, $mn, $ln, $phone, $id_no, $ssaco,$flno,$mat_name,$position);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

if(isset($_POST['saveRegMatBus'])) {
	
	$phone = $conn -> real_escape_string($_POST['phone']);
	$privy = $conn -> real_escape_string($_POST['privy']);
    $ssaco = $conn -> real_escape_string($_POST['trasacco']);
	$flno = $conn -> real_escape_string($_POST['fleet_no']);
	$mat_name = $conn -> real_escape_string($_POST['matname']);
	$reg = $conn -> real_escape_string($_POST['regno']);

    $sql = "INSERT INTO mat_registration (sacco, fleet_no, matatu_name, contact_person, phone_number, reg_no) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $ssaco, $flno, $mat_name, $privy,$phone,$reg);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}


?>