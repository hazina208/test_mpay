<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="MartDevelopers" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>M-Pay - Home</title>
	<!-- Plugins css -->
    <link href="../assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  	
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 <!-- Loading button css -->
    <link href="../assets/libs/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />

       
    <!-- Footable css -->
    <link href="../assets/libs/footable/footable.core.min.css" rel="stylesheet" type="text/css" />

   
    <!--Load Sweet Alert Javascript-->
    <script src="assets/js/swal.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../assets/js/validate.js"></script>

    

        <!--prevent page reloading-->
       <script>
            if(window.history.replaceState)
            {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
        <!--end prevent page reloading-->
        
       
        <!--Inject SWAL-->
        <?php if(isset($success)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Success","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Failed","<?php echo $err;?>","Failed");
                            },
                                100);
                </script>

        <?php } ?>

        <style>
           .ck-editor__editable[role="textbox"]  
           {
            min-height:300px;
           }        
        </style>
        
   <script>
        function GetPrint(){
            window.print();
        }
                            
    </script>

   
<script>
    var _delay = 3000;
    function checkLoginStatus(){
     $.get("checkStatus.php", function(data){
        if(!data) {
            window.location = "../../logout.php"; 
        }
        setTimeout(function(){  checkLoginStatus(); }, _delay); 
        });
    }
checkLoginStatus();
</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


    function fetchCountyDetails(county) {
        if (county === "") {
            document.getElementById("county_code").value = "";
            //document.getElementById("currency").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_county_details.php?county=" + county, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("county_code").value = data.county_code;
                //document.getElementById("currency").value = data.currency;
            }
        };
    xhr.send();
    }
        
</script>

<script>
    function fetchSubCountyDetails(county) {
        if (county === "") {
            document.getElementById("county_code").value = "";
            document.getElementById("subcounty").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_sub_county_details.php?county=" + county, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("county_code").value = data.countycode;
                document.getElementById("subcounty").value = data.sub_county;
            }
        };
    xhr.send();
    }
        
</script>

<script>
    function fetchCargoVehicleFtnoDetails(cargosacco) {
        if (cargosacco === "") {
            document.getElementById("fleet_no").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_cargo_fleetno_details.php?sacco=" + cargosacco, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("fleet_no").value = data.fleet_no;
            }
        };
    xhr.send();
    }
        
</script>

<script>
    function fetchSaccoFleetnoDetails(sacco) {
        if (sacco === "") {
            document.getElementById("fleetno").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_fleetno_details.php?sacco=" + sacco, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("fleetno").value = data.fleet_no;
            }
        };
    xhr.send();
    }
        
</script>

<script>
    function fetchSaccoFtnoDetails(trasacco) {
        if (trasacco === "") {
            document.getElementById("fleet_no").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_mat_fleetno_details.php?sacco=" + trasacco, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("fleet_no").value = data.fleet_no;
            }
        };
    xhr.send();
    }
        
</script>

<script>
    function fetchCargoTransFtnoDetails(cargo_sacco) {
        if (cargo_sacco === "") {
            document.getElementById("fleet_number").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_truck_fleetno_details.php?sacco=" + cargo_sacco, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("fleet_number").value = data.fleet_no;
            }
        };
    xhr.send();
    }
        
</script>

<script>
    function fetchSubCountyDetails(county) {
        if (county === "") {
            document.getElementById("county_code").value = "";
            document.getElementById("subcounty").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_sub_county_details.php?county=" + county, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("county_code").value = data.countycode;
                document.getElementById("subcounty").value = data.sub_county;
            }
        };
    xhr.send();
    }
        
</script>


<script>
    function fetchSubCountyDetails(county) {
        if (county === "") {
            document.getElementById("county_code").value = "";
            document.getElementById("subcounty").value = "";
        return;
        }

        const xhr = new XMLHttpRequest();

        xhr.open("GET", "get_sub_county_details.php?county=" + county, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById("county_code").value = data.countycode;
                document.getElementById("subcounty").value = data.sub_county;
            }
        };
    xhr.send();
    }
        
</script>



</head>

