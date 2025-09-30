

<?php
    session_start();
 
    include "DB_connection.php";
    if(isset($_POST['login']))
    {
        $email=$conn -> real_escape_string($_POST['email']);
        $pwd=$conn -> real_escape_string(sha1(md5($_POST['pass'])));//double encrypt to increase security
		
        
        $sql = "SELECT * FROM register WHERE email=? AND password=? ";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("ss", $email, $pwd);
        
        $stmt->execute();//execute bind
        $result = $stmt->get_result();
	    $row = $result->fetch_assoc();
        session_regenerate_id();

        //$ldate=date('d/m/Y h:i:s', time());
        $_SESSION['id'] = $row['id'];
	    $_SESSION['email'] = $row['email'];
	    $_SESSION['role'] = $row['role'];
	    $_SESSION['entity_name'] = $row['entity_name'];
		$_SESSION['first_name'] = $row['first_name'];
		$_SESSION['last_name'] = $row['last_name'];
	    session_write_close();

        if($result->num_rows==1 && $_SESSION['role']=="1"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt = $conn->prepare($log_sql);
        	$log_stmt->bind_param('sssssi', $fn, $ln, $co, $email, $pwd, $role);
        	$log_stmt->execute();

			if($log_stmt)
			{
            	
            	header("location:admin/dashboard.php?msg=success");
				exit();
			
			}
			else {
            	
            	header("location:login.php?msg=failed");
				exit();
			
			}
        
            
     
        }
        else if ($result->num_rows==1 && $_SESSION['role']=="2"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql2 = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt2 = $conn->prepare($log_sql2);
        	$log_stmt2->bind_param('sssssi', $fn, $ln, $co, $email, $pwd, $role);
        	$log_stmt2->execute();
			if($log_stmt2)
			{
            	
            	header("location:Chama/dashboard.php?msg=success");
				exit();
			
			}
			else {
            	
            	header("location:login.php?msg=failed");
				exit();
			
			}
                
       
        }

		
        else if ($result->num_rows==1 && $_SESSION['role']=="3"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql4 = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt4 = $conn->prepare($log_sql4);
        	$log_stmt4->bind_param('sssssi', $fn, $ln, $co, $email, $pwd,  $role);
        	$log_stmt4->execute();
          	 if($log_stmt4)
				{
            		
            		header("location:Sacco/dashboard.php?msg=success");
					exit();
					
			
				}
			else {
            	
            	header("location:login.php?msg=failed");
				exit();
			
			}
        
        }

		else if ($result->num_rows==1 && $_SESSION['role']=="4"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql5 = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt5 = $conn->prepare($log_sql5);
        	$log_stmt5->bind_param('sssssi', $fn, $ln, $co, $email, $pwd,  $role);
        	$log_stmt5->execute();
            if($log_stmt5)
			{
            
            	header("location:BusMatSacco/dashboard.php?msg=success");
				exit();
			
			}
			else {
            
            	header("location:login.php?msg=failed");
				exit();
			
			}
        
        }

		else if ($result->num_rows==1 && $_SESSION['role']=="5"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql6 = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt6 = $conn->prepare($log_sql6);
        	$log_stmt6->bind_param('sssssi', $fn, $ln, $co, $email, $pwd,  $role);
        	$log_stmt6->execute();
            if($log_stmt6)
			{
            	
            	header("location:cargovehiclesacco/dashboard.php?msg=success");
				exit();
			
			}
			else {
            	
            	header("location:login.php?msg=failed");
				exit();
			
			}
        
        }
		else if ($result->num_rows==1 && $_SESSION['role']=="6"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql3 = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt3 = $conn->prepare($log_sql3);
        	$log_stmt3->bind_param('sssssi', $fn, $ln, $co, $email, $pwd,  $role);
        	$log_stmt3->execute();
			if($log_stmt3)
			{
            	
            	header("location:events/dashboard.php?msg=success");
				exit();
			
			}
			else {
            	
            	header("location:login.php?msg=failed");
				exit();
			
			}
                
       
        }

		else if ($result->num_rows==1 && $_SESSION['role']=="7"){
			$role=$_SESSION['role'];
			$fn=$_SESSION['first_name'];
			$ln=$_SESSION['last_name'];
			$co=$_SESSION['entity_name'];
			$log_sql7 = "INSERT INTO logs (first_name, last_name, entity_name, email, password, role) VALUES (?,?,?,?,?,?)";
        	$log_stmt7 = $conn->prepare($log_sql7);
        	$log_stmt7->bind_param('sssssi', $fn, $ln, $co, $email, $pwd,  $role);
        	$log_stmt7->execute();
			if($log_stmt7)
			{
            	
            	header("location:insurance/dashboard.php?msg=success");
				exit();
			
			}
			else {
            	
            	header("location:login.php?msg=failed");
				exit();
			
			}
                
       
        }
       
        else{
            
    
        	header("location:login.php?msg=error");
			exit();
        
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
    			<img src="logo.png" width="100">
    			     
    		</div>
    		<h3>ADMIN LOGIN </h3>

			

			<div class="mb-3">
		    	<label class="form-label">Email</label>
		    	<input type="text" class="form-control" name="email">
      
		  	</div>

		  
		  
		  	<div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" class="form-control" name="pass">
		           
		           
		  </div>

		  

		  <button type="submit" name="login" class="btn btn-primary">Login</button>
		  <a href="index.php" class="text-decoration-none">Home</a>
		</form>
        
        <br /><br />
        <?php
		include('header_footer/footer1.php');
		?>
    	</div>
    </div>
	<?php if (isset($_GET['msg'])): ?>
        <script>
            <?php if ($_GET['msg'] == "success"): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Logged in  Successfully!',
                    text: 'You can now log in.'
                });
            <?php elseif ($_GET['msg'] == "error"): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'S/No already exists!',
                    text: 'Please try another one.'
                });
            <?php elseif ($_GET['msg'] == "failed"): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed!',
                    text: 'Something went wrong. Try again.'
                });
            <?php endif; ?>
        </script>
    <?php endif; ?>
<?php include('../header_footer/footer.php'); ?>