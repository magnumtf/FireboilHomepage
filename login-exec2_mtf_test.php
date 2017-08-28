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
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
    echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

    mysqli_close($link);
//Select database
//	$db = mysql_select_db(DB_DATABASE);
	
	
	//Sanitize the POST values, login, password, page_id
	$login = $_POST['username'];
	$password = $_POST['password'];
	$page_id = $_POST['page_id'];
    print $login;
    print "<br />";
    print $password;
    print "<br />";
    print $page_id; 
    print "<br />";
    phpinfo();
?>
