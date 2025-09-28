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
        include "inc/chamanav.php";
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
