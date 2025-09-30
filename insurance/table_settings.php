<?php 
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
if(empty($_SESSION['id']))
{
    header('location:../login.php');
}

?>


<?php include "inc/tables_header.php"; ?>

<body>
    <?php include "inc/navbar.php"; ?> 
  
    <div class="container mt-5">
        <div class="container text-center">
      
            <div class="row row-cols-6">
               
                <a href="" 
                    class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#CompanyTableModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Insurance Companies
                </a> 

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#PoliciesTableModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Insurance Policies
               </a>
               
               <a href="" 
                    class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#PrinciplesTableModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Insurance Principles
                </a> 

                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#InsuranceMembersTableModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Insurance Members
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

           
             
                <!-- Start Company Table Modal -->
                <div class="modal fade" id="CompanyTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Companies</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="companiesTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Company</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM insurance_companies ORDER BY id DESC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['company'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['company'] ?>"
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
                <!-- End Company Table Modal-->

                <!-- Start Insurance Policy  Table Modal -->
                <div class="modal fade" id="PoliciesTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Policies List</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="policiesTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Policy</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM insurance_policies ORDER BY policy ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['policy'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-code="<?= $row['policy'] ?>">✏ Update</button>
                  
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
                <!-- End Insurance Policy Table Modal-->

                <!-- Start Insurance Principle  Table Modal -->
                <div class="modal fade" id="PrinciplesTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Principles List</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="principleTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Insurance Principles</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM insurance_principles ORDER BY principle ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['principle'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-code="<?= $row['principle'] ?>">✏ Update</button>
                  
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
                <!-- End Insurance Principle Table Modal-->

                <!-- Start Insurance Members Table Modal -->
                <div class="modal fade" id="InsuranceMembersTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Insurance Members</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="insurancemembersTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Phone</th><th>ID No</th><th>Email</th><th>Risk</th><th>Coverage</th><th>Principle</th><th>Policy</th><th>Premium</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $co=$mysqli -> real_escape_string($_SESSION['entity_name']);  
                                        $result = $conn->query("SELECT * FROM insurance_members WHERE company= '$co' ORDER BY policy ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['fname'] ?></td>
                                                <td><?= $row['mname'] ?></td>
                                                <td><?= $row['lname'] ?></td>
                                                <td><?= $row['phone'] ?></td>
                                                <td><?= $row['id_no'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><?= $row['risk'] ?></td>
                                                <td><?= $row['coverage'] ?></td>
                                                <td><?= $row['principle'] ?></td>
                                                <td><?= $row['policy'] ?></td>
                                                <td><?= $row['premium'] ?></td>
                                                
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['fname'] ?>"
                                                        data-county="<?= $row['mname'] ?>"
                                                        data-county="<?= $row['lname'] ?>"
                                                        data-county="<?= $row['phone'] ?>"
                                                        data-county="<?= $row['id_no'] ?>"
                                                        data-county="<?= $row['email'] ?>"
                                                        data-county="<?= $row['risk'] ?>"
                                                        data-county="<?= $row['coverage'] ?>"
                                                        data-county="<?= $row['principle'] ?>"
                                                        data-county="<?= $row['policy'] ?>"
                                                        data-county="<?= $row['premium'] ?>"
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
                <!-- End Insurance Members Table Modal-->
                
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

<!--Start Company Table-->
<script>
    $(document).ready(function() {
        $('#CompanyTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#companiesTable')) {
                $('#companiesTable').DataTable({
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
                $('#companiesTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Company Table-->

<!--Start Insurance Policy Table-->
<script>
    $(document).ready(function() {
        $('#PoliciesTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#policiesTable')) {
                $('#policiesTable').DataTable({
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
                $('#policiesTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Insurance Policy Table-->

<!--Start Insurance Principle Table-->
<script>
    $(document).ready(function() {
        $('#PrinciplesTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#principleTable')) {
                $('#principleTable').DataTable({
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
                $('#principleTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Inurance Policy Table-->

<!--Start Insurance Members Table-->
<script>
    $(document).ready(function() {
        $('#InsuranceMembersTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#insurancemembersTable')) {
                $('#insurancemembersTable').DataTable({
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
                $('#insurancemembersTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Insurance Members Table-->



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
