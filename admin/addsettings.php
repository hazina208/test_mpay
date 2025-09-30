<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
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
		
        header("location:dashboard.php?msg=success");
	}
	else {
		
        header("location:dashboard.php?msg=error");
	}

}

if(isset($_POST['saveSubCounty'])) {
    $county = $conn -> real_escape_string($_POST['county']);
	$county_code = $conn -> real_escape_string($_POST['county_code']);
    $sub_county = $conn -> real_escape_string($_POST['subcounty']);

    $sql = "INSERT INTO sub_counties (county, countycode, sub_county) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $county, $county_code, $sub_county);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

if(isset($_POST['saveWard'])) {
    $county = $conn -> real_escape_string($_POST['county']);
	//$county_code = $conn -> real_escape_string($_POST['county_code']);
    $sub_county = $conn -> real_escape_string($_POST['subcounty']);
    $ward = $conn -> real_escape_string($_POST['ward']);

    $sql = "INSERT INTO wards (county, subcounty, ward) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $county, $sub_county, $ward);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

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

if(isset($_POST['savePosition'])) {
    $pos = $conn -> real_escape_string($_POST['pos']);
	

    $sql = "INSERT INTO positions (position) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pos);

    $stmt->execute();
		
	if($stmt){
		header("location:dashboard.php?msg=success");
	}
	else {
		header("location:dashboard.php?msg=error");
	}
}

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