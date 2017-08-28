<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
		
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	//
// does the actual 'html' and 'sql' sanitization. customize if you want.
	function checkIllegalChars($text)
	{
		$retval = true;
		$pos = strpos($text, "<");
		if ($pos === false) 
		{
			$pos = strpos($text, ">");
			if ($pos === false) 
			{
				$pos = strpos($text, "\"");
				if ($pos === false) 
				{
					$pos = strpos($text, "'");
					if ($pos === false) 
					{
						$pos = strpos($text, "\\");
						if ($pos === false) 
						{
							$pos = strpos($text, "*");
							if ($pos === false) 
							{
								$pos = strpos($text, "/");
								if ($pos === false) 
								{
									$retval = false;
								}
							}
						}
					}
				}
			}
		} 
		return $retval;
	} 
	
//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}

	function addzero($strval)
	{
		$ival = intval($strval);
		if ($ival < 10)
		{
			$retstring = "0" . $strval;
		}
		else
		{
			$retstring = $strval;
		}
		return $retstring; 
	}
	//Sanitize the POST values, login, password, page_id
	$login = clean($_POST['username']);
	$fname = clean($_POST['firstname']);
	$lname = clean($_POST['lastname']);
	$mi = clean($_POST['mi']);	
	$mi2 = substr($mi, 0, 1);  // abcd
	$emailaddress = clean($_POST['emailaddress']);
	$emailaddress2 = clean($_POST['emailaddress2']);
	$pword = clean($_POST['password']);
	$pword2 = clean($_POST['password2']);
	$address1 = clean($_POST['address1']);
	$address2 = clean($_POST['address2']);
	$city = clean($_POST['city']);
	$state = clean($_POST['state']);
	$zipcode = clean($_POST['zipcode']);
	$country = clean($_POST['country']);
	$phonenum = clean($_POST['phonenum']);
	
	$rclogin = checkIllegalChars($_POST['username']);
	$rcfname = checkIllegalChars($_POST['firstname']);
	$rclname = checkIllegalChars($_POST['lastname']);
	$rcmi = checkIllegalChars($mi2);	
	$rcemailaddress = checkIllegalChars($_POST['emailaddress']);
	$rcemailaddress2 = checkIllegalChars($_POST['emailaddress2']);
	$rcpword = checkIllegalChars($_POST['password']);
	$rcpword2 = checkIllegalChars($_POST['password2']);
	$rcaddress1 = checkIllegalChars($_POST['address1']);
	$rcaddress2 = checkIllegalChars($_POST['address2']);
	$rccity = checkIllegalChars($_POST['city']);
	$rcstate = checkIllegalChars($_POST['state']);
	$rczipcode = checkIllegalChars($_POST['zipcode']);
	$rccountry = checkIllegalChars($_POST['country']);
	$rcphonenum = checkIllegalChars($_POST['phonenum']);
	$page_id = $_POST['page_id'];
	
	if ($rcmi)
	{
		$mi2 = '';
	}

	if ($rclogin)
	{
		$errmsg_arr[] = 'Username contains illegal characters';
		$errflag = true;
	}
	else if ($rcfname)
	{
		$errmsg_arr[] = 'Firstname contains illegal characters';
		$errflag = true;
	}	
	else if ($rcemailaddress)
	{
		$errmsg_arr[] = 'email address contains illegal characters';
		$errflag = true;
	}	
	else if ($rcemailaddress2)
	{
		$errmsg_arr[] = 'email addresses do not matchy';
		$errflag = true;
	}	
	else if ($rcpword)
	{
		$errmsg_arr[] = 'password contains illegal characters';
		$errflag = true;
	}	
	else if ($rcpword2)
	{
		$errmsg_arr[] = 'passwords do not matchy';
		$errflag = true;
	}	
	else if ($rcaddress1)
	{
		$errmsg_arr[] = 'address contains illegal characters';
		$errflag = true;
	}	
	else if ($rcaddress2)
	{
		$errmsg_arr[] = 'address2 contains illegal characters';
		$errflag = true;
	}	
	else if ($rccity)
	{
		$errmsg_arr[] = 'city contains illegal characters';
		$errflag = true;
	}	
	else if ($rcstate)
	{
		$errmsg_arr[] = 'state contains illegal characters';
		$errflag = true;
	}	
	else if ($rczipcode)
	{
		$errmsg_arr[] = 'address2 contains illegal characters';
		$errflag = true;
	}	
	else if ($rccountry)
	{
		$errmsg_arr[] = 'city contains illegal characters';
		$errflag = true;
	}	
	else if ($rcphonenum)
	{
		$errmsg_arr[] = 'state contains illegal characters';
		$errflag = true;
	}	
	else if($login == '') 
	{
		$errmsg_arr[] = 'Username missing';
		$errflag = true;
	}
	else if($fname == '') 
	{
		$errmsg_arr[] = 'Firstname missing';
		$errflag = true;
	}
	else if($lname == '') 
	{
		$errmsg_arr[] = 'Lastname missing';
		$errflag = true;
	}
	else if($emailaddress == '') 
	{
		$errmsg_arr[] = 'Email address missing';
		$errflag = true;
	}
	else if($emailaddress2 == '') 
	{
		$errmsg_arr[] = 'Email address 2 missing';
		$errflag = true;
	}
	else if(strcmp($emailaddress2,$emailaddress))
	{
		$errmsg_arr[] = 'Email addresses do not match';
		$errflag = true;
	}
	else if($pword == '') 
	{
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	else if($pword2 == '') 
	{
		$errmsg_arr[] = 'Password2 missing';
		$errflag = true;
	}
	else if(strcmp($pword,$pword2))
	{
		$errmsg_arr[] = 'Passwords do not match';
		$errflag = true;
	}
	else if($address1 == '') 
	{
		$errmsg_arr[] = 'Address missing';
		$errflag = true;
	}
	else if($city == '') 
	{
		$errmsg_arr[] = 'City missing';
		$errflag = true;
	}
	else if($state == '') 
	{
		$errmsg_arr[] = 'State missing';
		$errflag = true;
	}
	else if($zipcode == '') 
	{
		$errmsg_arr[] = 'Zip code missing';
		$errflag = true;
	}
	else if($country == '') 
	{
		$errmsg_arr[] = 'Country missing';
		$errflag = true;
	}	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: register-form.php");
		exit();
	}	
