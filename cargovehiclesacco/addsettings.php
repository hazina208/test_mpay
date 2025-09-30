<?php 
session_start();
include "DB_connection.php";
?>
<?php


if(isset($_POST['saveCargoSacco'])) {
    $ssaco = $conn -> real_escape_string($_POST['sacco']);
	

    $sql = "INSERT INTO lorry_sacco (sacco) VALUES (?)";
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



if(isset($_POST['saveCargoFleetNo'])) {
    $ssaco = $conn -> real_escape_string($_POST['sacco']);
	$flno = $conn -> real_escape_string($_POST['fno']);

    $sql = "INSERT INTO lorry_fleet_no (sacco,fleet_no) VALUES (?,?)";
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

if(isset($_POST['saveCargoStaff'])) {
	$fn = $conn -> real_escape_string($_POST['fname']);
	$mn = $conn -> real_escape_string($_POST['mname']);
	$ln = $conn -> real_escape_string($_POST['lname']);
	$phone = $conn -> real_escape_string($_POST['phoneno']);
	$id_no = $conn -> real_escape_string($_POST['idno']);
    $ssaco = $conn -> real_escape_string($_POST['cargosacco']);
	$flno = $conn -> real_escape_string($_POST['fleet_no']);
	$lorry_name = $conn -> real_escape_string($_POST['lorryname']);
	$position = $conn -> real_escape_string($_POST['position']);

    $sql = "INSERT INTO lorry_staff (first_name, middle_name, last_name, phone, id_no, sacco, fleet_no, lorry_name, position) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $fn, $mn, $ln, $phone, $id_no, $ssaco,$flno,$lorry_name,$position);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

if(isset($_POST['saveRegCargoVehicle'])) {
	$phone = $conn -> real_escape_string($_POST['phone']);
	$privy = $conn -> real_escape_string($_POST['privy']);
    $ssaco = $conn -> real_escape_string($_POST['cargo_sacco']);
	$flno = $conn -> real_escape_string($_POST['fleet_number']);
	$lorry_name = $conn -> real_escape_string($_POST['lorryname']);
	$reg = $conn -> real_escape_string($_POST['regno']);

    $sql = "INSERT INTO lorry_registration (sacco, fleet_no, lorry_name, privy, phone_number, reg_no) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $ssaco, $flno, $lorry_name, $privy, $phone,$reg);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}


?>