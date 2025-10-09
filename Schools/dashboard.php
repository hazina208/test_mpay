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
              

               
                
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChamaModal">
                 <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Add Chama
               </a> 

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChamaMembersModal">
                 <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Add Chama Members
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
                                    try {
                                        $stmt = $conn->prepare("SELECT chama_name FROM chamas");
                                        $stmt->execute();
                                        $chamas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <select id="chama" name="chama">
                                        <option value="">-- Select Chama --</option>
                                        <?php foreach ($chamas as $row): ?>
                                            <option value="<?= htmlspecialchars($row['chama_name']); ?>"><?= htmlspecialchars($row['chama_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php
                                    } catch (PDOException $e) {
                                        error_log("Error fetching chamas: " . $e->getMessage());
                                        echo '<p>Error loading chamas. Please try again later.</p>';
                                    }
                                    ?>
                                   
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
