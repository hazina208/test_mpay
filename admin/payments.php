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
                  class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#InsurancePaymentsModal">
                 <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                  Insurance Payments
               </a>

               
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#ChamaPaymentsModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Chama Remittances
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#BusSaccoPaymentModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Bus Matatus Payments
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#CargoSaccoPaymentModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                  Cargo Transport Payments
               </a> 
                
            
               
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#EventPaymentsModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                   Event Tickets Payments
               </a> 

               

              <br><br>
               
              
               
               <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 


               <!-- Start Insurance Table Modal -->
                <div class="modal fade" id="InsurancePaymentsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Insurance Payments Table</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="insuranceTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Serial No</th><th>Company</th><th>Amount</th><th>Fee</th><th>Total</th><th>Phone No</th><th>Transaction ID</th><th>Date</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $stmt = $conn->prepare("SELECT * FROM insurance_payments ORDER BY company ASC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['serial_no']) ?></td>
                                                <td><?= htmlspecialchars($row['company']) ?></td>
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
                                                        data-county="<?= htmlspecialchars($row['serial_no']) ?>"
                                                        data-county="<?= htmlspecialchars($row['company']) ?>"
                                                        data-county="<?= htmlspecialchars($row['amount']) ?>"
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
                <!-- End Insurance Table Modal-->

                <!-- Start chamaTable Modal -->
                <div class="modal fade" id="ChamaPaymentsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Chama Remittances Table</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="chamaTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Serial No</th><th>Chama</th><th>Amount</th><th>Fee</th><th>Total</th><th>Phone No</th><th>Transaction ID</th><th>Date</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $stmt = $conn->prepare("SELECT * FROM chama_payments ORDER BY chama_name ASC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['serial_no']) ?></td>
                                                <td><?= htmlspecialchars($row['chama_name']) ?></td>
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
                                                        data-county="<?= htmlspecialchars($row['serial_no']) ?>"
                                                        data-county="<?= htmlspecialchars($row['company']) ?>"
                                                        data-county="<?= htmlspecialchars($row['amount']) ?>"
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
                <!-- End chamaTable Modal-->

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
                                        $stmt = $conn->prepare("SELECT * FROM bus_fares ORDER BY sacco ASC");
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

                <!-- Start Cargo Payments Modal -->
                <div class="modal fade" id="CargoSaccoPaymentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Cargo Goods Payment Table</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="cargoTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Amount</th><th>Fee</th><th>Total</th><th>Phone No</th><th>Transaction ID</th><th>Date</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $stmt = $conn->prepare("SELECT * FROM cargo_payments ORDER BY sacco ASC");
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
                                                        data-county="<?= htmlspecialchars($row['amount']) ?>"
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
                <!-- End Cargo Payments Modal-->

                   <!-- Start Events Tickets Modal -->
                <div class="modal fade" id="EventPaymentsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Events Tickets Payment Table</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="eventsTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Serial No</th><th>Event</th><th>Amount</th><th>Fee</th><th>Total</th><th>Phone No</th><th>Transaction ID</th><th>Date</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $stmt = $conn->prepare("SELECT * FROM event_payments ORDER BY event ASC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['serial_no']) ?></td>
                                                <td><?= htmlspecialchars($row['event']) ?></td>
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
                                                        data-county="<?= htmlspecialchars($row['serial_no']) ?>"
                                                        data-county="<?= htmlspecialchars($row['event']) ?>"
                                                        data-county="<?= htmlspecialchars($row['amount']) ?>"
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
                <!-- End Events Tickets Modal-->
           
             

                

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

<!--Start insurance payments Table-->
<script>
    $(document).ready(function() {
        $('#InsurancePaymentsModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#insuranceTable')) {
                $('#insuranceTable').DataTable({
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
                $('#insuranceTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End insurance payments Table-->

<!--Start chama remittances Table-->
<script>
    $(document).ready(function() {
        $('#ChamaPaymentsModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#chamaTable')) {
                $('#chamaTable').DataTable({
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
                $('#chamaTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End chama remittances Table-->

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

<!--Start cargo payments Table-->
<script>
    $(document).ready(function() {
        $('#CargoSaccoPaymentModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#cargoTable')) {
                $('#cargoTable').DataTable({
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
                $('#cargoTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End cargo payments Table-->

<!--Start events tickets Table-->
<script>
    $(document).ready(function() {
        $('#EventPaymentsModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#eventsTable')) {
                $('#eventsTable').DataTable({
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
                $('#eventsTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End events tickets Table-->
</body>
</html>
