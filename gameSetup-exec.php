<?php
	//Start session
	session_start();
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '') || ($_SESSION['SESS_ADMIN_LEVEL'] < 1) || !isset($_SESSION['SESS_ADMIN_LEVEL']) || (trim($_SESSION['SESS_ADMIN_LEVEL']) == ''))
	{
		header("location: access-denied.php");
		exit();
	}	
	//Include database connection details
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
		return $retval;
	} 

	function checkChars($des_char, $text)
	{
		$retval = true;
		$pos = strpos($text, $des_char);
		if ($pos === false) 
		{
			$retval = false;
		}
		else
		return $retval;
	} 

	function getRotID($gamename,$category)
	{
		$name_arr = array();
		explode ( string $delimiter , string $string [, int $limit ] )
		$name_arr = explode(',', $gamename);
		$result = count($name_arr);
		$like = "=";
		if ($result == 2)
		{
			$location = $name_arr[0];
			$name = $name_arr[1];
			$fullname = "";
		}
		else
		{
			look for asterisks:
			$pos = strpos($gamename, '*');
			$location = "";
			$name = "";
			$fullname = $gamename;
			if ($pos !== false)
			{	
				$like = " like ";
				$fullname = "%".substr($gamename,$pos)."%";
				$location = "";
				$name = "";
			}
		}

		if ($fullname == "")
		{
			$qry2="SELECT entry_name_id,location FROM entry_name WHERE name='$name' AND category='$category'";
		}
		else
		{
			$qry2="SELECT entry_name_id,location FROM entry_name WHERE fullname".$like."'$fullname' AND "category='$category'";
		}

		$result=mysqli_query($link, $qry2);
		if($result) 
		{
			$entry_name_id = 
		$customer_id = mysqli_insert_id();
		//Registration Successful
		session_regenerate_id();
		$_SESSION['SESS_MEMBER_ID'] = $customer_id;
		$_SESSION['SESS_FIRST_NAME'] = $fname;
		$_SESSION['SESS_LAST_NAME'] = $lname;
		$_SESSION['SESS_BALANCE'] = 0.0;
		$_SESSION['SESS_ACCOUNT_ID'] = $account_id;
		$_SESSION['SESS_STATUS'] = 0;
		$_SESSION['SESS_LAST_PAGE'] = $page_id;
		$_SESSION['SESS_ADMIN_LEVEL'] = 0;
	}
		now make a query.
		$pos = strpos($gamename, ',');

		return $retval;
	}

//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysqli_real_escape_string($str);
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
	$gamename = clean($_POST['gamename']);
	$game_category = clean($_POST['game_category']);
	$game_subcategory = clean($_POST['game_subcategory']);
	$gametime_month = clean($_POST['gametime_month']);
	$gametime_day = clean($_POST['gametime_day']);
	$gametime_year = clean($_POST['gametime_year']);
	$gametime_hour = clean($_POST['gametime_hour']);
	$gametime_ampm = clean($_POST['gametime_ampm']);
	$gametime_minute = clean($_POST['gametime_minute']);
	$num_entries = clean($_POST['num_entries']);
	$ename_arr = array();
	$ename_arr[0] = clean($_POST['entry1_name']);
	$ename_arr[1] = clean($_POST['entry2_name']);
	$ename_arr[2] = clean($_POST['entry3_name']);
	$ename_arr[3] = clean($_POST['entry4_name']);
	$ename_arr[4] = clean($_POST['entry5_name']);
	$ename_arr[5] = clean($_POST['entry6_name']);
	$ename_arr[6] = clean($_POST['entry7_name']);
	$ename_arr[7] = clean($_POST['entry8_name']);
	$ename_arr[8] = clean($_POST['entry9_name']);
	$ename_arr[9] = clean($_POST['entry10_name']);
	$ename_arr[10] = clean($_POST['entry11_name']);
	$ename_arr[11] = clean($_POST['entry12_name']);
	$ename_arr[12] = clean($_POST['entry13_name']);
	$ename_arr[13] = clean($_POST['entry14_name']);
	$ename_arr[14] = clean($_POST['entry15_name']);
	$ename_arr[15] = clean($_POST['entry16_name']);
	$ename_arr[16] = clean($_POST['entry17_name']);
	$ename_arr[17] = clean($_POST['entry18_name']);
	$ename_arr[18] = clean($_POST['entry19_name']);
	$ename_arr[19] = clean($_POST['entry20_name']);
	$point_spread = clean($_POST['point_spread']);
	$pwp_spread = clean($_POST['pwp_spread']);
	$over_under = clean($_POST['over_under']);
	$entry1_over_under = clean($_POST['entry1_over_under']);
	$entry2_over_under = clean($_POST['entry2_over_under']);
	$over_under = clean($_POST['over_under']);
// handle ass pools here
	$page_id = $_POST['page_id'];
	
	$rot_id_arr = array();
	$num_entries2 = intval($num_entries)
	if (($num_entries2 >= 2) && ($num_entries <= 20))
	{
		for ($i=0; $i<$num_entries; $i++)
		{
			rot_id_arr[i] = getRotID($ename_arr[i]);
			if rot_id_arr[i] <= 0:
big fat error.
		}
	}
	else
big fat error
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
	$result=mysqli_query($link, $qry2);
	//Check whether the query was successful or not, put firstname on the page. yep yep.
	if($result) 
	{
		//fetch some stuff and auto-login
		$customer_id = mysqli_insert_id();
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
	    $result4=mysqli_query($link, $qry4);
		if ($result4)
		{
          //Create account
		  $my_t = getdate();
		  $create_date = $my_t['year'] . addzero($my_t['mon']) . addzero($my_t['mday']) . addzero($my_t['hours']) . addzero($my_t['minutes']) . addzero($my_t['seconds']);
		  $qry5="INSERT INTO account SET create_date='$create_date',balance=0.0,status=1,type=1";	

// update city state, and auto-login ..., make python program to copy manifest.txt to webserver.
	 	  $result5=mysqli_query($link, $qry5);
		  if($result5)
		  {
			$_SESSION['SESS_BALANCE'] = 0.0;
			$_SESSION['SESS_STATUS'] = 1;
		  	$account_id = mysqli_insert_id();
	    	$qry6="UPDATE customer SET account_id='$account_id' WHERE customer_id='$customer_id'";
	    	$result6=mysqli_query($link, $qry6);
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
			$result=mysqli_query($link, $qry6);		
		    die("Query 4 failed");
		}
  	}
  	else
  	{
  		die("Query failed");
  	}
?>
