<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "../DB_connection.php";
?>
<?php
if (isset($_POST['saveCounty'])) {
	 // Retrieve and sanitize input
	$county = trim($_POST['county'] ?? '');
    $county_code = trim($_POST['code'] ?? '');

	// Insert new user
        $query = "INSERT INTO counties (county, county_code) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $county, PDO::PARAM_STR);
		$stmt->bindParam(2, $county_code, PDO::PARAM_STR);
       
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



if(isset($_POST['saveSubCounty'])) {
	// Retrieve and sanitize input
	$county = trim($_POST['county'] ?? '');
    $county_code = trim($_POST['county_code'] ?? '');
	$sub_county = trim($_POST['subcounty'] ?? '');

	// Insert new user
    $query = "INSERT INTO sub_counties (county, countycode, sub_county) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $county, PDO::PARAM_STR);
	$stmt->bindParam(2, $county_code, PDO::PARAM_STR);
	$stmt->bindParam(3, $sub_county, PDO::PARAM_STR);
       
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

if(isset($_POST['saveWard'])) {
	// Retrieve and sanitize input
	$county = trim($_POST['county'] ?? '');
    $sub_county = trim($_POST['subcounty'] ?? '');
	$ward = trim($_POST['ward'] ?? '');

	// Insert new user
    $query = "INSERT INTO sub_counties (county, subcounty, ward) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $county, PDO::PARAM_STR);
	$stmt->bindParam(2, $sub_county, PDO::PARAM_STR);
	$stmt->bindParam(3, $ward, PDO::PARAM_STR);
       
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

if(isset($_POST['savePosition'])) {
	// Retrieve and sanitize input
	$pos = trim($_POST['pos'] ?? '');
	// Insert new user
    $query = "INSERT INTO positions (position) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $pos, PDO::PARAM_STR); 
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

if(isset($_POST['saveChama'])) {
	// Retrieve and sanitize input
	$chama = trim($_POST['Chama'] ?? '');
	// Insert new user
    $query = "INSERT INTO chamas (chama_name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $chama, PDO::PARAM_STR); 
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

if(isset($_POST['saveSacco'])) {
	// Retrieve and sanitize input
	$ssaco = trim($_POST['sacco'] ?? '');
	// Insert new user
    $query = "INSERT INTO saccos (sacco) VALUES (?)";
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

if(isset($_POST['saveCargoSacco'])) {
  	// Retrieve and sanitize input
	$ssaco = trim($_POST['sacco'] ?? '');
	// Insert new user
    $query = "INSERT INTO lorry_sacco (sacco) VALUES (?)";
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

if(isset($_POST['saveCargoFleetNo'])) {
	// Retrieve and sanitize input
	$ssaco = trim($_POST['sacco'] ?? '');
	$flno = trim($_POST['fno'] ?? '');
	// Insert new user
    $query = "INSERT INTO lorry_fleet_no (sacco, fleet_no) VALUES (?, ?)";
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

if(isset($_POST['saveCargoStaff'])) {
	// Retrieve and sanitize input
	$fn = trim($_POST['fname'] ?? '');
	$mn = trim($_POST['mname'] ?? '');
	$ln = trim($_POST['lname'] ?? '');
	$phone = trim($_POST['phoneno'] ?? '');
	$id_no = trim($_POST['idno'] ?? '');
	$ssaco = trim($_POST['cargosacco'] ?? '');
	$flno = trim($_POST['fleet_no'] ?? '');
	$lorry_name = trim($_POST['lorryname'] ?? '');
	$position = trim($_POST['position'] ?? '');
	// Insert new user
    $query = "INSERT INTO lorry_staff (first_name, middle_name, last_name, phone, id_no, sacco, fleet_no, lorry_name, position) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR); 
	$stmt->bindParam(2, $mn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ln, PDO::PARAM_STR); 
	$stmt->bindParam(4, $phone, PDO::PARAM_STR);
	$stmt->bindParam(5, $id_no, PDO::PARAM_STR); 
	$stmt->bindParam(6, $ssaco, PDO::PARAM_STR);
	$stmt->bindParam(7, $flno, PDO::PARAM_STR); 
	$stmt->bindParam(8, $lorry_name, PDO::PARAM_STR);
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

if(isset($_POST['saveRegCargoVehicle'])) {
	// Retrieve and sanitize input
	$phone = trim($_POST['phone'] ?? '');
	$privy = trim($_POST['privy'] ?? '');
	$ssaco = trim($_POST['cargo_sacco'] ?? '');
	$flno = trim($_POST['fleet_number'] ?? '');
	$lorry_name = trim($_POST['lorryname'] ?? '');
	$reg = trim($_POST['regno'] ?? '');
	// Insert new user
    $query = "INSERT INTO lorry_registration (sacco, fleet_no, lorry_name, privy, phone_number, reg_no) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $phone, PDO::PARAM_STR); 
	$stmt->bindParam(2, $privy, PDO::PARAM_STR);
	$stmt->bindParam(3, $ssaco, PDO::PARAM_STR); 
	$stmt->bindParam(4, $flno, PDO::PARAM_STR);
	$stmt->bindParam(5, $lorry_name, PDO::PARAM_STR); 
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

if(isset($_POST['saveChamaMembers'])) {
	// Retrieve and sanitize input
	$fn = trim($_POST['fn'] ?? '');
	$mn = trim($_POST['mn'] ?? '');
	$ln = trim($_POST['ln'] ?? '');
	$idno = trim($_POST['idno'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$chama = trim($_POST['chama'] ?? '');
	// Insert new user
    $query = "INSERT INTO chama_members (first_name,middle_name,last_name,id_no,phone,email,chama) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR); 
	$stmt->bindParam(2, $mn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ln, PDO::PARAM_STR); 
	$stmt->bindParam(4, $idno, PDO::PARAM_STR);
	$stmt->bindParam(5, $phone, PDO::PARAM_STR); 
	$stmt->bindParam(6, $email, PDO::PARAM_STR);
	$stmt->bindParam(7, $chama, PDO::PARAM_STR);  
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

if(isset($_POST['saveSaccoMembers'])) {
	// Retrieve and sanitize input
	$fn = trim($_POST['fname'] ?? '');
	$mn = trim($_POST['mname'] ?? '');
	$ln = trim($_POST['lname'] ?? '');
	$idno = trim($_POST['idno'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$sacco = trim($_POST['sacco'] ?? '');
	// Insert new user
    $query = "INSERT INTO sacco_members (fname,mname,lname,id_no,phone,email,sacco) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $fn, PDO::PARAM_STR); 
	$stmt->bindParam(2, $mn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ln, PDO::PARAM_STR); 
	$stmt->bindParam(4, $idno, PDO::PARAM_STR);
	$stmt->bindParam(5, $phone, PDO::PARAM_STR); 
	$stmt->bindParam(6, $email, PDO::PARAM_STR);
	$stmt->bindParam(7, $sacco, PDO::PARAM_STR);  
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

if(isset($_POST['saveEvent'])) {
	// Retrieve and sanitize input
	$ev = trim($_POST['event'] ?? '');
	// Insert new user
    $query = "INSERT INTO event (event_name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $ev, PDO::PARAM_STR); 
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

if(isset($_POST['saveEventDetails'])) {
	// Retrieve and sanitize input
	$ev = trim($_POST['event'] ?? '');
	$vn = trim($_POST['venue'] ?? '');
	$ed = trim($_POST['e_date'] ?? '');
	$et = trim($_POST['e_time'] ?? '');
	$reg_prc = trim($_POST['r_price'] ?? '');
	$vip_reg_prc = trim($_POST['vip_r_price'] ?? '');
	$vip_prc = trim($_POST['vip_price'] ?? '');
	$vvip_reg_prc = trim($_POST['vvip_r_price'] ?? '');
	// Insert new user
    $query = "INSERT INTO events (event,venue,date,time,regular_price,vip_regular_price,vip_price,vvip_regular) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $ev, PDO::PARAM_STR); 
	$stmt->bindParam(2, $vn, PDO::PARAM_STR);
	$stmt->bindParam(3, $ed, PDO::PARAM_STR); 
	$stmt->bindParam(4, $et, PDO::PARAM_STR);
	$stmt->bindParam(5, $reg_prc, PDO::PARAM_STR); 
	$stmt->bindParam(6, $vip_reg_prc, PDO::PARAM_STR);
	$stmt->bindParam(7, $vip_prc, PDO::PARAM_STR); 
	$stmt->bindParam(8, $vvip_reg_prc, PDO::PARAM_STR);
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