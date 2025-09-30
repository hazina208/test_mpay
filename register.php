<?php
ob_start(); // Buffer output to prevent "headers already sent"
session_start();
include "DB_connection.php"; // PDO connection
if (isset($_POST['register'])) {
    // Retrieve and sanitize input
    $fname = trim($_POST['fn'] ?? '');
    $lname = trim($_POST['ln'] ?? '');
    $telphone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['co'] ?? '');
    $pos = trim($_POST['position'] ?? '');
    $e_add = trim($_POST['email'] ?? '');
    $pwd = $_POST['pass'] ?? '';
    $role = trim($_POST['role'] ?? '');
    // Basic input validation
    if (empty($fname) || empty($lname) || empty($telphone) || empty($company) || 
        empty($pos) || empty($e_add) || empty($pwd) || empty($role)) {
        $_SESSION['status'] = "All fields are required.";
        $_SESSION['status_code'] = "error";
        header("Location: register.php");
        exit();
    }
    // Validate email format
    if (!filter_var($e_add, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid email format.";
        $_SESSION['status_code'] = "error";
        header("Location: register.php");
        exit();
    }

    // Double encrypt password (sha1(md5()))
    $pwd_hashed = sha1(md5($pwd));
    $show_pass = $pwd; // Store plain password (consider security implications)

    try {
        // Check if email already exists
        $check_query = "SELECT email FROM register WHERE email = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bindParam(1, $e_add, PDO::PARAM_STR);
        $check_stmt->execute();
        if ($check_stmt->rowCount() > 0) {
            $_SESSION['status'] = "Email already registered.";
            $_SESSION['status_code'] = "error";
            header("Location: register.php");
            exit();
        }

        // Insert new user
        $query = "INSERT INTO register (first_name, last_name, phone, company, position, email, password, show_pass, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $fname, PDO::PARAM_STR);
        $stmt->bindParam(2, $lname, PDO::PARAM_STR);
        $stmt->bindParam(3, $telphone, PDO::PARAM_STR);
        $stmt->bindParam(4, $company, PDO::PARAM_STR);
        $stmt->bindParam(5, $pos, PDO::PARAM_STR);
        $stmt->bindParam(6, $e_add, PDO::PARAM_STR);
        $stmt->bindParam(7, $pwd_hashed, PDO::PARAM_STR);
        $stmt->bindParam(8, $show_pass, PDO::PARAM_STR);
        $stmt->bindParam(9, $role, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = "Data inserted successfully.";
            $_SESSION['status_code'] = "success";
            header("Location: register.php");
            exit();
        } else {
            $_SESSION['status'] = "Failed to insert data.";
            $_SESSION['status_code'] = "error";
            header("Location: register.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error inserting user: " . $e->getMessage());
        $_SESSION['status'] = "Database error occurred.";
        $_SESSION['status_code'] = "error";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('header_footer/header.php'); ?>
<body class="body-login">
    <div class="black-fill"><br /><br />
        <div class="d-flex justify-content-center align-items-center flex-column">
            <form class="login" method="POST">
                <div class="text-center">
                    <img src="logo.png" width="100" alt="Logo">
                </div>
                <h3>ADMIN REGISTER</h3>
                <?php if (isset($_SESSION['status']) && $_SESSION['status'] != ''): ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong> <?php echo htmlspecialchars($_SESSION['status']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['status']); // Clear status after display ?>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="fn" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="ln" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" class="form-control" name="co" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Position</label>
                    <input type="text" class="form-control" name="position" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Login As</label>
                    <input type="text" class="form-control" placeholder="Admin" readonly>
                    <input type="hidden" class="form-control" name="role" value="1">
                </div>
                <button type="submit" name="register" class="btn btn-primary">Register</button>
                <a href="index.php" class="text-decoration-none">Home</a>
            </form>
            <br /><br />
            <?php include('header_footer/footer1.php'); ?>
        </div>
    </div>
    <?php include('header_footer/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION['status_code']) && $_SESSION['status_code'] == 'success'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo htmlspecialchars($_SESSION['status']); ?>'
            });
        </script>
    <?php elseif (isset($_SESSION['status_code']) && $_SESSION['status_code'] == 'error'): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo htmlspecialchars($_SESSION['status']); ?>'
            });
        </script>
    <?php endif; ?>
    <?php unset($_SESSION['status_code']); // Clear status code ?>
</body>
</html>
<?php ob_end_flush(); ?>