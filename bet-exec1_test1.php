<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--
Copyright: Daemon Pty Limited 2006, http://www.daemon.com.au
Community: Mollio http://www.mollio.org $
License: Released Under the "Common Public License 1.0", 
http://www.opensource.org/licenses/cpl.php
License: Released Under the "Creative Commons License", 
http://creativecommons.org/licenses/by/2.5/
License: Released Under the "GNU Creative Commons License", 
http://creativecommons.org/licenses/GPL/2.0/
-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>FireBoil - The Jandy One</title>
<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="css/ie6_or_less.css" />
<![endif]-->
<script type="text/javascript" src="js/common.js"></script>
</head>
<body id="type-b">
<div id="wrap">

	<div id="header">
		<div id="site-name">FireBoil</div>
		<ul id="nav">
		<li class="first"><a href="home1.html">Home</a></li>
		<li class="active"><a href="product.html">Sportsbook</a>
			<ul>
			<li class="first"><a href="#">Football</a></li>
			<li class="active"><a href="#">Baseball</a></li>
			<li><a href="#">MLB</a></li>
			<li><a href="#">NCAA</a></li>
			<li class="last"><a href="#">Soccer</a></li>
			</ul>
		</li>
		<li><a href="#">Casino</a>
			<ul>
			<li class="first"><a href="#">Maecenas</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li class="last"><a href="#">Mauris at enim</a></li>
			</ul>
		</li>
		<li><a href="#">Racebook</a>
			<ul>
			<li class="first"><a href="#">Maecenas</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li class="last"><a href="#">Mauris at enim</a></li>
			</ul>
		</li>
		<li><a href="#">Lottery</a>
			<ul>
			<li class="first"><a href="#">Maecenas</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li class="last"><a href="#">Mauris at enim</a></li>
			</ul>
		</li>
		<li><a href="#">Poker</a>
			<ul>
			<li class="first"><a href="#">Maecenas</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li class="last"><a href="#">Mauris at enim</a></li>
			</ul>
		</li>
		<li class="last"><a href="#">Skill Games</a>
			<ul>
			<li class="first"><a href="#">Maecenas</a></li>
			<li><a href="#">Phasellus</a></li>
			<li><a href="#">Mauris sollicitudin</a></li>
			<li class="last"><a href="#">Mauris at enim</a></li>
			</ul>
		</li>
		</ul>
	</div>
	<div id="cb-wrap-1">
<?php
	//Start session
	session_start();
	include ('class.Form_pool.php'); 
	include ('form_utils.php');
	define('WRITE_DB', '1');
	define('WRITE_FORM', '0');

	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) 
	{
		header("location: index1.php");
		exit();
	}

	echo "<hr />";
	echo "</div>";

	echo "<h1>Confirmation.  Need to test write to database</h1>";

	$pool_ids = $_POST['pool_id_arr'];
	$acct_ids = $_POST['acct_id_arr'];
	$k = 0;
	while (list ($key,$val) = @each ($pool_ids)) 	
	{
//		echo "$key" . ", " . "$val" . "<br>";
		$k++;
	}
	echo "<h1>Piss Off!<br /></h1>\n";

	$boxes = $_POST['pwp_game1'];
	echo "<p>";
	while (list ($key,$val) = @each ($boxes)) 	
	{
		echo "$key, $val" . "<br />";  // these are the rot_id's that have been checked from pwp_game1 - all games on the page under pwp's
	}
	echo "</p>";
	echo "<h1>Begin Now!<br /></h1>\n";
	echo "<p><br /></p>\n";
