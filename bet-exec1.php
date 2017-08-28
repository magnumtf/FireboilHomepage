<?php
$form_games_arr = array('game_desc_id_1','game_desc_id_2','game_desc_id_3','game_desc_id_4','game_desc_id_5','game_desc_id_6',
'game_desc_id_7','game_desc_id_8','game_desc_id_9','game_desc_id_10','game_desc_id_11','game_desc_id_12','game_desc_id_13',
'game_desc_id_14','game_desc_id_15','game_desc_id_16','game_desc_id_17','game_desc_id_18','game_desc_id_19','game_desc_id_20');

>>>>

rows
pools
game
	entrys
	pools

slip:
	game
	betbox_1
	betbox_2
	betbox_3
	
what needs to go to server.

make a bet:  cus.makeBet(pool_acct_id,betSize,rot_id):

    # mtf todo, in gu_top add acct_id and send it as a hidden, along with
 	procargs = (self.account_id,pool_acct_id,amount,ttype,transid)      

>>>>
include ('class.Time.php');  
class bet_form_2
{        
	var $iGame_desc_id;
	var $iRot_id_1;
	var $iRot_id_2;
	var $iRot_id_3;
	var $iGame_type;
	var $iDisplay_type;
	var $fBet_amount_1;
	var $fBet_amount_2;
	var $fBet_amount_3;
	var $bCheckbox_spr_rot_id_1;
	var $bCheckbox_spr_rot_id_2;
	var $bCheckbox_pwp_rot_id_1;
	var $bCheckbox_pwp_rot_id_2;
	var $bCheckbox_pwp_rot_id_3;
	var $bCheckbox_ml_rot_id_1;
	var $bCheckbox_ml_rot_id_2;
	var $bCheckbox_ou_rot_id_over;
	var $bCheckbox_ou_rot_id_under;	
  
	function __construct($gdi = 0, $rid1 = 0, $rid2 = 0 , $rid3 = 0, $fba1 = 0.0, $fba2 = 0.0, $fba3 = 0.0, $dt = 0)
	{
		$this->$iGame_desc_id = $gdi;
		$this->$bCheckbox_spr_rot_id_1 = FALSE;
		$this->$bCheckbox_spr_rot_id_2 = FALSE;
		$this->$bCheckbox_pwp_rot_id_1 = FALSE;
		$this->$bCheckbox_pwp_rot_id_2 = FALSE;
		$this->$bCheckbox_pwp_rot_id_3 = FALSE;
		$this->$bCheckbox_ml_rot_id_1 = FALSE;
		$this->$bCheckbox_ml_rot_id_2 = FALSE;
		$this->$bCheckbox_ou_rot_id_over = FALSE;
		$this->$bCheckbox_ou_rot_id_under = FALSE;

		$this->$fBet_amount_bbox_1 = $fba1;
		$this->$fBet_amount_bbox_2 = $fba2;
		$this->$fBet_amount_bbox_3 = $fba3;
		
		$this->$iRot_id_1 = $rid1;
		$this->$iRot_id_2 = $rid2;
		$this->$iRot_id_3 = $rid3;
		
		$this->$iGame_type = 0;  // I'm not sure what this is for, a 2 entry sports bet, 6 entry pick 6, multi-entry perhams I dont know.
		$this->$iDisplay_odds = $dt; // this should be for display type, the last thing. 0 means american, 1 means decimal type,2 means fractional,  5 means override.
		
		$this->$fOdds_spr_1 = 0.0;
		$this->$fOdds_spr_2 = 0.0;
		$this->$fOdds_pwp_1 = 0.0;
		$this->$fOdds_pwp_2 = 0.0;
		$this->$fOdds_pwp_3 = 0.0;
		$this->$fOdds_ml_1 = 0.0;
		$this->$fOdds_ml_2 = 0.0;
		$this->$fOdds_ou_over = 0.0;
		$this->$fOdds_ou_under = 0.0;

		$this->$fBet_amount_spr_1 = 0.0;
		$this->$fBet_amount_spr_2 = 0.0;
		$this->$fBet_amount_pwp_1 = 0.0;
		$this->$fBet_amount_pwp_2 = 0.0;
		$this->$fBet_amount_pwp_3 = 0.0;
		$this->$fBet_amount_ml_1 = 0.0;
		$this->$fBet_amount_ml_2 = 0.0;
		$this->$fBet_amount_ou_over = 0.0;
		$this->$fBet_amount_ou_under = 0.0;
	}
      
	function validate()
	{  
		$this->sTime = gmdate("d-m-Y H:i:s");  
	}  
      
