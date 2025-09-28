<?php 
session_start();
include("../connection.php");
?>
<?php


if(isset($_POST['saveChama'])) {
    $chama = $conn -> real_escape_string($_POST['Chama']);
	

    $sql = "INSERT INTO chamas (chama_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $chama);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}



if(isset($_POST['saveChamaMembers'])) {

    $fn = $conn -> real_escape_string($_POST['fn']);
	$mn = $conn -> real_escape_string($_POST['mn']);
	$ln = $conn -> real_escape_string($_POST['ln']);
	$idno = $conn -> real_escape_string($_POST['idno']);
	$phone = $conn -> real_escape_string($_POST['phone']);
	$email = $conn -> real_escape_string($_POST['email']);
	$chama = $conn -> real_escape_string($_POST['chama']);
	

    $sql = "INSERT INTO chama_members (first_name,middle_name,last_name,id_no,phone,email,chama) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fn,$mn,$ln,$idno,$phone,$email,$chama);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}


?>