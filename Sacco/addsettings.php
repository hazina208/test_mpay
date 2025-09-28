<?php 
session_start();
include("../connection.php");
?>
<?php


if(isset($_POST['saveSacco'])) {
    $ssaco = $conn -> real_escape_string($_POST['sacco']);
	

    $sql = "INSERT INTO saccos (sacco) VALUES (?)";
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


if(isset($_POST['saveSaccoMembers'])) {

    $fn = $conn -> real_escape_string($_POST['fn']);
	$mn = $conn -> real_escape_string($_POST['mn']);
	$ln = $conn -> real_escape_string($_POST['ln']);
	$idno = $conn -> real_escape_string($_POST['idno']);
	$phone = $conn -> real_escape_string($_POST['phone']);
	$email = $conn -> real_escape_string($_POST['email']);
	$sacco = $conn -> real_escape_string($_POST['sacco']);
	

    $sql = "INSERT INTO sacco_members (fname,mname,lname,id_no,phone,email,sacco) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fn,$mn,$ln,$idno,$phone,$email,$sacco);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}


?>