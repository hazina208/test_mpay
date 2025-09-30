<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
?>
<?php


if(isset($_POST['saveEvent'])) {

    $ev = $conn -> real_escape_string($_POST['event']);
	

    $sql = "INSERT INTO event (event_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ev);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

if(isset($_POST['saveEventDetails'])) {

    $ev = $conn -> real_escape_string($_POST['event']);
	$vn = $conn -> real_escape_string($_POST['venue']);
	$ed = $conn -> real_escape_string($_POST['e_date']);
	$et = $conn -> real_escape_string($_POST['e_time']);
	$reg_prc = $conn -> real_escape_string($_POST['r_price']);
	$vip_reg_prc = $conn -> real_escape_string($_POST['vip_r_price']);
	$vip_prc = $conn -> real_escape_string($_POST['vip_price']);
	$vvip_reg_prc = $conn -> real_escape_string($_POST['vvip_r_price']);
	

    $sql = "INSERT INTO events (event,venue,date,time,regular_price,vip_regular_price,vip_price,vvip_regular) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdddd", $ev,$vn,$ed,$et,$reg_prc,$vip_reg_prc,$vip_prc,$vvip_reg_prc);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

?>