// yo mtf, right here, shnooze.
	if(!isset($_POST['total_games']) || (trim($_POST['total_games']) == ''))
	{
//		echo "Error! The total_games is " . "$_POST['total_games']" . "<br>";
		$total_games = 3;		
	}
	else
	{
		$total_games = intval($_POST['total_games']);
	}

	echo "<p>";
	$k = 0;
	$tbets = 0;
	$tbets1 = 0;
	$lm = 0;
	$pool_obj_arr = array();

	require_once('config.php');
	$mysqli2 = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if (mysqli_connect_errno())  // uese to have $conn
	{
		die('Failed to connect to server2: ' . mysqli_connect_error());
	}
	if (intval(constant("WRITE_FORM")) == 1)
	{
		echo "<form action='bet_receipt_2.php' method='post' class='f-wrap-100'>\n";
		echo "<div id='pool_view'>\n";
	}

	for ($i=0; $i<$total_games; $i++)
	{

		$bet_str1 = 'betbox_e1_game' . strval($i+1);
		$bet_str2 = 'betbox_e2_game' . strval($i+1);
		$bet_str3 = 'betbox_e3_game' . strval($i+1);

		$val1 = $_POST[$bet_str1];
		$val2 = $_POST[$bet_str2];
		$val3 = $_POST[$bet_str3];

		echo "Game " . strval($i+1) . "<br>";
		for ($j=0; $j<4; $j++)
		{
			$pool_id = $pool_ids[$k];
			$acct_id = $acct_ids[$k];
			if ($j == 3)
			{
				$type_str = 'ou';
				$num_ents = 2;
			}
			else if ($j == 2)
			{
				$type_str = 'pwp';
				$num_ents = 3;
			}
			else if ($j == 1)
			{
				$type_str = 'ml';
				$num_ents = 2;
			}
			else
			{
				$type_str = 'sp';
				$num_ents = 2;
			}
			$pool_size_str = 'pool_size_' . $type_str . '_game' . strval($i+1);
			$pss = $_POST[$pool_size_str];
			$obj_sp = new Form_pool($pool_id, $acct_id, $i+1, $type_str, $pss, $num_ents, $tbets);
			$obj_sp->printValidBets($k+1);

			$tbets1 = $obj_sp->getNumBets();
			$tbets += $tbets1;
			if ($tbets1 > 0)
			{
				$pool_obj_arr[$lm] = $obj_sp;

//				if ((WRITE_FORM == '1') && ($obj_sp->isValidBet($pool_size)))
//    			$qry1a = "SELECT account.balance FROM account WHERE account.account_id='" . "$obj_sp->iAcct_id" . "'";
//    			$qry1a = "SELECT account.balance FROM account WHERE account.account_id='3168'";

				if (intval(constant("WRITE_FORM")) == 1) 
				{				
					$obj_sp->echoHiddenValues();
				}
				$lm++;
			}
			$k++;
		}
//		echo "Bet Amount = " . "$val1" . " for post variable = " . "$bet_str1" . "<br>";  // these are the rot_id's that have been checked from pwp_game1 - all games on the page under pwp's
//		echo "Bet Amount = " . "$val2" . " for post variable = " . "$bet_str2" . "<br>";  // these are the rot_id's that have been checked from pwp_game1 - all games on the page under pwp's
//		echo "Bet Amount = " . "$val3" . " for post variable = " . "$bet_str3" . "<br>";  // these are the rot_id's that have been checked from pwp_game1 - all games on the page under pwp's
	}
	echo "</p>";
	mysqli_close($mysqli2);		
	if (intval(WRITE_FORM) == 1)
	{
		echo "</div>\n";
		echo "<input type='submit' value='Submit Bet' class='f-submit' /><br />\n";
		echo "</form>\n";
	}
