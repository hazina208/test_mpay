<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
if(empty($_SESSION['id']))
{
    header('location:../login.php');
}

?>


<?php 
  include "inc/header.php";
?>
<body>
    <?php 
        include "inc/navbar.php";
     ?>
     <div class="container mt-5">
         <div class="container text-center">
          <?php 
            if(isset($_SESSION['status']) && $_SESSION['status']!='')
            {
                ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong><?php echo $_SESSION['status']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
			    ?>
             <div class="row row-cols-5">
               <a href="" 
                  class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                 <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                  Add Insurance Company
               </a>
               
               <a href="" 
                  class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addPolicyModal">
                 <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                  Add Insurance Policy
               </a>

               <a href="" 
                  class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addPrinciplesModal">
                 <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                  Add Insurance Principle
               </a>

               <a href="" 
                  class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addInsuranceMembersModal">
                 <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                  Add Insurance Member
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSaccoModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Add Sacco
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSaccoMembersModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Add Sacco Members
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addBusSaccoModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Add Bus Matatus Sacco
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoSaccoModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Add Lorries Sacco
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                 <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                 Add Position
               </a> 
                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCountyModal">
                 <i class="fa fa-cubes fs-1" aria-hidden="true"></i><br>
                  Add County 
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSubCountyModal">
                 <i class="fa fa-folder-open fs-1" aria-hidden="true"></i><br>
                  Add Sub County
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addWardModal">
                 <i class="fa fa-group fs-1" aria-hidden="true"></i><br>
                  Add Ward
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChamaModal">
                 <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Add Chama
               </a> 

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChamaMembersModal">
                 <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Add Chama Members
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addEventModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Event
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addEventDetailsModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Event Details
               </a> 

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatStaffModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Matatu/Bus Staff
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoStaffModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Cargo Vehicle Staff
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatatuFleetNoModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Matatu/Bus Fleet No
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoFleetNoModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Cargo Vehicle Fleet No 
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatRegModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Register Matatu/Bus 
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoRegModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Register Cargo Vehicle 
               </a><br><br>
               
              
               <a href="table_settings.php" target="_blank" class="col btn btn-secondary m-2 py-3 col-5">
                 <i class="fa fa-eye fs-1" aria-hidden="true"></i><br>
                  View Tables
               </a> 
               <a href="payments.php" class="col btn btn-primary m-2 py-3 col-5">
                 <i class="fa fa-money fs-1" aria-hidden="true"></i><br>
                  View Payments
               </a> 
               <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 
               <!--Add County-->
                <div class="modal fade" id="addCountyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add County</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">County Name</label>
                                    <input type="text" class="form-control" name="county" required>
                                </div>

						                    <div class="modal-body">
                                    <label for="county">County Code</label>
                                    <input type="text" class="form-control" name="code" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveCounty" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add County-->
                <!--Start sub County-->
                <div class="modal fade" id="addSubCountyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Sub County</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">County Name</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT county FROM counties");
                                    ?>

                                    <select id="county" name="county" onchange="fetchCountyDetails(this.value)">
                                        <option value="">-- Select County --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['county']; ?>"><?= $row['county']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

						        <div class="modal-body">
                                    <label for="county">County Code</label>
                                    <input type="text" class="form-control" name="county_code" id="county_code" readonly>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Sub County</label>
                                    <input type="text" class="form-control" name="subcounty" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveSubCounty" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Subcounty-->
                <!--Start sub County-->
                <div class="modal fade" id="addWardModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Ward</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">County Name</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT county FROM counties");
                                    ?>

                                    <select id="county" name="county" onchange="fetchSubCountyDetails(this.value)">
                                        <option value="">-- Select County --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['county']; ?>"><?= $row['county']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

						       

                                <div class="modal-body">
                                    <label for="county">Sub County</label>
                                    <input type="text" class="form-control" name="subcounty" id="subcounty" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Ward</label>
                                    <input type="text" class="form-control" name="ward" id="ward" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveWard" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Subcounty-->
                <!--Add Company-->
                <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Company Name</label>
                                    <input type="text" class="form-control" name="co" required>
                                </div>

						                   
                                <div class="modal-footer">
                                    <button type="submit" name="saveCo" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Company-->
                <!--Add Sacco-->
                <div class="modal fade" id="addSaccoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Sacco</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco Name</label>
                                    <input type="text" class="form-control" name="sacco" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="saveSacco" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Sacco-->
                <!--Add Evewnt-->

                <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Event </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Event Name</label>
                                    <input type="text" class="form-control" name="event" required>
                                </div>

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveEvent" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!--End Add Evewnt-->

                <!--Add Event Details-->
                <div class="modal fade" id="addEventDetailsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Event Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Event Name</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT event_name FROM event");
                                    ?>

                                    <select id="event" name="event" >
                                        <option value="">-- Select Event --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['event_name']; ?>"><?= $row['event_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Event Venue</label>
                                    <input type="text" class="form-control" name="venue" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Event Date</label>
                                    <input type="date" class="form-control" name="e_date" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Event Time</label>
                                    <input type="text" class="form-control" name="e_time" required>
                                </div>

                                <div class="modal-header">
                                    <h5 class="modal-title"><center>Event Prices</center></h5>
                                    
                                </div>
                                <div class="modal-body">
                                    <label for="county">Regular Price</label>
                                    <input type="number" class="form-control" name="r_price" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Vip Regular Price </label>
                                    <input type="number" class="form-control" name="vip_r_price" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Vip Price </label>
                                    <input type="number" class="form-control" name="vip_price" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Vvip Regular Price</label>
                                    <input type="number" class="form-control" name="vvip_r_price" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveEventDetails" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Event Details-->

                <!--Add Bus Sacco-->
                <div class="modal fade" id="addBusSaccoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Bus Sacco</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco Name</label>
                                    <input type="text" class="form-control" name="sacco" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="saveBusSacco" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Bus Sacco-->
                 <!--Add Cargo Vrhicles Sacco-->
                <div class="modal fade" id="addCargoSaccoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Cargo Vehicle Sacco</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco Name</label>
                                    <input type="text" class="form-control" name="sacco" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="saveCargoSacco" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Cargo Vrhicles Sacco-->
                <!--Add Chama-->
                <div class="modal fade" id="addChamaModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Chama</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Chama Name</label>
                                    <input type="text" class="form-control" name="Chama" required>
                                </div>

						                    
                                <div class="modal-footer">
                                    <button type="submit" name="saveChama" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Chama-->
                <!--Add Position-->
                <div class="modal fade" id="addPositionModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Position</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Position Name</label>
                                    <input type="text" class="form-control" name="pos" required>
                                </div>

						                   
                                <div class="modal-footer">
                                    <button type="submit" name="savePosition" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Position-->
                <!--Start Add Matatu or Bus Fleet Number-->
                <div class="modal fade" id="addMatatuFleetNoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Matatu/Bus Fleet Number</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco </label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM bus_saccos");
                                    ?>

                                    <select id="sacco" name="sacco" onchange="fetchCountyDetails(this.value)">
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Fleet No</label>
                                    <input type="text" class="form-control" name="fno" required>
                                </div>

						                   
                                <div class="modal-footer">
                                    <button type="submit" name="saveMatFleetNo" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End  Matatu or Bus Fleet Number-->
                <!--Start Add Cargo Vehicle Fleet Number-->
                <div class="modal fade" id="addCargoFleetNoModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Cargo Vehicle Fleet Number</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM lorry_sacco");
                                    ?>

                                    <select id="sacco" name="sacco" onchange="fetchCountyDetails(this.value)">
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Fleet No</label>
                                    <input type="text" class="form-control" name="fno" required>
                                </div>

						                   
                                <div class="modal-footer">
                                    <button type="submit" name="saveCargoFleetNo" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Cargo Vehicle Fleet Number-->
                <!--Start Add Mat Staff-->
                <div class="modal fade" id="addMatStaffModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Matatus or Bus Staff</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">First Name</label>
                                    <input type="text" class="form-control" name="fname" id="fname" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Middle Name</label>
                                    <input type="text" class="form-control" name="mname" id="mname" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Last Name</label>
                                    <input type="text" class="form-control" name="lname" id="lname" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Phone Number </label>
                                    <input type="text" class="form-control" name="phoneno" id="phoneno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Id No </label>
                                    <input type="text" class="form-control" name="idno" id="idno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM fleet_no");
                                    ?>

                                    <select id="sacco" name="sacco" onchange="fetchSaccoFleetnoDetails(this.value)">
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

						       

                                <div class="modal-body">
                                    <label for="county">Fleet No</label>
                                    <input type="text" class="form-control" name="fleetno" id="fleetno" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Matatu/Bus Name/Reg No</label>
                                    <input type="text" class="form-control" name="matname" id="matname" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Position</label>
                                    
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT position FROM positions");
                                    ?>

                                    <select id="position" name="position" >
                                        <option value="">-- Select Position --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['position']; ?>"><?= $row['position']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveMatStaff" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Mat Staff-->

                <!--Start Add Mat Registration-->
                <div class="modal fade" id="addMatRegModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Register Matatu/Bus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM fleet_no");
                                    ?>

                                    <select id="trasacco" name="trasacco" onchange="fetchSaccoFtnoDetails(this.value)">
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Fleet No</label>
                                    <input type="text" class="form-control" name="fleet_no" id="fleet_no" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Matatu/Bus Name</label>
                                    <input type="text" class="form-control" name="matname" id="matname" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Reg No</label>
                                    <input type="text" class="form-control" name="regno" id="regno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Privy</label>
                                    <input type="text" class="form-control" name="privy" id="privy" required>
                                </div>

                                 <div class="modal-body">
                                    <label for="county">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="saveRegMatBus" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Mat Registration-->

                <!--Start Add Lorry Staff-->
               

                <div class="modal fade" id="addCargoStaffModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Cargo Vehicle Staff</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">First Name</label>
                                    <input type="text" class="form-control" name="fname" id="fname" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Middle Name</label>
                                    <input type="text" class="form-control" name="mname" id="mname" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Last Name</label>
                                    <input type="text" class="form-control" name="lname" id="lname" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Phone Number </label>
                                    <input type="text" class="form-control" name="phoneno" id="phoneno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Id No </label>
                                    <input type="text" class="form-control" name="idno" id="idno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM lorry_fleet_no");
                                    ?>

                                    <select id="cargosacco" name="cargosacco" onchange="fetchCargoVehicleFtnoDetails(this.value)">
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

						       

                                <div class="modal-body">
                                    <label for="county">Fleet No</label>
                                    <input type="text" class="form-control" name="fleet_no" id="fleet_no" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Vehicle Name/Reg No</label>
                                    <input type="text" class="form-control" name="lorryname" id="lorryname" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Position</label>
                                    
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT position FROM positions");
                                    ?>

                                    <select id="position" name="position" >
                                        <option value="">-- Select Position --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['position']; ?>"><?= $row['position']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveCargoStaff" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Rnd Add Lorry Staff-->

                <!--Start Add Lorry Registration-->
                <div class="modal fade" id="addCargoRegModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Register Cargo Vehicle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Sacco Name</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM lorry_fleet_no");
                                    ?>

                                    <select id="cargo_sacco" name="cargo_sacco" onchange="fetchCargoTransFtnoDetails(this.value)">
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

						       

                                <div class="modal-body">
                                    <label for="county">Fleet No</label>
                                    <input type="text" class="form-control" name="fleet_number" id="fleet_number" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Vehicle Name</label>
                                    <input type="text" class="form-control" name="lorryname" id="lorryname" required>
                                </div>

                                <div class="modal-body">
                                    <label for="county">Reg No</label>
                                    <input type="text" class="form-control" name="regno" id="regno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Privy</label>
                                    <input type="text" class="form-control" name="privy" id="privy" required>
                                </div>

                                 <div class="modal-body">
                                    <label for="county">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="saveRegCargoVehicle" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Lorry Registration-->
                 <!--Add Policy-->
                <div class="modal fade" id="addPolicyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Insurance Policy</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Policy Name</label>
                                    <input type="text" class="form-control" name="policy" required>
                                </div>

						        
                                <div class="modal-footer">
                                    <button type="submit" name="savePolicy" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Policy-->

                 <!--Add Principle-->
                <div class="modal fade" id="addPrinciplesModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Insurance Principle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Principle Name</label>
                                    <input type="text" class="form-control" name="principle" required>
                                </div>

						        
                                <div class="modal-footer">
                                    <button type="submit" name="savePrinciple" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Principle-->

                 <!--Add Insurance Member-->
                <div class="modal fade" id="addInsuranceMembersModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Insurance Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">First Name</label>
                                    <input type="text" class="form-control" name="fn" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Middle Name</label>
                                    <input type="text" class="form-control" name="mn" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Last Name</label>
                                    <input type="text" class="form-control" name="ln" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">ID No</label>
                                    <input type="text" class="form-control" name="idno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Email Address</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                 <div class="modal-body">
                                    <label for="county">Risk</label>
                                    <!--risk to be converted to select-->
                                    <input type="text" class="form-control" name="risk" required> 
                                </div>
                                <div class="modal-body">
                                    <label for="county">Coverage</label>
                                    <input type="text" class="form-control" name="covarage" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Policy</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT policy FROM insurance_policies");
                                    ?>

                                    <select id="policy" name="policy" >
                                        <option value="">-- Select Policy --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['policy']; ?>"><?= $row['policy']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Principle</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT principle FROM insurance_principles");
                                    ?>

                                    <select id="principle" name="principle" >
                                        <option value="">-- Select Principle --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['principle']; ?>"><?= $row['principle']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                
                                <div class="modal-body">
                                    <label for="county">Premium</label>
                                    <input type="number" class="form-control" name="premium" required>
                                </div>

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveInsuranceMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Imsurance Members-->

                <!--Add Sacco Member-->
                <div class="modal fade" id="addSaccoMembersModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Sacco Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">First Name</label>
                                    <input type="text" class="form-control" name="fn" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Middle Name</label>
                                    <input type="text" class="form-control" name="mn" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Last Name</label>
                                    <input type="text" class="form-control" name="ln" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">ID No</label>
                                    <input type="text" class="form-control" name="idno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Email Address</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                 
                                <div class="modal-body">
                                    <label for="county">Sacco</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT sacco FROM saccos");
                                    ?>

                                    <select id="sacco" name="sacco" >
                                        <option value="">-- Select Sacco --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['sacco']; ?>"><?= $row['sacco']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="saveSaccoMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Sacco Members-->

                <!--Add Chama Member-->
                <div class="modal fade" id="addChamaMembersModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="addsettings.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Chama Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="county">First Name</label>
                                    <input type="text" class="form-control" name="fn" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">Middle Name</label>
                                    <input type="text" class="form-control" name="mn" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Last Name</label>
                                    <input type="text" class="form-control" name="ln" required>
                                </div>

						        <div class="modal-body">
                                    <label for="county">ID No</label>
                                    <input type="text" class="form-control" name="idno" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                                <div class="modal-body">
                                    <label for="county">Email Address</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                 
                                <div class="modal-body">
                                    <label for="county">Chama</label>
                                    <?php
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Chama Members-->
                

             </div>
         </div>
     </div>

     
               


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(1) a").addClass('active');
        });
    </script>

    
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['msg']) && $_GET['msg']=="success"): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Success',
  text: 'Data inserted successfully!'
})
</script>
<?php elseif(isset($_GET['msg']) && $_GET['msg']=="error"): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong while inserting!'
})
</script>
<?php elseif(isset($_GET['msg']) && $_GET['msg']=="warning"): ?>
<script>
Swal.fire({
  icon: 'warning',
  title: 'Update',
  text: 'Data Updated Successful!'
})
</script>
<?php endif; ?>

</body>
</html>
