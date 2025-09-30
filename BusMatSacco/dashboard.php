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
        include "nav.php";
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
              

               
                
                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addBusSaccoModal">
                    <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Add Bus Matatus Sacco
                </a>

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatatuFleetNoModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Matatu/Bus Fleet No
                </a> 
                
                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatRegModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Register Matatu/Bus 
               </a> 

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatStaffModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Matatu/Bus Staff
               </a> 

               
               
               <br><br>
               
              
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
