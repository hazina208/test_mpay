<?php
ob_start(); // Buffer output to prevent "headers already sent"
session_start();
// Include database connection
include "../DB_connection.php"; // Adjusted path to reach /var/www/html/

// Redirect if not logged in
if (empty($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "inc/header.php"; ?>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <div class="container text-center">
            <?php if (isset($_SESSION['status']) && $_SESSION['status'] != ''): ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong> <?php echo htmlspecialchars($_SESSION['status']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['status']); // Clear status after displaying ?>
            <?php endif; ?>

            <div class="row row-cols-5">
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Add Insurance Company
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addPolicyModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Add Insurance Policy
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addPrinciplesModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Add Insurance Principle
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addInsuranceMembersModal">
                    <i class="fa fa-user-md fs-1" aria-hidden="true"></i><br>
                    Add Insurance Member
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSaccoModal">
                    <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                    Add Sacco
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSaccoMembersModal">
                    <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                    Add Sacco Members
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addBusSaccoModal">
                    <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                    Add Bus Matatus Sacco
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoSaccoModal">
                    <i class="fa fa-graduation-cap fs-1" aria-hidden="true"></i><br>
                    Add Lorries Sacco
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                    <i class="fa fa-pencil-square fs-1" aria-hidden="true"></i><br>
                    Add Position
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCountyModal">
                    <i class="fa fa-cubes fs-1" aria-hidden="true"></i><br>
                    Add County
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSubCountyModal">
                    <i class="fa fa-folder-open fs-1" aria-hidden="true"></i><br>
                    Add Sub County
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addWardModal">
                    <i class="fa fa-group fs-1" aria-hidden="true"></i><br>
                    Add Ward
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChamaModal">
                    <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                    Add Chama
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChamaMembersModal">
                    <i class="fa fa-institution fs-1" aria-hidden="true"></i><br>
                    Add Chama Members
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Add Event
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addEventDetailsModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Add Event Details
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatStaffModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Add Matatu/Bus Staff
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoStaffModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Add Cargo Vehicle Staff
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatatuFleetNoModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Add Matatu/Bus Fleet No
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoFleetNoModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Add Cargo Vehicle Fleet No
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addMatRegModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Register Matatu/Bus
                </a>
                <a href="#" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addCargoRegModal">
                    <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                    Register Cargo Vehicle
                </a>
                <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addInstitutionRegModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Institution 
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add School 
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addDenomRegModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Denomination 
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addChurchModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Church 
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addBusTypeModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Business Type 
               </a>

               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addBusinessModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Business 
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addHosiTypeModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Add Hospital Type 
               </a>
               <a href="" class="col btn btn-dark m-2 py-3" data-bs-toggle="modal" data-bs-target="#addHospitalRegModal">
                 <i class="fa fa-paw fs-1" aria-hidden="true"></i><br>
                  Register Hospital 
               </a><br><br>
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
            </div>
        </div>

        <!-- Add County Modal -->
        <div class="modal fade" id="addCountyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add County</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="county">County Name</label>
                            <input type="text" class="form-control" name="county" required>
                        </div>
                        <div class="modal-body">
                            <label for="code">County Code</label>
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

        <!-- Add Sub County Modal -->
        <div class="modal fade" id="addSubCountyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Sub County</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="county">County Name</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT county FROM counties");
                                $stmt->execute();
                                $counties = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="county" name="county" onchange="fetchCountyDetails(this.value)">
                                <option value="">-- Select County --</option>
                                <?php foreach ($counties as $row): ?>
                                    <option value="<?= htmlspecialchars($row['county']); ?>"><?= htmlspecialchars($row['county']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching counties: " . $e->getMessage());
                                echo '<p>Error loading counties. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="county_code">County Code</label>
                            <input type="text" class="form-control" name="county_code" id="county_code" readonly>
                        </div>
                        <div class="modal-body">
                            <label for="subcounty">Sub County</label>
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

        <!-- Add Ward Modal -->
        <div class="modal fade" id="addWardModal" tabindex="-1" aria-hidden="true">
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
                            try {
                                $stmt = $conn->prepare("SELECT county FROM counties");
                                $stmt->execute();
                                $counties = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="county" name="county" onchange="fetchSubCountyDetails(this.value)">
                                <option value="">-- Select County --</option>
                                <?php foreach ($counties as $row): ?>
                                    <option value="<?= htmlspecialchars($row['county']); ?>"><?= htmlspecialchars($row['county']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching counties: " . $e->getMessage());
                                echo '<p>Error loading counties. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="subcounty">Sub County</label>
                            <input type="text" class="form-control" name="subcounty" id="subcounty" required>
                        </div>
                        <div class="modal-body">
                            <label for="ward">Ward</label>
                            <input type="text" class="form-control" name="ward" id="ward" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveWard" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Company Modal -->
        <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Company</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="co">Company Name</label>
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

        <!-- Add Sacco Modal -->
        <div class="modal fade" id="addSaccoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Sacco</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco Name</label>
                            <input type="text" class="form-control" name="sacco" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveSacco" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Event Modal -->
        <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="event">Event Name</label>
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

        <!-- Add Event Details Modal -->
        <div class="modal fade" id="addEventDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="event">Event Name</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT event_name FROM event");
                                $stmt->execute();
                                $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="event" name="event">
                                <option value="">-- Select Event --</option>
                                <?php foreach ($events as $row): ?>
                                    <option value="<?= htmlspecialchars($row['event_name']); ?>"><?= htmlspecialchars($row['event_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching events: " . $e->getMessage());
                                echo '<p>Error loading events. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="venue">Event Venue</label>
                            <input type="text" class="form-control" name="venue" required>
                        </div>
                        <div class="modal-body">
                            <label for="e_date">Event Date</label>
                            <input type="date" class="form-control" name="e_date" required>
                        </div>
                        <div class="modal-body">
                            <label for="e_time">Event Time</label>
                            <input type="text" class="form-control" name="e_time" required>
                        </div>
                        <div class="modal-header">
                            <h5 class="modal-title"><center>Event Prices</center></h5>
                        </div>
                        <div class="modal-body">
                            <label for="r_price">Regular Price</label>
                            <input type="number" class="form-control" name="r_price" required>
                        </div>
                        <div class="modal-body">
                            <label for="vip_r_price">VIP Regular Price</label>
                            <input type="number" class="form-control" name="vip_r_price" required>
                        </div>
                        <div class="modal-body">
                            <label for="vip_price">VIP Price</label>
                            <input type="number" class="form-control" name="vip_price" required>
                        </div>
                        <div class="modal-body">
                            <label for="vvip_r_price">VVIP Regular Price</label>
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
        <!-- Add Bus Sacco Modal -->
        <div class="modal fade" id="addBusSaccoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Bus Sacco</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco Name</label>
                            <input type="text" class="form-control" name="sacco" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveBusSacco" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Cargo Sacco Modal -->
        <div class="modal fade" id="addCargoSaccoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Cargo Vehicle Sacco</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco Name</label>
                            <input type="text" class="form-control" name="sacco" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveCargoSacco" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Chama Modal -->
        <div class="modal fade" id="addChamaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Chama</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="Chama">Chama Name</label>
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

        <!-- Add Position Modal -->
        <div class="modal fade" id="addPositionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Position</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="pos">Position Name</label>
                            <input type="text" class="form-control" name="pos" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="savePosition" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Matatu/Bus Fleet Number Modal -->
        <div class="modal fade" id="addMatatuFleetNoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Matatu/Bus Fleet Number</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM bus_saccos");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="sacco" name="sacco" onchange="fetchCountyDetails(this.value)">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="fno">Fleet No</label>
                            <input type="text" class="form-control" name="fno" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveMatFleetNo" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Cargo Vehicle Fleet Number Modal -->
        <div class="modal fade" id="addCargoFleetNoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Cargo Vehicle Fleet Number</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM lorry_sacco");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="sacco" name="sacco" onchange="fetchCountyDetails(this.value)">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching lorry saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="fno">Fleet No</label>
                            <input type="text" class="form-control" name="fno" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveCargoFleetNo" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Matatu/Bus Staff Modal -->
        <div class="modal fade" id="addMatStaffModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Matatu/Bus Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" required>
                        </div>
                        <div class="modal-body">
                            <label for="mname">Middle Name</label>
                            <input type="text" class="form-control" name="mname" id="mname" required>
                        </div>
                        <div class="modal-body">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" required>
                        </div>
                        <div class="modal-body">
                            <label for="phoneno">Phone Number</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" required>
                        </div>
                        <div class="modal-body">
                            <label for="idno">ID No</label>
                            <input type="text" class="form-control" name="idno" id="idno" required>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM fleet_no");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="sacco" name="sacco" onchange="fetchSaccoFleetnoDetails(this.value)">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="fleetno">Fleet No</label>
                            <input type="text" class="form-control" name="fleetno" id="fleetno" required>
                        </div>
                        <div class="modal-body">
                            <label for="matname">Matatu/Bus Name/Reg No</label>
                            <input type="text" class="form-control" name="matname" id="matname" required>
                        </div>
                        <div class="modal-body">
                            <label for="position">Position</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT position FROM positions");
                                $stmt->execute();
                                $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="position" name="position">
                                <option value="">-- Select Position --</option>
                                <?php foreach ($positions as $row): ?>
                                    <option value="<?= htmlspecialchars($row['position']); ?>"><?= htmlspecialchars($row['position']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching positions: " . $e->getMessage());
                                echo '<p>Error loading positions. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveMatStaff" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Matatu/Bus Registration Modal -->
        <div class="modal fade" id="addMatRegModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Register Matatu/Bus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="trasacco">Sacco</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM fleet_no");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="trasacco" name="trasacco" onchange="fetchSaccoFtnoDetails(this.value)">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="fleet_no">Fleet No</label>
                            <input type="text" class="form-control" name="fleet_no" id="fleet_no" required>
                        </div>
                        <div class="modal-body">
                            <label for="matname">Matatu/Bus Name</label>
                            <input type="text" class="form-control" name="matname" id="matname" required>
                        </div>
                        <div class="modal-body">
                            <label for="regno">Reg No</label>
                            <input type="text" class="form-control" name="regno" id="regno" required>
                        </div>
                        <div class="modal-body">
                            <label for="privy">Privy</label>
                            <input type="text" class="form-control" name="privy" id="privy" required>
                        </div>
                        <div class="modal-body">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveRegMatBus" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Cargo Vehicle Staff Modal -->
        <div class="modal fade" id="addCargoStaffModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Cargo Vehicle Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" required>
                        </div>
                        <div class="modal-body">
                            <label for="mname">Middle Name</label>
                            <input type="text" class="form-control" name="mname" id="mname" required>
                        </div>
                        <div class="modal-body">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" required>
                        </div>
                        <div class="modal-body">
                            <label for="phoneno">Phone Number</label>
                            <input type="text" class="form-control" name="phoneno" id="phoneno" required>
                        </div>
                        <div class="modal-body">
                            <label for="idno">ID No</label>
                            <input type="text" class="form-control" name="idno" id="idno" required>
                        </div>
                        <div class="modal-body">
                            <label for="cargosacco">Sacco</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM lorry_fleet_no");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="cargosacco" name="cargosacco" onchange="fetchCargoVehicleFtnoDetails(this.value)">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching lorry saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="fleet_no">Fleet No</label>
                            <input type="text" class="form-control" name="fleet_no" id="fleet_no" required>
                        </div>
                        <div class="modal-body">
                            <label for="lorryname">Vehicle Name/Reg No</label>
                            <input type="text" class="form-control" name="lorryname" id="lorryname" required>
                        </div>
                        <div class="modal-body">
                            <label for="position">Position</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT position FROM positions");
                                $stmt->execute();
                                $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="position" name="position">
                                <option value="">-- Select Position --</option>
                                <?php foreach ($positions as $row): ?>
                                    <option value="<?= htmlspecialchars($row['position']); ?>"><?= htmlspecialchars($row['position']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching positions: " . $e->getMessage());
                                echo '<p>Error loading positions. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveCargoStaff" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Cargo Vehicle Registration Modal -->
        <div class="modal fade" id="addCargoRegModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Register Cargo Vehicle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="cargo_sacco">Sacco Name</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM lorry_fleet_no");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="cargo_sacco" name="cargo_sacco" onchange="fetchCargoTransFtnoDetails(this.value)">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching lorry saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="fleet_number">Fleet No</label>
                            <input type="text" class="form-control" name="fleet_number" id="fleet_number" required>
                        </div>
                        <div class="modal-body">
                            <label for="lorryname">Vehicle Name</label>
                            <input type="text" class="form-control" name="lorryname" id="lorryname" required>
                        </div>
                        <div class="modal-body">
                            <label for="regno">Reg No</label>
                            <input type="text" class="form-control" name="regno" id="regno" required>
                        </div>
                        <div class="modal-body">
                            <label for="privy">Privy</label>
                            <input type="text" class="form-control" name="privy" id="privy" required>
                        </div>
                        <div class="modal-body">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveRegCargoVehicle" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Insurance Policy Modal -->
        <div class="modal fade" id="addPolicyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Insurance Policy</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="policy">Policy Name</label>
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

        <!-- Add Insurance Principle Modal -->
        <div class="modal fade" id="addPrinciplesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Insurance Principle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="principle">Principle Name</label>
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

        <!-- Add Insurance Member Modal -->
        <div class="modal fade" id="addInsuranceMembersModal" tabindex="-1" aria-hidden="true"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Insurance Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="fn">First Name</label>
                            <input type="text" class="form-control" name="fn" required>
                        </div>
                        <div class="modal-body">
                            <label for="mn">Middle Name</label>
                            <input type="text" class="form-control" name="mn" required>
                        </div>
                        <div class="modal-body">
                            <label for="ln">Last Name</label>
                            <input type="text" class="form-control" name="ln" required>
                        </div>
                        <div class="modal-body">
                            <label for="idno">ID No</label>
                            <input type="text" class="form-control" name="idno" required>
                        </div>
                        <div class="modal-body">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="modal-body">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="modal-body">
                            <label for="risk">Risk</label>
                            <input type="text" class="form-control" name="risk" required>
                        </div>
                        <div class="modal-body">
                            <label for="covarage">Coverage</label>
                            <input type="text" class="form-control" name="covarage" required>
                        </div>
                        <div class="modal-body">
                            <label for="policy">Policy</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT policy FROM insurance_policies");
                                $stmt->execute();
                                $policies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="policy" name="policy">
                                <option value="">-- Select Policy --</option>
                                <?php foreach ($policies as $row): ?>
                                    <option value="<?= htmlspecialchars($row['policy']); ?>"><?= htmlspecialchars($row['policy']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching policies: " . $e->getMessage());
                                echo '<p>Error loading policies. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="principle">Principle</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT principle FROM insurance_principles");
                                $stmt->execute();
                                $principles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="principle" name="principle">
                                <option value="">-- Select Principle --</option>
                                <?php foreach ($principles as $row): ?>
                                    <option value="<?= htmlspecialchars($row['principle']); ?>"><?= htmlspecialchars($row['principle']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching principles: " . $e->getMessage());
                                echo '<p>Error loading principles. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-body">
                            <label for="premium">Premium</label>
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

        <!-- Add Sacco Member Modal -->
        <div class="modal fade" id="addSaccoMembersModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Sacco Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="fn">First Name</label>
                            <input type="text" class="form-control" name="fn" required>
                        </div>
                        <div class="modal-body">
                            <label for="mn">Middle Name</label>
                            <input type="text" class="form-control" name="mn" required>
                        </div>
                        <div class="modal-body">
                            <label for="ln">Last Name</label>
                            <input type="text" class="form-control" name="ln" required>
                        </div>
                        <div class="modal-body">
                            <label for="idno">ID No</label>
                            <input type="text" class="form-control" name="idno" required>
                        </div>
                        <div class="modal-body">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="modal-body">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="modal-body">
                            <label for="sacco">Sacco</label>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT sacco FROM saccos");
                                $stmt->execute();
                                $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <select id="sacco" name="sacco">
                                <option value="">-- Select Sacco --</option>
                                <?php foreach ($saccos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['sacco']); ?>"><?= htmlspecialchars($row['sacco']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                            } catch (PDOException $e) {
                                error_log("Error fetching saccos: " . $e->getMessage());
                                echo '<p>Error loading saccos. Please try again later.</p>';
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="saveSaccoMembers" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Chama Member Modal -->
        <div class="modal fade" id="addChamaMembersModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Chama Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="fn">First Name</label>
                            <input type="text" class="form-control" name="fn" required>
                        </div>
                        <div class="modal-body">
                            <label for="mn">Middle Name</label>
                            <input type="text" class="form-control" name="mn" required>
                        </div>
                        <div class="modal-body">
                            <label for="ln">Last Name</label>
                            <input type="text" class="form-control" name="ln" required>
                        </div>
                        <div class="modal-body">
                            <label for="idno">ID No</label>
                            <input type="text" class="form-control" name="idno" required>
                        </div>
                        <div class="modal-body">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="modal-body">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="modal-body">
                            <label for="chama">Chama</label>
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
        <!--Add Business Type-->
        <div class="modal fade" id="addBusTypeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="addsettings.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Business Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="county">Business Type</label>
                            <input type="text" class="form-control" name="county" required>
                        </div>

						        
                        <div class="modal-footer">
                            <button type="submit" name="saveCounty" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End Business Type-->
        <!--Add Institution-->
        <div class="modal fade" id="addInstitutionRegModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Institution-->
                <!--Add School -->
                <div class="modal fade" id="addSchoolModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add School -->
                <!--Add Denomination -->
                <div class="modal fade" id="addDenomRegModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Denomination -->
                <!--Add Church-->
                <div class="modal fade" id="addChurchModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Church-->
                <!--Add Business Type-->
                <div class="modal fade" id="addBusTypeModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Business Type-->
                <!--Add Business-->
                <div class="modal fade" id="addBusinessModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Business-->
                <!--Add Hospital-->
                <div class="modal fade" id="addHosiTypeModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Hospital-->
                 <!--Add Hospital-->
                <div class="modal fade" id="addHospitalRegModal" tabindex="-1" aria-hidden="true">
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
                                    // Database connection
                                    include("../connection.php");
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    // Fetch job numbers for dropdown
                                    $result = $conn->query("SELECT chama_name FROM chamas");
                                    ?>

                                    <select id="chama" name="chama" >
                                        <option value="">-- Select Chama --</option>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['chama_name']; ?>"><?= $row['chama_name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                

						        
                                <div class="modal-footer">
                                    <button type="submit" name="saveChamaMembers" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Add Hospital-->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(1) a").addClass('active');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == "success"): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Data inserted successfully!'
        });
    </script>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == "error"): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong while inserting!'
        });
    </script>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == "warning"): ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Update',
            text: 'Data Updated Successful!'
        });
    </script>
    <?php endif; ?>
</body>
</html>
<?php ob_end_flush(); ?>