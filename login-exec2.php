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
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if (!$link) {
 		die('Failed to connect to server: ' . mysqli_connect_error());
    }
//    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
//    if ($mysqli->connect_errno) {
//        echo "Error - Failed to connect to MySQL: " . $mysqli->connect_error; 
//        exit();
//    }
    
	//
	// does the actual 'html' and 'sql' sanitization. customize if you want.
	function checkIllegalChars($text)
	{
		$retval = false;

    		return $retval;
	} 
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		return $str;
	}
	
	//Sanitize the POST values, login, password, page_id
	$login = clean($_POST['username']);
	$pos = strpos($login, '@');
	$password = clean($_POST['password']);
	$page_id = $_POST['page_id'];
	$rcuname = checkIllegalChars($_POST['username']);
	$rcpword = checkIllegalChars($_POST['password']);
    //print "Yo, mtf. made it here you mofos <br />";
    //exit();
	if ($rcuname)
	{
		$errmsg_arr[] = 'Login ID contains illegal characters';
		$errflag = true;
	}
	else if ($rcpword)
	{
		$errmsg_arr[] = 'Password contains illegal characters';
		$errflag = true;
	}	
	else if($login == '') 
	{
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	else if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: login-form.php");
		exit();
	}	
    print "Yo, mtf. made it here you mofos1 <br />";
//    exit();
//Create query
//	$qry="SELECT * FROM customer WHERE username='$login' AND password='".md5($_POST['password'])."'";
//      later, figure out what kind of encryption you need for passwords.
	if ($pos !== false)
	{
//		$qry="SELECT customer_id, account_id, firstname, lastname, admin_level FROM customer WHERE email='$login' AND password='$password'";
		$qry="SELECT customer.customer_id, customer.account_id, customer.firstname, customer.lastname, customer.admin_level, account.balance, account.status FROM customer INNER JOIN account ON customer.account_id=account.account_id WHERE customer.email='$login' AND customer.password='$password'";

	}
	else
	{
		$qry="SELECT customer.customer_id, customer.account_id, customer.firstname, customer.lastname, customer.admin_level, account.balance, account.status FROM customer INNER JOIN account ON customer.account_id=account.account_id WHERE customer.username='$login' AND customer.password='$password'";
	}

    //print "Yo, mtf. made it here you mofos <br />";
    //exit();
// mtf TODO get balance and status too.
// mtf TODO and do handle_transaction4 ...

	$result=mysqli_query($link, $qry);
	
    print "Yo, mtf. hint, it's in mysqli_query. made it here you mofos <br />";
//    exit();
	//Check whether the query was successful or not
	if($result) 
	{
        print "Yo, mtf. login success1! ";
        print "<br />";
        $rowcount = mysqli_num_rows($result);
        if($rowcount == 0)
        {
            print "0 Rows ";
            print $qry;
            print "<br />";
        }
        else if($rowcount == 1) 
		{
			//Login Successful
            print "Yo, mtf. login success2!<br />";
            session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['customer_id'];
			$_SESSION['SESS_ACCOUNT_ID'] = $member['account_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lastname'];
			$_SESSION['SESS_BALANCE'] = $member['balance'];
			$_SESSION['SESS_STATUS'] = $member['status'];
			$_SESSION['SESS_LAST_PAGE'] = $page_id;
			$_SESSION['SESS_ADMIN_LEVEL'] = $member['admin_level'];
// yo mtf test
			$_SESSION['SESS_POOL_ACCT_ID'] = '0';
			$_SESSION['SESS_AMOUNT'] = '0';
			$_SESSION['SESS_PICK_ROT_ID'] = '0';
			$_SESSION['SESS_PLAYER_ACCT_ID'] = '0';
			for($x = 0; $x < count($_POST['pool_acct_id']); $x++ )
			{
				$_SESSION['SESS_PLAYER_ACCT_ID'] = $_POST['player_acct_id'];
				if ($x == 1)
				{
					$_SESSION['SESS_POOL_ACCT_ID'] = $_POST['pool_acct_id'][$x];
					$_SESSION['SESS_AMOUNT'] = $_POST['bet_amount_arr'][$x];
					$_SESSION['SESS_PICK_ROT_ID'] = $_POST['pick_rot_id'][$x];
				}
			}

			if (isset($_COOKIE["display_odds"]))
			{
				$_SESSION['SESS_DISPLAY_ODDS'] = $_COOKIE["display_odds"];
			}
			else
			{
				$_SESSION['SESS_DISPLAY_ODDS'] = 0;  // american
			}
			if (isset($_COOKIE["compare_site"]))
			{
				$_SESSION['SESS_COMPARE_SITE'] = $_COOKIE["compare_site"];
			}
			else
			{
				$_SESSION['SESS_COMPARE_SITE'] = 0;  // bovada
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
			//Login failed
            print "Yo, mtf. login failed1!<br />";
			// figure out failure and go to login-form.php
			if ($pos !== false)
			{
				$qry2="SELECT customer_id, firstname, lastname, status FROM customer WHERE email='$login'";
			}
			else
			{
				$qry2="SELECT customer_id, firstname, lastname, status FROM customer WHERE username='$login'";
			}			
			$result2=mysqli_query($link, $qry2);
	
            print "Yo, mtf. login failed2!<br />";
			//Check whether the query was successful or not
			if($result2) 
			{
				if(mysqli_num_rows($result2) == 1)
				{
					$errmsg_arr[] = 'Incorrect password';
					$errflag = true;
				}
				else
				{
					$errmsg_arr[] = 'Incorrect username';
					$errflag = true;
				}
			}
			else
			{
				$errmsg_arr[] = 'Incorrect username';
				$errflag = true;
			}

			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: login-form.php");
			exit();
		}
	}
	else 
	{
		die("Query failed");
	}
?>
