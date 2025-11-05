<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "../DB_connection.php";
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
               

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#BusSaccoPaymentModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Bus Matatus Payments
               </a>
              
            
        
               

              <br><br>
               
              
               
               <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 



                <!-- Start Bus fare Modal -->
                <div class="modal fade" id="BusSaccoPaymentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Bus Fare Payment Table</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="fareTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Amount</th><th>Fee</th><th>Total</th><th>Phone No</th><th>Transaction ID</th><th>Date</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        try {
                                        $co = trim($__SESSION['entity_name'] ?? '');
                                        $stmt = $conn->prepare("SELECT * FROM bus_fares WHERE sacco= '$co' ORDER BY sacco ASC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                              
                                                <td><?= htmlspecialchars($row['sacco']) ?></td>
                                                <td><?= htmlspecialchars($row['amount']) ?></td>
                                                <td><?= htmlspecialchars($row['fee']) ?></td>
                                                <td><?= htmlspecialchars($row['total']) ?></td>
                                                <td><?= htmlspecialchars($row['phone_number']) ?></td>
                                                <td><?= htmlspecialchars($row['transaction_id']) ?></td>
                                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>"
                                                        data-county="<?= htmlspecialchars($row['sacco']) ?>"
                                                        data-county="<?=htmlspecialchars($row['amount']) ?>"
                                                        data-county="<?= htmlspecialchars($row['fee']) ?>"
                                                        data-county="<?= htmlspecialchars($row['total']) ?>"
                                                        data-county="<?= htmlspecialchars($row['phone_number']) ?>"
                                                        data-county="<?= htmlspecialchars($row['transaction_id']) ?>"
                                                        data-county="<?= htmlspecialchars($row['created_at']) ?>"
                                                        >✏ Update</button>
                  
                                                    <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>">🗑 Delete</button>
                                                </td>
                                            </tr>
                                        <?php 
                                            endwhile;
                                            $stmt = null; // Close statement
                                        } catch (PDOException $e) {
                                        error_log("Error fetching counties: " . $e->getMessage());
                                        // Optionally display a message: echo "<tr><td colspan='3'>Error loading data</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Bus fare Modal-->

      
           
             

                

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

<script>
// Fill Update Modal
var updateModal = document.getElementById('updateModal');
updateModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  document.getElementById('update_id').value = button.getAttribute('data-id');
  document.getElementById('update_county').value = button.getAttribute('data-county');
  document.getElementById('update_code').value = button.getAttribute('data-code');
});

// Fill Delete Modal
var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  document.getElementById('delete_id').value = button.getAttribute('data-id');
});
</script>

<!-- Include JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.js"></script>



<!--Start fare payment Table-->
<script>
    $(document).ready(function() {
        $('#BusSaccoPaymentModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#fareTable')) {
                $('#fareTable').DataTable({
                    pageLength: 10,  // 10 rows per page
                    searching: true,  // Enable search box
                    paging: true,  // Enable pagination
                    info: true,  // Show page info
                    lengthChange: false,  // Disable changing page length
                    dom: 'Bfrtip',  // Position buttons, filter, table, info, pagination
                    buttons: [
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'btn btn-primary btn-sm',
                            exportOptions: {
                                modifier: {
                                    search: 'applied'  // Print only filtered/search results
                                }
                            }
                        }
                    ]
                });
            } else {
                $('#fareTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End fare payment Table-->


</body>
</html>
