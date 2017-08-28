<?php
	//Start session
	//Start session
	require_once('config.php');
		
	//Validation error flag
	$errflag = false;
		
	//Connect to mysql server
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if(!$link) {
		die('Failed to connect to server: ' . mysqli_connect_error());
	}
 	
	$qry="SELECT customer_id, username, firstname, lastname, status FROM customer";

	$result=mysqli_query($link, $qry);
	
echo "<table border='1'>
<tr>
<th>customer_id</th>
<th>Username</th>
<th>Firstname</th>
<th>Lastname</th>
<th>status</th>
</tr>";

	//Check whether the query was successful or not
	if($result) 
	{	
    $idnum = 191;
    $username = "turdferguson";
    $firstname = "Cats";
    $lastname = "Vaggy";
    $status = 2;
		while ($row = mysqli_fetch_assoc($result)) {
 			echo "<tr>";
    	echo "<td>" . $row["customer_id"] . "</td>";
    	echo "<td>" . $row["username"] . "</td>";
    	echo "<td>" . $row["firstname"] . "</td>";
    	echo "<td>" . $row["lastname"] . "</td>";
    	echo "<td>" . $row["status"] . "</td>";
			echo "</tr>";
		}    
  }
  else
  {
    $idnum = 3000;
    $firstname = "Sharty";
    $lastname = "Shorty";
    $status = 1;
		for ($inum = 0; $inum < 10; $inum++)
		{
 			echo "<tr>";
 			echo "<td>" . "$idnum" . "$inum" . "</td>";
 			echo "<td>" .  "$username" . "$inum" . "</td>";
 			echo "<td>" .  "$firstname" . "$inum" . "</td>";
 			echo "<td>" . "$lastname". "$inum"  . "</td>";
 			echo "<td>" . "$status" . "$inum" . "</td>";
 			echo "</tr>";
 		}
  }
 
 	echo "</table>";
	mysqli_close($link); 	
?> 