//Create query
	$qry2="INSERT INTO customer SET username='$login', password='$pword', firstname='$fname', lastname='$lname', mi='$mi2', email='$emailaddress', admin_level=0";
	
// update city state, and auto-login ..., make python program to copy manifest.txt to webserver.
	$result=mysql_query($qry2);
	//Check whether the query was successful or not, put firstname on the page. yep yep.
	if($result) 
	{
		//fetch some stuff and auto-login
		$customer_id = mysql_insert_id();
		//Registration Successful
		session_regenerate_id();
		$_SESSION['SESS_MEMBER_ID'] = $customer_id;
		$_SESSION['SESS_FIRST_NAME'] = $fname;
		$_SESSION['SESS_LAST_NAME'] = $lname;
		$_SESSION['SESS_BALANCE'] = 0.0;
		$_SESSION['SESS_STATUS'] = 0;
		$_SESSION['SESS_LAST_PAGE'] = $page_id;
		$_SESSION['SESS_ADMIN_LEVEL'] = 0;

	    $qry4="UPDATE customer SET address1='$address1', address2='$address2', city='$city', state='$state', zipcode='$zipcode', country='$country', phone='$phonenum' WHERE customer_id='$customer_id'";	
	    $result4=mysql_query($qry4);
		if ($result4)
		{
          //Create account
		  $my_t = getdate();
		  $create_date = $my_t['year'] . addzero($my_t['mon']) . addzero($my_t['mday']) . addzero($my_t['hours']) . addzero($my_t['minutes']) . addzero($my_t['seconds']);
		  $qry5="INSERT INTO account SET create_date='$create_date',balance=0.0,status=1,type=1";	

// update city state, and auto-login ..., make python program to copy manifest.txt to webserver.
	 	  $result5=mysql_query($qry5);
		  if($result5)
		  {
		  	$account_id = mysql_insert_id();
			$_SESSION['SESS_BALANCE'] = 0.0;
			$_SESSION['SESS_STATUS'] = 1;
			$_SESSION['SESS_ACCOUNT_ID'] = $account_id;
	    	$qry6="UPDATE customer SET account_id='$account_id' WHERE customer_id='$customer_id'";
	    	$result6=mysql_query($qry6);
		  }
		  session_write_close();
		  if ($page_id == 2)
		  {
			header("location: product.php");
		  }
		  else
		  {
			header("location: index.php");
			 // index.php is index.html with the auth.php at the top and some submits that weren't activated.  run a script.
		  }
		  exit();
		}
		else
		{
	    	$qry6="DELETE FROM customer WHERE customer_id='$customer_id'";
			$result=mysql_query($qry6);		
		    die("Query 4 failed");
		}
  	}
  	else
  	{
  		die("Query failed");
  	}
?>
