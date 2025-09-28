<?php 
session_start();
include('../connection.php');
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
        include "inc/nav.php";
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
              

               
                
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addEventModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Event
               </a> 

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addEventDetailsModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Event Details
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