	function sendForm()
	{  
		$this->sTime = gmdate("d-m-Y H:i:s");  
	}  

	function setDisplayOdds($val)
	{  
		$this->$iDisplay_odds = $val;  
	}  

	function getDisplayType($type, $ind)
	{
		// 0 is american, 1 is decimal, 2 fractional, 5 is override
		if do = american and odds < 1.0 then retval = 1
		$retval = 0;
		$retodds = 20.0;
		if (strcmp($type, 'spr') == 0)
		{
yo mtf
			if ( $ind == 1 )
			$retodds = $this->
		}
	
		$this->$iDisplay_odds = $val;  
	}

	function setCheckbox($ind, $type, $val)
	{
		if (strcmp($type, 'spr') == 0)
		{
			if ($ind == 1)
			{
				if ($val)
					$this->$bCheckbox_spr_rot_id_1 = TRUE;
				else
					$this->$bCheckbox_spr_rot_id_1 = FALSE;
			}
			else if ($ind == 2)
			{
				if ($val)
					$this->$bCheckbox_spr_rot_id_2 = TRUE;
				else
					$this->$bCheckbox_spr_rot_id_2 = FALSE;
			}
		}
		else if (strcmp($type, 'pwp') == 0)
		{
			if ($ind == 1)
			{
				if ($val)
					$this->$bCheckbox_pwp_rot_id_1 = TRUE;
				else
					$this->$bCheckbox_pwp_rot_id_1 = FALSE;
			}
			else if ($ind == 2)
			{
				if ($val)
					$this->$bCheckbox_pwp_rot_id_2 = TRUE;
				else
					$this->$bCheckbox_pwp_rot_id_2 = FALSE;
			}
			else if ($ind == 3)
			{
				if ($val)
					$this->$bCheckbox_pwp_rot_id_3 = TRUE;
				else
					$this->$bCheckbox_pwp_rot_id_3 = FALSE;
			}
		}
		else if (strcmp($type, 'ml') == 0)
		{
			if ($ind == 1)
			{
				if ($val)
					$this->$bCheckbox_ml_rot_id_1 = TRUE;
				else
					$this->$bCheckbox_ml_rot_id_1 = FALSE;
			}
			else if ($ind == 2)
			{
				if ($val)
					$this->$bCheckbox_ml_rot_id_2 = TRUE;
				else
					$this->$bCheckbox_ml_rot_id_2 = FALSE;
			}
		}
		else if (strcmp($type, 'ou') == 0)
		{
			if ($ind == 1)
			{
				if ($val)
					$this->$bCheckbox_ou_rot_id_over = TRUE;
				else
					$this->$bCheckbox_ou_rot_id_over = FALSE;
			}
			else if ($ind == 2)
			{
				if ($val)
					$this->$bCheckbox_ou_rot_id_under = TRUE;
				else
					$this->$bCheckbox_ou_rot_id_under = FALSE;
			}
		}
	}  

	function setCurrentOdds($ind, $type, $val)
	{
		if (strcmp($type, 'spr') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_spr_1 = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_spr_2 = $val;
			}
		}
		else if (strcmp($type, 'pwp') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_pwp_1 = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_pwp_2 = $val;
			}
			else if ($ind == 3)
			{
				$this->$fOdds_pwp_3 = $val;
			}
		}
		else if (strcmp($type, 'ml') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_ml_1 = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_ml_2 = $val;
			}
		}
		else if (strcmp($type, 'ou') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_ou_over = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_ou_under = $val;
			}
		}
	}  

	function setBetAmounts()
	{
		go through each check box
			if checked:
				calc val2
				if corresponding betbox > 0.
					set bet_amout to val2.
yo, mtf
hmmmm, you need an individual display_type, based on odds, and display type, hummphp.
	look at index.php, if display_type, decimal, american, fraction, overruled.

also, need to make some changes to gu_top5_22 yo.


	
		if (strcmp($type, 'spr') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_spr_1 = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_spr_2 = $val;
			}
		}
		else if (strcmp($type, 'pwp') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_pwp_1 = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_pwp_2 = $val;
			}
			else if ($ind == 3)
			{
				$this->$fOdds_pwp_3 = $val;
			}
		}
		else if (strcmp($type, 'ml') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_ml_1 = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_ml_2 = $val;
			}
		}
		else if (strcmp($type, 'ou') == 0)
		{
			if ($ind == 1)
			{
				$this->$fOdds_ou_over = $val;
			}
			else if ($ind == 2)
			{
				$this->$fOdds_ou_under = $val;
			}
		}
	}  

	function setCurrentOdds
	
	setBetAmounts
	
	getter functions, yep, yep, yep.
	
	function ShowFutureDate($iAddDays=0)
	{  
		$this->sTime = gmdate("d-m-Y H:i:s", strtotime("+" . $iAddDays . " days"));  
	}  
}  

