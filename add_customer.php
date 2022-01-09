<?php 
	include('db_connect.php');
	if(isset($_POST['submit'])){
		$user 		= mysqli_real_escape_string($conn, $_POST['user']);
		$name 		= mysqli_real_escape_string($conn, $_POST['name']);
		$address	= mysqli_real_escape_string($conn, $_POST['address']);
		$contact	= mysqli_real_escape_string($conn, $_POST['contact']);
		$email	= mysqli_real_escape_string($conn, $_POST['email']);
	  	
		echo '<script>alert($user)</script>';
		
		$sql  = "INSERT INTO customer_list cL (cL.name,cL.contact,cL.address,cL.email) VALUES ('$name','$contact','$address','$email')";
	  	$result = mysqli_query($conn, $sql);
 	
	}
