<?php
// Ensure session is started (already done in dashboard.php)
$aid = $_SESSION['id'] ?? null;
if ($aid) {
    try {
        // Prepare and execute query to fetch user details
        $ret = "SELECT * FROM register WHERE id = ?";
        $stmt = $conn->prepare($ret);
        $stmt->bindParam(1, $aid, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if ($row) {
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">
      <img src="../logo.png" width="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"
          id="navLinks">
        <li class="nav-item">
          <a class="nav-link" 
             aria-current="page" 
             href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../reg_chama_admin.php">Register Chama Admin</a>
        </li>

      </ul>
          <ul class="navbar-nav me-right mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href=""> <?php echo $row->email;?></a>
        </li>
      </ul>
      <ul class="navbar-nav me-right mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href=""><?php echo $row->entity_name;?></a>
        </li>
      </ul>
      <ul class="navbar-nav me-right mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Logout</a>
        </li>
      </ul>
  </div>
    </div>
</nav>
<?php
        } else {
            // Redirect if no user found
            header('Location: ../login.php?msg=error');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Error fetching user details: " . $e->getMessage());
        header('Location: ../login.php?msg=failed');
        exit();
    }
} else {
    // Redirect if session ID is not set
    header('Location: ../login.php?msg=error');
    exit();
}
?>