create a class called bet_entry_form
class bet_entry_form:
	game_desc_id
	rot_id1
	rot_id2
	rot_id3
	game_type
	bet_amount_rot_id1
	bet_amount_rot_id2
	bet_amount_rot_id3
	spr_rot_id1_box
	spr_rot_id2_box
	pwp_rot_id1_box
	pwp_rot_id2_box
	pwp_rot_id3_box
	ml_rot_id1_box
	ml_rot_id2_box
	ou_rot_id1_box
	ou_rot_id2_box
	displayType
constructor()
validateForm()
(have some client side validation yo)
sendForm()
confirmWagerWithPassword()
submitWagerAndGoBackToPreviousScreen()



After validation, go through the post array
	if trim($_POST['GAME_DESC_ID']) == '')) || isset:
		then end.
	else createObject.
		obj.validate()
			do something()
		
	yo mtf, this is where all the action starts
	//Start session
	session_start();
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == ''))
	{
		header("location: access-denied.php");
		exit();
	}	
	define("SPREAD", 1);	
	define("MONEYLINE", 2);	
	define("PWP", 3);	
	define("OVER_UNDER", 4);	
	define("TEAM_OVER_UNDER", 5);	
	define("MULTI_ENTRY", 6);	
	define("META_GAME", 7);	

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


	//Function to sanitize values received from the form. Prevents SQL injection
	//What to check for on client side:
	//    mtf todo, make javascript that:
	//		1. if the rows have any checks, the betbox is filled out with a valid number.
	//      2. if the betbox is filled with a valid number, there must be at least one check in that row.
	//		both conditions have to be true: a is at least one check, be is a valid number in the check box.
	//		at least one check AND a valid number for each row.
function validateForm()
{
	// mtf todo add a name for the bet form.
	// betFormNFL_attribute - attribute can be gameNum, gameData frobably
	// betFormGameDate_gameType
	var x=document.forms["myForm"]["fname"].value;
	var fname = "betFormGameDate_gameType";
	var strGame_desc_id1 = "game_desc_id";
	var strGame_desc_id2;
	var retval = true;
	var oddsDisplay = 1;

	for (var i=0; i<20;i++)
	{
		strGame_desc_id2 = concat(strGame_desc_id1, strval(i+1));
		var x = document.forms[fname][strGame_desc_id2].value;
		if (x==null || x=="")
  		{
  			break;
  		}
  		// if here check for rows and betbox:
  			// so this is what you are checking: if check and not valid betbox: set retval = false and pop an alert 
  		count checks.
var x=document.getElementById("bike").checked;

for (i=0; i<document.test.checkgroup.length; i++){
if (document.test.checkgroup[i].checked==true)
alert("Checkbox at index "+i+" is checked!")
  		name='spread_game1[]



  				alert("Not a valid e-mail address");
  				retavl = false;
  			if not check and something in betbox: keep going.
  	}

  	also, calculate total bet and that there is enough money in account, yo.

}

object: betForm:
attributes
	betType
	displayOdds

	betEntry:
		gameName
		gameNumber
		rowEntry:
			rot_id
			row_number
			betAmount

			attributes:
				bEntry:
					type: ml, spread ...
					checked
			method validate():
			





	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values, login, password, page_id
	$game_desc_id = clean($_POST['game_desc_id']);
	$customer_id = $_SESSION['SESS_MEMBER_ID'];
	$customer_account_id = $$_SESSION['SESS_ACCOUNT_ID'];
	$entry1_rot = clean($_POST['rot_id_e1_game1']);
	$entry2_rot = clean($_POST['rot_id_e2_game1']);
	
	if(!isset($_POST['betbox_e1_game1']) || (trim($_POST['betbox_e1_game1']) == ''))
	{
		$bet_amount_e1 = 0.0;
	}
	else
	{
		$bet_amount_e1 = floatval(clean($_POST['betbox_e1_game1']));
	}
	
	if(!isset($_POST['betbox_e2_game1']) || (trim($_POST['betbox_e2_game1']) == ''))
	{
		$bet_amount_e2 = 0.0;
	}
	else
	{
		$bet_amount_e2 = floatval(clean($_POST['betbox_e2_game1']));
	}
	if(!isset($_POST['betbox_e3_game1']) || (trim($_POST['betbox_e3_game1']) == ''))
	{
		$bet_amount_e3 = 0.0;
	}
	else
	{
		$bet_amount_e3 = floatval(clean($_POST['betbox_e3_game1']));
	}
	
// get a list of pools associated with game_desc_id

	$qry="SELECT pool_id, type, account_id FROM pool WHERE game_desc_id='$game_desc_id'";
	$result=mysql_query($qry);
>>>>
class Bet
{
  public $customer_account_id;
  public $pool_account_id;
  public $amount;
  public $pool_type;
  public $pick_entry1;  
  public $pick_entry2;  
  public $pick_entry3;  
  public $pick_entry4;  
  public $pick_entry5;  
  public $pick_entry6;


  public function __construct($c_id,$p_id,$amt,$typ,$pick_e1)    // Require first and last names when INSTANTIATING
  {
    $this->customer_account_id = $c_id;
    $this->pool_account_id = $p_id;
    $this->amount = $amt;
    $this->type = $typ;
    $this->type = $pick_e1;
  }

  public function __toString()
  {
    return "User";
  }
}


Now try it again.


$user_1 = new User('John', 'Doe');      // $user_i is an INSTANCE of User 
$user_2 = new User('Jane', 'Doe');      // $user_2 is an INSTANCE of User
echo $user_1 . '<br>';                  // prints: User [first='John', last='Doe']
echo $user_2 . '<br>';                  // prints: User [first='Jane', last='Doe']
>>>>>
	
	//Check whether the query was successful or not
	if($result) 
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
    		echo $row['pool_id'];
    		echo $row['type'];
    		echo $row['account_id'];
			pool is not associateed with a row, a pool is a column.
			we have a pool. find all checkboxes and amounts that belong to this pool_id and start a bet.
			row 1.
			for (i=0; i<3; i++)
			{
				// row 1
				if ($bet_amount_e1 > 0)
				{
					
				}
			}
				is there a bet_amount_e1?
					y:
						if ($row['type'] == SPREAD)
							is there a checkbox for e1?
								y:
									add to bet array: c_account_Id,p_account_id,amt,SPREAD,rot_id1)
								n:
									continue
                        ... rest of pools.
					n:
						continue 
		}

		// Free the resources associated with the result set
		// This is done automatically at the end of the script
		mysql_free_result($result);