// yo, mtf figure out acct_id, pool_id, then figure out the WRITE_DB stuff.
/* yo mtf. next try to write to db, then we will make a separate form, yo.

			$obj_sp->makeBet(pool_acct_id, self.account_id, bet_amount);
if cus.makeBet(pool_acct_id,betSize,rot_id):
    err = 1
    print "%s. Bet Error on customer %s." % (i, cus.username)
...
procargs = (self.account_id,pool_acct_id,amount,ttype,transid)
transid2 = self.table.callBetTransaction(procargs,self.account_id)
procname = "handle_transaction8"
sqlStr = ""
try:
    cursor.callproc(procname, procargs)
//connect to database
$connection = mysqli_connect("hostname", "user", "password", "db", "port");      
//run the store proc
$result = mysqli_query($connection, "CALL StoreProcName") or die("Query fail: " . mysqli_error());  
    //loop the result set
    while ($row = mysqli_fetch_array($result)){     
        echo $row[0] . " - " . + $row[1];   
    }
    */

		// makePool objects again.

	if (intval(constant("WRITE_DB")) == 1)
	{
		require_once('config.php');

		//Array to store validation errors
		$errmsg_arr = array();

		//Validation error flag
		$errflag = false;
		
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		if (mysqli_connect_errno())  // uese to have $conn
		{
			die('Failed to connect to server: ' . mysqli_connect_error());
		}
		$obj_arr_len = count($pool_obj_arr);
		$procname = "";
		echo "Len PoolObj's = " . $obj_arr_len . "<br>";
		for ($i=0; $i<$obj_arr_len; $i++)
		{
			$fp_obj = $pool_obj_arr[$i];
			$self_acct_id = $_SESSION['SESS_ACCOUNT_ID'];
			$pool_acct_id = $fp_obj->iAcct_id;
			$num_bets = $fp_obj->getNumBets();

			for ($j=0; $j<$num_bets; $j++)
			{
				$bet_amount = $fp_obj->getBetAmount($j);
				$pick_entry1 = $fp_obj->getRotId($j);

				$ttype = 3;
				$bstatus = 2;
				$transid = 0;
				echo "Inside Loop " . strval($i+1) . ". pool_acct_id = " . $pool_acct_id . ". self_acct_id = " . $self_acct_id . ".<br>";
				$test_var1 = count($fp_obj->pick_rot_id_arr);
				$test_var2 = $fp_obj->pick_rot_id_arr[$j];
				echo "Debug: rot_id_arr_size = " . strval($test_var1) . ". " . strval($test_var2) . ".<br>";
				if (($pick_entry1 > 0) && ($bet_amount != "0"))
				{
       				$procname = "handle_transaction9";	
       				$qry1 = "CALL " . $procname . "(" . $self_acct_id . "," . $pool_acct_id . "," . $bet_amount . "," . $ttype . "," . $pick_entry1 . ", @transid3)";
//       				$qry1 = "CALL " . $procname . "(" . $self_acct_id . "," . $pool_acct_id . "," . $bet_amount . "," . $ttype . ", @transid3)";
       				$qry2 = "SELECT @transid3";
       				// use this for queries. $qry3 = "SELECT bet.status FROM bet WHERE bet.bet_id>='10950'";
       				echo $qry1 . "<br />";
       				echo $qry2 . "<br />";
			
//					$mysqli->autocommit(FALSE);
					$rs = $mysqli->query( $qry1 );
					$rs3 = $mysqli->query( $qry2 );
					if ($rs3 === false)
					{
						echo "Error! <br />";
					}
					else if($rs3->num_rows > 0) 
					{
						$jk = 0;
						while($row = $rs3->fetch_assoc()) 
						{
							if ($jk == 0)
							{
								$transid = $row['@transid3'];
								echo "Transid = " . $transid . "<br />";
							}
							else
							{
								echo "Error. Jk = " . $jk . "<br />";	
							}
			
// later, for pick 6       						$qry4 = "INSERT INTO bet(bet.trans_id, bet.status, bet.pick_entry1) VALUES (" . $transid . ", " . $bstatus . ", " . $pick_entry1 . ")";
       						//echo $qry4 . "<br />";
							//$rs4 = $mysqli->query( $qry4 );
							//if ($rs4 === false)
							//{
							//	echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
							//}
							//else
							//{
							//	$mysqli->commit();  //yo, mtf. Might need to remove the commit from the stored procedure.
							//}
							$jk++;
						}						
					}
					else 
					{
						echo 'NO RESULTS <br />';	
					}
// mtf TODO get balance and status too.
// mtf TODO and do handle_transaction4 ...
//yo, mtf. handle result.
			//yo, mtf. break for now.
				}  // end of if pick_entry1
				else
				{
					echo "Pick Your Nose Entry = " . $pick_entry1 . ", " . $bet_amount . "<br />";					
				}
			}  // end of for loop
			echo "Outside Loop<br />";
		}
		mysqli_close($mysqli);		
	}

// Next, finish bet, commit. yo and shnooze. then do confirmation page.
/*
do this python code but do it in php :

            rettup = cursor.fetchone()
            if rettup:
                retval = int(rettup[0])
                self.conn.commit()
            cursor.close()
            if acct_id:
                retval = self.getLatestTransid(acct_id)
        return retval

and this:
self.conn.commit()
    def getLatestTransid(self, acct_id=0, bet=1):
        trans_id = 0
        if bet:
            a_str = "from"
        else:
            a_str = "to"
        if acct_id:
            cur2 = self.conn.cursor()
            sqlStr = "SELECT trans_id FROM transaction WHERE " + a_str + "_acct_id=" + str(acct_id) + " ORDER BY trans_id DESC LIMIT 1"            
            cur2.execute(sqlStr)
            rettup = cur2.fetchone()
            if rettup:
                trans_id = int(rettup[0])
            cur2.close()
        return trans_id

*/
	if ((intval($_POST['$betbox_e2_game1']) <= 0) || (intval($_POST['$betbox_e2_game1']) > 2000))
	{
		echo "shits and sharts!!!<br />";
	}	
	else
	{	
		echo $_POST['$betbox_e2_game1'] . "<br />";
	}
	echo $_POST['$betbox_e3_game1'] . "<br />";

	echo $game_desc_id . "<br />";
	echo $customer_id . "<br />";
	echo $entry1_rot . "<br />";
	echo $entry2_rot . "<br />";
	echo "<h4>shan't shart shorts!</h4><br />";
	echo "<h1>Leave Now!<br />\n";
//	echo "Box 1 = $" . $entry2_rot . "<br />";	
?>			
	<div id="footer">
	<p>A note here to go in the footer</p>
	<p><a href="#">Contact Us</a> | <a href="#">Privacy</a> | <a href="#">Links</a></p>
	</div>
			
	</div>
	</body>
<?php
	session_write_close();
	exit();
?>			
	</html>