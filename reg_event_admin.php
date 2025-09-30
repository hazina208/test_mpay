<?php
ob_start(); // buffer output, prevents "headers already sent"
session_start();
include "DB_connection.php";
    if(isset($_POST['register']))
    {
        
        $fname=$conn -> real_escape_string($_POST['fn']);
		$mname=$conn -> real_escape_string($_POST['mn']);
        $lname=$conn -> real_escape_string($_POST['ln']);
        $telphone=$conn -> real_escape_string($_POST['phone']);
		$entity=$conn -> real_escape_string($_POST['chama']);
		$entity_name=$conn -> real_escape_string($_POST['chama_name']);
        
        $e_add=$conn -> real_escape_string($_POST['email']);
        $pwd=$conn -> real_escape_string(sha1(md5($_POST['pass'])));//double encrypt to increase security
        $show_pass=$conn -> real_escape_string($_POST['pass']);
        $role=$conn -> real_escape_string($_POST['role']);

       
        
        //sql to insert captured values
		$query="INSERT INTO register (first_name, middle_name, last_name, phone, entity, entity_name, email, password, show_pass, role) values(?,?,?,?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($query);
		$rc=$stmt->bind_param('ssssssssss', $fname, $mname, $lname, $telphone, $entity, $entity_name, $e_add, $pwd, $show_pass, $role);
		$stmt->execute();

		
		if($stmt)
		{
            $_SESSION['status'] = "EVENT ADMIN REGISTERED SUCCESSFULLY";
            $_SESSION['status_code'] = "success";
            header("location:reg_event_admin.php");
			
		}
		else {
            $_SESSION['status'] = "EVENT ADMIN NOT REGISTERED ";
            $_SESSION['status_code'] = "error";
            header("location:reg_event_admin.php");
			
		}


    }
?>

<!DOCTYPE html>
<html lang="en">
<?php
include('header_footer/header.php');
?>

<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" method="POST" >
    	      
    	      

    		<div class="text-center">
    			<img src="logo.png"  width="100">
    			    
    		</div>
    		<h3>ADMIN REGISTER</h3>
    		<?php 
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
                ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong><?php echo $_SESSION['status']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
			?>

		  	<div class="mb-3">
		    	<label class="form-label">First Name</label>
                
		    	<input type="text" class="form-control" name="fn" >
      
		  	</div>


		  <div class="mb-3">
		    <label class="form-label">Middle Name</label>
		    <input type="text" class="form-control" name="mn">
      
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Last Name</label>
		    <input type="text" class="form-control" name="ln">
      
		  </div>
		  <div class="mb-3">
		    <label class="form-label">Phone Number</label>
		    <input type="text" class="form-control" name="phone">
      
		  </div>


		  <div class="mb-3">
		    <label hidden class="form-label">Event</label>
		    <input  type="hidden" class="form-control" value="Event"  name="event">
      
		  </div>

		  <div class="mb-3">
		    <label  class="form-label">Event Name</label>
		    <?php
            // Database connection
            include("connection.php");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Fetch job numbers for dropdown
            $result = $conn->query("SELECT event_name FROM event");
            ?>

            <select id="chama_name" name="chama_name" >
                <option value="">-- Select Event --</option>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <option value="<?= $row['event_name']; ?>"><?= $row['event_name']; ?></option>
                    <?php endwhile; ?>
                </select>
      
		  </div>

		  

		  <div class="mb-3">
		    <label class="form-label">Email</label>
		    <input type="text" class="form-control" name="email">
      
		  </div>

		  

           <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" class="form-control" name="pass">
      
		  </div>

		  

		  <div class="mb-3">
		    <label class="form-label">Login As</label>
		    <input type="text" class="form-control"  placeholder="Event Admin" readonly>
            <input type="hidden" class="form-control" name="role"  value="6" >
		     
		  </div>

		  <button type="submit" name="register" class="btn btn-primary">Register</button>
		  <a href="index.php" class="text-decoration-none">Home</a>
		</form>
        
        <br /><br />
        <?php
		include('header_footer/footer1.php');
		?>
    	</div>
    </div>
<?php include('header_footer/footer.php'); ?>
		
		
    