go through each loopy:

		if(mysql_num_rows($result) == 1) 
		{
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['customer_id'];
			$_SESSION['SESS_ACCOUNT_ID'] = $member['account_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $member['lastname'];
			$_SESSION['SESS_BALANCE'] = 1000;
			$_SESSION['SESS_STATUS'] = $member['status'];
			$_SESSION['SESS_LAST_PAGE'] = $page_id;
			$_SESSION['SESS_ADMIN_LEVEL'] = $member['admin_level'];
	
	
function FindAllPools($entrynum,$pool_arr)
{
	$my_data = array();
	$my_data[] = $entrynum + 1;
	$my_data[] = $entrynum + 2;
	$my_data[] = $entrynum + 3;
	$my_data[] = $entrynum + 4;
	
return an array of pool_ids. hmmm shnooze.
	 
	return $my_data;
}
//	is there a bet in bet box 1 ?
//	or find the pools that are associated with the game_desc.
//		y: find all pools that have an e1
//		n: go to next one:
//	return a 	
	find all tings jandy from pool.
	
?>
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
		<div id="content">

<h1> Hey there ! </h1>
<?php
	$pool_arr = array();
	$pool_arr = FindAllPools(1);
	print_r($pool_arr);

	$boxes = $_POST['pwp_game1'];
	while (list ($key,$val) = @each ($boxes)) 	
	{
		echo "$val,";
	}
	echo "<br />\n";
	
	echo $bet_amount_e1 . "<br />";
	if (($bet_amount_e2 <= 0) || ($bet_amount_e2 > 2000.0))
	{
		echo "shits and sharts!!!<br />";
	}	
	else
	{	
		echo $_POST['betbox_e2_game1'] . "<br />";
	}
	echo $_POST['betbox_e3_game1'] . "<br />";

	echo $game_desc_id . "<br />";
	echo $customer_id . "<br />";
	echo $entry1_rot . "<br />";
	echo $entry2_rot . "<br />";
	echo "<h4>shan't shart shorts!</h4><br />";
//	echo "Box 1 = $" . $entry2_rot . "<br />";	
?>
</div>
</div>
</body>
</html>
<?php
				session_write_close();
				exit();
?>
