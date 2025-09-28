<?php 
session_start();
include("../connection.php");
?>
<?php
if (isset($_POST['saveCounty'])) {
    $county = $conn -> real_escape_string($_POST['county']);
	$county_code = $conn -> real_escape_string($_POST['code']);

    $sql = "INSERT INTO counties (county, county_code) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $county, $county_code);

    $stmt->execute();
		
	if($stmt){
		$success = "County Added Successful";
	}
	else {
		$err = "Please Try Again Or Try Later";
	}


    if (isset($_POST['saveWard'])) {
    $county = $conn -> real_escape_string($_POST['county']);
	$county_code = $conn -> real_escape_string($_POST['code']);

    $sql = "INSERT INTO counties (county, county_code) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $county, $county_code);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'County Added!',
                text: 'New county has been inserted successfully.'
            });
        </script>";
        
    } 
    else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Insert Failed',
                text: 'Something went wrong.'
            });
        </script>";
    }
}
?>