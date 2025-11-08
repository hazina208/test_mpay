<?php
ob_start(); // Buffer output to prevent "headers already sent"
session_start();
include "DB_connection.php";

if (isset($_POST['login'])) {
    try {
        // Sanitize input (no need for real_escape_string with PDO prepared statements)
        $email = $_POST['email'];
        $pwd = sha1(md5($_POST['pass'])); // Double encrypt (note: consider using password_hash() instead)

        // Query to find user by email and password
        $sql = "SELECT * FROM register WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $pwd);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Store session data
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['entity_name'] = $row['entity_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];

            // Log user activity
            $log_sql = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bindParam(1, $_SESSION['first_name']);
            $log_stmt->bindParam(2, $_SESSION['last_name']);
            $log_stmt->bindParam(3, $_SESSION['entity_name']);
            $log_stmt->bindParam(4, $email);
            $log_stmt->bindParam(5, $pwd);
            $log_stmt->bindParam(6, $_SESSION['role'], PDO::PARAM_INT);
            $log_stmt->execute();
            $log_stmt->closeCursor();

            // Redirect based on role
            $redirects = [
                1 => "admin/dashboard.php",
                2 => "Chama/dashboard.php",
                3 => "Sacco/dashboard.php",
                4 => "BusMatSacco/dashboard.php",
                5 => "cargovehiclesacco/dashboard.php",
                6 => "events/dashboard.php",
                7 => "insurance/dashboard.php",
                13 => "electricity/table_settings.php",
                14 => "water/table_settings.php"
            ];

            if (isset($redirects[$_SESSION['role']])) {
                header("Location: {$redirects[$_SESSION['role']]}?msg=success");
                exit();
            } else {
                header("Location: login.php?msg=error");
                exit();
            }
        } else {
            header("Location: login.php?msg=error");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        header("Location: login.php?msg=failed");
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
                    <img src="logo.png" width="100">
                </div>
                <h3>ADMIN LOGIN</h3>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="pass" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <a href="index.php" class="text-decoration-none">Home</a>
            </form>
            <br /><br />
            <?php include('header_footer/footer1.php'); ?>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <script>
            <?php if ($_GET['msg'] == "success"): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Logged in Successfully!',
                    text: 'You can now log in.'
                });
            <?php elseif ($_GET['msg'] == "error"): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Email or Password!',
                    text: 'Please try again.'
                });
            <?php elseif ($_GET['msg'] == "failed"): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed!',
                    text: 'Something went wrong. Try again.'
                });
            <?php endif; ?>
        </script>
    <?php endif; ?>
<?php include('header_footer/footer.php'); ?>
</body>
</html>
<?php ob_end_flush(); ?>