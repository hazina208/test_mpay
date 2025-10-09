<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "../DB_connection.php";
if(empty($_SESSION['id']))
{
    header('location:../login.php');
}
?>
<?php include "inc/tables_header.php"; ?>
<body>
    <?php include "nav.php"; ?> 
  
    <div class="container mt-5">
        <div class="container text-center">
      
            <div class="row row-cols-6">
               

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#CargoSaccoTableModal">
                    <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Cargo Vehicles Saccos
                </a> 

                <a href="" class="col btn btn-dark m-2 py-3"  data-bs-toggle="modal" data-bs-target="#CargoStaffTableModal">
                    <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Cargo Vehicles Staff
                </a> 

                <a href="" class="col btn btn-dark m-2 py-3"  data-bs-toggle="modal" data-bs-target="#CargoFleetTableModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                   Cargo Vehicles Fleet Numbers
                </a>

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#RegCargoTableModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Registered Cargo Vehicle 
                </a>
               
               
               <br><br>

               <a href="" class="col btn btn-primary m-2 py-3 col-5">
                 <i class="fa fa-eye" aria-hidden="true"></i><br>
                  VIEW TABLES
               </a> 
               <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 

                <!-- Start Cargo Sacco Table Modal -->
                <div class="modal fade" id="CargoSaccoTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Cargo Saccos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="cargosaccosTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $stmt = $conn->prepare("SELECT * FROM lorry_sacco ORDER BY id DESC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['sacco']) ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>"
                                                        data-county="<?= htmlspecialchars($row['sacco']) ?>"
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
                <!-- End Cargo Sacco Table Modal-->

                <!-- Start Cargo Vehicle Staff Table Modal -->
                <div class="modal fade" id="CargoStaffTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Cargo Vehicle Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="cargostaffTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Phone</th><th>ID No</th><th>Sacco</th><th>Fleet_no</th><th>No Plate/Vehicle Name</th><th>Position</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                            $co = trim($_POST['entity_name'] ?? '');
                                            $stmt = $conn->prepare("SELECT * FROM lorry_staff WHERE sacco= '$co' ORDER BY position ASC");
                                            $stmt->execute();
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchats($row['first_name']) ?></td>
                                                    <td><?= htmlspecialchats($row['middle_name']) ?></td>
                                                    <td><?= htmlspecialchats($row['last_name']) ?></td>
                                                    <td><?= htmlspecialchats($row['phone']) ?></td>
                                                    <td><?= htmlspecialchats($row['id_no']) ?></td>
                                                    <td><?= htmlspecialchats($row['sacco']) ?></td>
                                                    <td><?= htmlspecialchats($row['fleet_no']) ?></td>
                                                    <td><?= htmlspecialchats($row['lorry_name']) ?></td>
                                                    <td><?= htmlspecialchats($row['position']) ?></td>
                                                
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#updateModal"
                                                            data-id="<?= htmlspecialchats($row['id']) ?>"
                                                            data-county="<?= htmlspecialchats($row['first_name']) ?>"
                                                            data-county="<?= htmlspecialchats($row['middle_name']) ?>"
                                                            data-county="<?= htmlspecialchats($row['last_name']) ?>"
                                                            data-county="<?= htmlspecialchats($row['phone']) ?>"
                                                            data-county="<?= htmlspecialchats($row['id_no']) ?>"
                                                            data-county="<?= htmlspecialchats($row['sacco']) ?>"
                                                            data-county="<?= htmlspecialchats($row['fleet_no']) ?>"
                                                            data-county="<?= htmlspecialchats($row['mat_name']) ?>"
                                                            data-county="<?= htmlspecialchats($row['position']) ?>"
                                                            >✏ Update</button>
                  
                                                        <button class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                            data-id="<?= htmlspecialchats($row['id']) ?>">🗑 Delete</button>
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
                <!-- End Cargo Staff Table Modal-->

                 <!-- Start Cargo Staff Table Modal -->
                <div class="modal fade" id="CargoFleetTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5> List of Cargo Vehicle Fleet Numbers</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="cargofleetTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Fleet Number</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $co = trim($_POST['entity_name'] ?? '');
                                        $stmt = $conn->prepare("SELECT * FROM lorry_fleet_no WHERE sacco= '$co' ORDER BY sacco ASC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['sacco']) ?></td>
                                                <td><?= htmlspecialchars($row['fleet_no']) ?></td>
                                                
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>"
                                                        data-county="<?= htmlspecialchars($row['sacco']) ?>"
                                                        data-county="<?= htmlspecialchars($row['fleet_no']) ?>"
                                                        
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
                <!-- End Cargo Staff Table Modal-->

                 <!-- Start Registered Cargo Vehicle  Table Modal -->
                 <div class="modal fade" id="RegCargoTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Registered Cargo Vehicles</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="regcargoTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Fleet_No</th><th>No plate</th><th>Privy</th><th>Phone Number</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        try {
                                        $co = trim($_POST['entity_name'] ?? '');
                                        $stmt = $conn->prepare("SELECT * FROM lorry_registration WHERE sacco= '$co' ORDER BY sacco ASC");
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['sacco']) ?></td>
                                                <td><?= htmlspecialchars($row['fleet_no']) ?></td>
                                                <td><?= htmlspecialchars($row['reg_no']) ?></td>
                                                <td><?= htmlspecialchars($row['privy']) ?></td>
                                                <td><?= htmlspecialchars($row['phone_number']) ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>"
                                                        data-county="<?= htmlspecialchars($row['sacco']) ?>"
                                                        data-county="<?= htmlspecialchars($row['fleet_no']) ?>"
                                                        data-county="<?= htmlspecialchars($row['reg_no']) ?>"
                                                        data-county="<?= htmlspecialchars($row['privy']) ?>"
                                                        data-county="<?= htmlspecialchars($row['phone_number']) ?>"
                                                     
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
                <!-- End Registered Cargo Vehicle Table Modal-->
                
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

<!-- DataTables Initialization -->

<!--Start Cargo Sacco Table-->
<script>
    $(document).ready(function() {
        $('#CargoSaccoTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#cargosaccosTable')) {
                $('#cargosaccosTable').DataTable({
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
                $('#cargosaccosTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Cargo Sacco Table-->

<!--Start cargo staff Table-->
<script>
    $(document).ready(function() {
        $('#CargoStaffTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#cargostaffTable')) {
                $('#cargostaffTable').DataTable({
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
                $('#cargostaffTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End cargo staff Table-->

<!--Start Cargo Fleet Numbers Table-->
<script>
    $(document).ready(function() {
        $('#RegCargoTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#regcargoTable')) {
                $('#regcargoTable').DataTable({
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
                $('#regcargoTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End cargo vehicle Fleet Numbers Table-->

<!--Start Register Cargo Fleet  Table-->
<script>
    $(document).ready(function() {
        $('#RegCargoTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#regcargoTable')) {
                $('#regcargoTable').DataTable({
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
                $('#regcargoTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Register cargo vehicle  Table-->





<!-- Ensure DataTables elements are visible -->
<style>
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_paginate,
    .dataTables_wrapper .dt-buttons {
        display: block !important;
        visibility: visible !important;
    }
</style>

</body>
</html>