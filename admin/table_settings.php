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

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#SaccoTableModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Saccos
               </a> 

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#MatSaccoTableModal">
                 <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Matatu Saccos
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#CargoSaccoTableModal">
                 <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Cargo Vehicles Saccos
               </a>
               
               <a href="" 
                    class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#CountiesTableModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Counties
                </a> 

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#SubCountyTableModal">
                 <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                   Sub Counties
               </a> 

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#WardTableModal">
                 <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                  Wards
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#ChamaTableModal">
                 <i class="fa fa-cubes fs-1" aria-hidden="true"></i><br>
                  Chamas 
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#EventsTableModal">
                 <i class="fa fa-folder-open fs-1" aria-hidden="true"></i><br>
                  Events
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#MatStaffTableModal">
                 <i class="fa fa-group fs-1" aria-hidden="true"></i><br>
                  Sacco Members
               </a> 

                
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#MatStaffTableModal">
                 <i class="fa fa-group fs-1" aria-hidden="true"></i><br>
                  Bus/Matatu Staff
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3"  data-bs-toggle="modal" data-bs-target="#CargoStaffTableModal">
                 <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                  Cargo Vehicles Staff
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3"  data-bs-toggle="modal" data-bs-target="#MatFleetsTableModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                   Matatu/Bus Fleet Numbers
               </a>
               
               <a href="" class="col btn btn-dark m-2 py-3"  data-bs-toggle="modal" data-bs-target="#CargoFleetTableModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                   Cargo Vehicles Fleet Numbers
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#RegMatTableModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Registered Matatu/Bus 
               </a> 
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#RegCargoTableModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Registered Cargo Vehicle 
               </a><br><br>

               <a href="" class="col btn btn-primary m-2 py-3 col-5">
                 <i class="fa fa-eye" aria-hidden="true"></i><br>
                  VIEW TABLES
               </a> 
               <a href="../logout.php" class="col btn btn-warning m-2 py-3 col-5">
                 <i class="fa fa-sign-out fs-1" aria-hidden="true"></i><br>
                  Logout
               </a> 

               <!-- Start County Table Modal -->
                <div class="modal fade" id="CountiesTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>Counties List</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="countiesTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>County</th><th>Code</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM counties ORDER BY county_code DESC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['county'] ?></td>
                                                <td><?= $row['county_code'] ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['county'] ?>"
                                                        data-code="<?= $row['county_code'] ?>">✏ Update</button>
                  
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
                <!-- End County Table Modal-->

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

                <!-- Start Sacco Table Modal -->
                <div class="modal fade" id="SaccoTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Saccos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="saccosTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM saccos ORDER BY id DESC");
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
                <!-- End Sacco Table Modal-->

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

                 <!-- Start Sub County Table Modal -->
                <div class="modal fade" id="SubCountyTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Sub Counties</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="subcountiesTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>County</th><th>County Code</th><th>Sub County</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM sub_counties ORDER BY sub_county ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['county'] ?></td><td><?= $row['countycode'] ?></td><td><?= $row['sub_county'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['county'] ?>"
                                                        data-county="<?= $row['countycode'] ?>"
                                                        data-county="<?= $row['sub_county'] ?>"
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
                <!-- End Sub County Table Modal-->

                <!-- Start Cargo Sacco Table Modal -->
                <div class="modal fade" id="CargoSaccoTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Cargo Vehicles</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="cargosaccosTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Sacco</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM lorry_sacco ORDER BY id DESC");
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
                <!-- End Cargo Sacco Table Modal-->

                <!-- Start Ward Table Modal -->
                <div class="modal fade" id="WardTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Cargo Vehicles</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="wardTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>County</th><th>Sub County</th><th>Ward</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM wards ORDER BY ward DESC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['county'] ?></td>
                                                <td><?= $row['subcounty'] ?></td>
                                                <td><?= $row['ward'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['county'] ?>"
                                                        data-county="<?= $row['subcounty'] ?>"
                                                        data-county="<?= $row['ward'] ?>"
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
                <!-- End Ward Table Modal-->
                 <!-- Start Ward Table Modal -->
                <div class="modal fade" id="ChamaTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Chamas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="chamaTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Chama</th><th>Actions</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM chamas ORDER BY chama_name DESC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['chama_name'] ?></td>
                                               
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['chama_name'] ?>"
                                                        
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
                <!-- End Ward Table Modal-->
                 <!-- Start Events Table Modal -->
                <div class="modal fade" id="EventsTableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header"><h5>List of Events</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                                <div class="modal-body">
                                    <table  id="eventsTable" class="table table-bordered ">
                                        <thead>
                                            <tr><th>Event</th><th>Venue</th><th>Date</th><th>Time</th><th>Regular</th><th>vip_Regular</th><th>vip</th><th>vvip_regular</th><th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $result = $conn->query("SELECT * FROM events ORDER BY date DESC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['event'] ?></td>
                                                <td><?= $row['venue'] ?></td>
                                                <td><?= $row['date'] ?></td>
                                                <td><?= $row['time'] ?></td>
                                                <td><?= $row['regular_price'] ?></td>
                                                <td><?= $row['vip_regular_price'] ?></td>
                                                <td><?= $row['vip_price'] ?></td>
                                                <td><?= $row['vvip_regular'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['event'] ?>"
                                                        data-county="<?= $row['venue'] ?>"
                                                        data-county="<?= $row['date'] ?>"
                                                        data-county="<?= $row['time'] ?>"
                                                        data-county="<?= $row['regular_price'] ?>"
                                                        data-county="<?= $row['vip_regular_price'] ?>"
                                                        data-county="<?= $row['vip_price'] ?>"
                                                        data-county="<?= $row['vvip_regular'] ?>"
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
                <!-- End Events Table Modal-->
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
                                        $result = $conn->query("SELECT * FROM mat_staff ORDER BY position ASC");
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
                                        $result = $conn->query("SELECT * FROM lorry_staff ORDER BY position ASC");
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
                                                <td><?= $row['lorry_name'] ?></td>
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
                                                        data-county="<?= $row['lorry_name'] ?>"
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
                                        $result = $conn->query("SELECT * FROM fleet_no ORDER BY sacco ASC");
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
                 <!-- Start Matatu Staff Table Modal -->
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
                                        $result = $conn->query("SELECT * FROM lorry_fleet_no ORDER BY sacco ASC");
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
                                        $result = $conn->query("SELECT * FROM mat_registration ORDER BY sacco ASC");
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
                                        $result = $conn->query("SELECT * FROM lorry_registration ORDER BY sacco ASC");
                                        while($row=$result->fetch_assoc()): 
                                         ?>
                                            <tr>
                                                <td><?= $row['sacco'] ?></td>
                                                <td><?= $row['fleet_no'] ?></td>
                                                <td><?= $row['reg_no'] ?></td>
                                                <td><?= $row['privy'] ?></td>
                                                <td><?= $row['phone_number'] ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-warning btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                                        data-id="<?= $row['id'] ?>"
                                                        data-county="<?= $row['sacco'] ?>"
                                                        data-county="<?= $row['fleet_no'] ?>"
                                                        data-county="<?= $row['reg_no'] ?>"
                                                        data-county="<?= $row['privy'] ?>"
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
                <!-- End Registered Cargo Vehicle Table Modal-->

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
                                        $result = $conn->query("SELECT * FROM insurance_members ORDER BY policy ASC");
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

                <!-- Start Chama Members Staff Table Modal -->
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
                                        $result = $conn->query("SELECT * FROM lorry_staff ORDER BY position ASC");
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
                                                <td><?= $row['lorry_name'] ?></td>
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
                                                        data-county="<?= $row['lorry_name'] ?>"
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
                <!-- End Chama Members Table Modal-->

                <!-- Start Sacco Members Staff Table Modal -->
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
                                        $result = $conn->query("SELECT * FROM lorry_staff ORDER BY position ASC");
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
                                                <td><?= $row['lorry_name'] ?></td>
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
                                                        data-county="<?= $row['lorry_name'] ?>"
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
                <!-- End Sacco Members Table Modal-->

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
<!--Start County Table-->
<script>
    $(document).ready(function() {
        $('#CountiesTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#countiesTable')) {
                $('#countiesTable').DataTable({
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
                $('#countiesTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End County Table-->

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

<!--Start Sacco Table-->
<script>
    $(document).ready(function() {
        $('#SaccoTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#saccosTable')) {
                $('#saccosTable').DataTable({
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
                $('#saccosTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Sacco Table-->

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
<!--Start Sub Counties Table-->
<script>
    $(document).ready(function() {
        $('#SubCountyTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#subcountiesTable')) {
                $('#subcountiesTable').DataTable({
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
                $('#subcountiesTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Sub Counties Table-->
<!--Start Ward Table-->
<script>
    $(document).ready(function() {
        $('#WardTableModal').on('shown.bs.modal', function () {
            if (!$.fn.DataTable.isDataTable('#wardTable')) {
                $('#wardTable').DataTable({
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
                $('#wardTable').DataTable().columns.adjust().draw();
            }
        });
    });
</script>
<!--End Ward Table-->
<!--Start Chamas Table-->
<script>
    $(document).ready(function() {
        $('#ChamaTableModal').on('shown.bs.modal', function () {
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
<!--End chamas Table-->
<!--Start events Table-->
<script>
    $(document).ready(function() {
        $('#EventsTableModal').on('shown.bs.modal', function () {
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
<!--End events Table-->
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
