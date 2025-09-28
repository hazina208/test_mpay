<?php 
session_start();
include('../connection.php');
if(empty($_SESSION['id']))
{
    header('location:../login.php');
}

?>

<?php include "tables_header.php"; ?>

<body>
    <?php include "nav.php"; ?> 
  
    <div class="container mt-5">
        <div class="container text-center">
      
            <div class="row row-cols-6">
               

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#MatSaccoTableModal">
                    <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Matatu Saccos
                </a>

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#MatStaffTableModal">
                    <i class="fa fa-group fs-1" aria-hidden="true"></i><br>
                  Bus/Matatu Staff
                </a> 

                <a href="" class="col btn btn-dark m-2 py-3"  data-bs-toggle="modal" data-bs-target="#MatFleetsTableModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                   Matatu/Bus Fleet Numbers
                </a>

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#RegMatTableModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Registered Matatu/Bus 
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

           
                <!-- Start Matatu Sacco Table Modal -->
                <div class="modal fade" id="MatSaccoTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Matatu Saccos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="matatusaccosTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM bus_saccos ORDER BY id DESC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['sacco'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['sacco'] ?>"
                                                        >✏ Update</button>
                  
                                                    <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-id="<?= $row['id'] ?>">🗑 Delete</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Matatu Sacco Table Modal-->

                <!-- Start Matatu Staff Table Modal -->
                <div class="modal fade" id="MatStaffTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Mat/Bus Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="matstaffTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Phone</th><th>ID No</th><th>Sacco</th><th>Fleet_no</th><th>No Plate/Vehicle Name</th><th>Position</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $co=$conn -> real_escape_string($_SESSION['entity_name']);
                                        $result = $conn->query("SELECT * FROM mat_staff WHERE sacco= '$co' ORDER BY position ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['first_name'] ?></td>
                                                <td><?= $row['middle_name'] ?></td>
                                                <td><?= $row['last_name'] ?></td>
                                                <td><?= $row['phone'] ?></td>
                                                <td><?= $row['id_no'] ?></td>
                                                <td><?= $row['sacco'] ?></td>
                                                <td><?= $row['fleet_no'] ?></td>
                                                <td><?= $row['mat_name'] ?></td>
                                                <td><?= $row['position'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['first_name'] ?>"
                                                        data-county="<?= $row['middle_name'] ?>"
                                                        data-county="<?= $row['last_name'] ?>"
                                                        data-county="<?= $row['phone'] ?>"
                                                        data-county="<?= $row['id_no'] ?>"
                                                        data-county="<?= $row['sacco'] ?>"
                                                        data-county="<?= $row['fleet_no'] ?>"
                                                        data-county="<?= $row['mat_name'] ?>"
                                                        data-county="<?= $row['position'] ?>"
                                                        >✏ Update</button>
                  
                                                    <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-id="<?= $row['id'] ?>">🗑 Delete</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Matatu Staff Table Modal-->

                <!-- Start Matatu Staff Table Modal -->
                <div class="modal fade" id="MatFleetsTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Mat/Bus Fleet Numbers</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="matfleetsTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Fleet Number</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $co=$conn -> real_escape_string($_SESSION['entity_name']);
                                        $result = $conn->query("SELECT * FROM fleet_no WHERE sacco= '$co' ORDER BY sacco ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['sacco'] ?></td>
                                                <td><?= $row['fleet_no'] ?></td>
                                                
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['sacco'] ?>"
                                                        data-county="<?= $row['fleet_no'] ?>"
                                                        >✏ Update</button>
                  
                                                    <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-id="<?= $row['id'] ?>">🗑 Delete</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Matatu Staff Table Modal-->

                <!-- Start Registered Matatus Table Modal -->
                <div class="modal fade" id="RegMatTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Registered Matatus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="regmatTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Fleet No</th><th>No Plate</th><th>Privy</th><th>Phone No</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $co=$conn -> real_escape_string($_SESSION['entity_name']);
                                        $result = $conn->query("SELECT * FROM mat_registration WHERE sacco= '$co' ORDER BY sacco ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['sacco'] ?></td>
                                                <td><?= $row['fleet_no'] ?></td>
                                                <td><?= $row['reg_no'] ?></td>
                                                <td><?= $row['contact_person'] ?></td>
                                                <td><?= $row['phone_number'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['sacco'] ?>"
                                                        data-county="<?= $row['fleet_no'] ?>"
                                                        data-county="<?= $row['reg_no'] ?>"
                                                        data-county="<?= $row['contact_person'] ?>"
                                                        data-county="<?= $row['phone_number'] ?>"
                                                      
                                                        >✏ Update</button>
                  
                                                    <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-id="<?= $row['id'] ?>">🗑 Delete</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Registered Matatus Table Modal-->
                
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

<!--Start Matatu Company Table-->
<script>
    $(document).ready(function() {
        $('#MatSaccoTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#matatusaccosTable')) {
                $('#matatusaccosTable').DataTable({
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
                $('#matatusaccosTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Matatu Company Table-->

<!--Start mat staff Table-->
<script>
    $(document).ready(function() {
        $('#MatStaffTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#matstaffTable')) {
                $('#matstaffTable').DataTable({
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
                $('#matstaffTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End mat staff Table-->

<!--Start Mat Fleet Numbers Table-->
<script>
    $(document).ready(function() {
        $('#RegMatTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#regmatTable')) {
                $('#regmatTable').DataTable({
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
                $('#regmatTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Mat Fleet Numbers Table-->

<!--Start Register Mat Fleet Numbers Table-->
<script>
    $(document).ready(function() {
        $('#RegMatTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#regmatTable')) {
                $('#regmatTable').DataTable({
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
                $('#regmatTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Register Mat  Table-->



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
