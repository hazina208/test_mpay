
<?php 
  include "inc/header.php";
?>
<body>
    <?php 
        include "inc/navbar.php";
     ?>
     <div class="container mt-5">
         <div class="container text-center">
      
            <div class="row row-cols-6">
               <a href="" 
                    class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCountyModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                   Add Counties
               </a> 
			    
		        <div class="modal fade" id="addCountyModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="">
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

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSubCountyModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Add Sub Counties
               </a> 

               <div class="modal fade" id="addSubCountyModal" tabindex="-1" aria-hidden="true">
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
                                    $conn = new mysqli("localhost", "root", "", "school_db");
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

               


  

               <a href="registrar-office.php" class="col btn btn-dark m-2 py-3">
                 <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Wards
               </a> 
               <a href="class.php" class="col btn btn-dark m-2 py-3">
                 <i class="fa fa-cubes fs-1" aria-hidden="true"></i><br>
                  Schools 
               </a> 
               <a href="section.php" class="col btn btn-dark m-2 py-3">
                 <i class="fa fa-folder-open fs-1" aria-hidden="true"></i><br>
                  Lecturers
               </a> 
               <a href="grade.php" class="col btn btn-dark m-2 py-3">
                 <i class="fa fa-group fs-1" aria-hidden="true"></i><br>
                  Parents
               </a> 
               <a href="course.php" class="col btn btn-dark m-2 py-3">
                 <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Universities
               </a> 
               <a href="message.php" class="col btn btn-dark m-2 py-3">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Other Staffs
               </a> 
               <a href="table_settings.php" class="col btn btn-primary m-2 py-3 col-5">
                 <i class="fa fa-eye" aria-hidden="true"></i><br>
                  VIEW TABLES
               </a> 
               <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 
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


<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

        <!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
<script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
<script src="assets/libs/ladda/spin.js"></script>
<script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
<script src="assets/js/pages/loading-btn.init.js"></script>


</body>
</html>
