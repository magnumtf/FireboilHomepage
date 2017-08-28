<?php
	//Start session
	require_once('config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
		
	//Connect to mysql server
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if(!$link) {
		die('Failed to connect to server: ' . mysqli_connect_error());
	}
 	
	$qry="SELECT customer_id, firstname, lastname, status FROM customer";

	$result=mysqli_query($link, $qry);
	
	//Check whether the query was successful or not
	if($result) 
	{
echo "<table border='1'>
<tr>
<th>customer_id</th>
<th>Firstname</th>
<th>Lastname</th>
<th>status</th>
</tr>";

		while($row = mysqli_fetch_array($result))
  		{
  			echo "<tr>";
  			echo "<td>" . $row['customer_id'] . "</td>";
  			echo "<td>" . $row['firstname'] . "</td>";
  			echo "<td>" . $row['lastname'] . "</td>";
  			echo "<td>" . $row['status'] . "</td>";
  			echo "</tr>";
  		}
	}
echo "</table>";
	mysqli_close($link);
?> 
