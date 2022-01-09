<?php
	include('db_connect.php');
	
	$query 	= mysqli_real_escape_string($conn, $_POST['query']);	
	$show 	= "SELECT cL.name,cL.address FROM customer_list cL WHERE cL.name LIKE '%{$query}%'";
	
	$result	=  $conn->query($show);
	
	$customerDetails = [];
	$i=0;

	while($row = $result->fetch_assoc()){
		//$array[] = $row['name'];	
			$customerDetails[$i]['name'] = $row['name'];
			$customerDetails[$i]['address'] = $row['address'];
		// array_push($customerDetails, (object)[
		// 	'name' => 'someValue',
		// 	'contact' => 'someValue2',
		// 	'address' => 'someValue3',
		// 	'email' => 'someValue4',
		//]);
		$i++;
	}
	
	print json_encode($customerDetails);
?>