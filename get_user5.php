<?php
// probably dont use, just do convert odds
function calculateOdds($entry_pool,$total_pool,$odds_type,$max_odds)
{
// $odds_type 0 american, 1 decimal, 2 fraction
if (($odds_type > 2) || ($odds_type < 0))
{
	$odds_type = 0;
}
if ($entry_pool == 0.0)
	$ret_odds = $max_odds;
else
	$ret_odds = ($total_pool - $entry_pool) / $entry_pool;

if ($odds_type == 0)
{
	if ($ret_odds <= 1.0)
	{
		$ret_odds = -(1.0 / $ret_odds);
		$ret_string = strval(round(100 * $ret_odds,0));
	}
	else
	{
		$ret_string = "+" . strval(round(100*$ret_odds,0));
	}
}
else if ($odds_type == 2) // fraction stuff here
{
	$ret_string = "catsbigolevaggy";
}
else
{
	$ret_string = strval(round($ret_odds,2));
}
return $ret_string;
}

function covenvertOdds($entry_odds,$odds_type)
{
// $odds_type 0 american, 1 decimal, 2 fraction
if (($odds_type > 2) || ($odds_type < 0))
{
	$odds_type = 0;
}

if ($entry_odds == 0.0)
{
	$entry_odds = 1000;
}
if ($odds_type == 0)
{
	if ($entry_odds <= 1.0)
	{
		$ret_odds = -(1.0 / $entry_odds);
		$ret_string = strval(round(100 * $ret_odds,0));
	}
	else
	{
		$ret_string = "+" . strval(round(100*$entry_odds,0));
	}
}
else if ($odds_type == 2) // fraction stuff here
{
	$ret_string = "catsbigolevaggy";
}
else
{
	$ret_string = strval(round($entry_odds,2));
}
return $ret_string;
}

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
	mysqli_close($link);  // put at end of file

// get all table info from table
	$gamename = "Sat, Feb 06, 2012 at 4:15 PM EST";  //from game_desc, need game_id;
	$entry1_rot = 101;   //entry1 from game desc
	$entry2_rot = 102;   //entry2 from game desc
	$entry1_name = "New York Giants"; //from entry table, use rot
	$entry2_name = "New England Patriots";
//	who is the favorite ?
	$favorite = 102; //from game_desc
	$point_spread = 3; // game_desc
	if ($point_spread == 0)
	{
		$point_spread1 = 'pk';
		$point_spread2 = 'pk';
	}	
	elseif ($favorite == $entry1_rot)
	{
		$point_spread1 = '-' . strval($point_spread);
		$point_spread2 = '+' . strval($point_spread);
	}
	else
	{
		$point_spread1 = '+' . strval($point_spread);
		$point_spread2 = '-' . strval($point_spread);
	}
	$total_pool = 1000.0; // a join from accounts and pool.
	$entry1_pool = 550.0; // a join from accounts and pool.
	$entry2_pool = 450.0; // a join from accounts and pool.
// 	yo format strings, odds_type yo
//	$odds_type = $_SESSION['SESS_ODDS_DISPLAY'];
	$odds_type = 1; // american
	$entry1_odds = calculateOdds($entry1_pool, $total_pool, $odds_type, 20);
	$entry2_odds = calculateOdds($entry2_pool, $total_pool, $odds_type, 20);

//	moneyle
	$total_pool_ml = 1000.0; // a join from accounts and pool.
	$entry1_pool_ml = 350.0; // a join from accounts and pool.
	$entry2_pool_ml = 650.0; // a join from accounts and pool.
	$entry1_odds_ml = calculateOdds($entry1_pool_ml, $total_pool_ml, $odds_type, 50);
	$entry2_odds_ml = calculateOdds($entry2_pool_ml, $total_pool_ml, $odds_type, 50);
	
//	PWP
	$favorite_pwp = 102; //from game_desc
	$point_spread_pwp = 3; // game_desc
	if ($favorite_pwp == $entry1_rot)
	{
		$point_spread1_pwp = '-' . strval($point_spread_pwp);
		$point_spread2_pwp = '+' . strval($point_spread_pwp);
	}
	else
	{
		$point_spread1_pwp = '+' . strval($point_spread_pwp);
		$point_spread2_pwp = '-' . strval($point_spread_pwp);
	}
	$total_pool_pwp = 1000.0; // a join from accounts and pool.
	$entry1_pool_pwp = 305.0; // a join from accounts and pool.
	$entry2_pool_pwp = 605.0; // a join from accounts and pool.
	$entry3_pool_pwp = 90.0; // a join from accounts and pool.
	$entry1_odds_pwp = calculateOdds($entry1_pool_pwp, $total_pool_pwp, $odds_type, 500);
	$entry2_odds_pwp = calculateOdds($entry2_pool_pwp, $total_pool_pwp, $odds_type, 500);	
	$entry3_odds_pwp = calculateOdds($entry3_pool_pwp, $total_pool_pwp, $odds_type, 500);

// output table value to send to ajax
  	  echo "<div id='pool_view'>\n";
	  	echo "<table class='tabley'>\n";
		echo "<caption><strong>FireBoil Odds</strong></caption>\n";
	  	echo "<tr>";
			echo "<th colspan='7'; id='gameName'>" . "$gamename" . "</th>\n";
		echo "</tr>\n";
	  	echo "<tr>\n";
			echo "<th id='rot'>Rot</th>\n";
			echo "<th id='teamName'>Team</th>\n";
			echo "<th id='pointSpread'>Point Spread</th>\n";
			echo "<th id='pointSpread'>Moneyline</th>\n";
			echo "<th id='pointSpread'>PWP</th>\n";
			echo "<th id='ouHeaderLeft'></th>\n";
			echo "<th id='ouHeaderRight'>Total</th>\n";
		echo "</tr>\n";
		echo "<tr>\n";
			echo "<td>" . "$entry1_rot" . "</td>\n";
			echo "<td>" . "$entry1_name" . "</td>\n";
			echo "<td id='odds'><label class='bfd' for='genre2'>" . "$point_spread1" . " " . "$entry1_odds" . "</label><input type='checkbox' name='genre2' value='100odds' /></td>\n";
			echo "<td id='odds'><label class='bfd' for='genre'>" . "$entry1_odds_ml" . "</label><input type='checkbox' name='genre' value='101odds' /></td>\n";
			echo "<td id='odds'><label class='bfd' for='genre7'>" . "$point_spread1_pwp" . " " . "$entry1_odds_pwp" . "</label><input type='checkbox' name='genre7' value='107odds' /></td>\n";
			echo "<td rowspan='2'; id='overUnderNumber'>53.5</td>\n";
			echo "<td rowspan='2'; id='overUnder'><label id='overUnderLabel' for='genre3'><span class='bfd'>O</span> +210</label><input type='checkbox' name='genre3' value='overUnderOdds1' />\n";
			echo "<br />\n";
			echo "<label id='overUnderLabel' for='genre4'><span class='bfd'>U</span> +190</label><input type='checkbox' name='genre4' value='overUnderOdds2' /></td>\n";
		echo "</tr>\n";

		echo "<tr>\n";
			echo "<td>" . "$entry2_rot" . "</td>\n";
			echo "<td>" . "$entry2_name" . "</td>\n";
			echo "<td id='odds'><label class='bfd' for='genre5'>" . "$point_spread2" . " " . "$entry2_odds" . "</label><input type='checkbox' name='genre5' value='102odds' /></td>\n";
			echo "<td id='odds'><label class='bfd' for='genre6'>" . "$entry2_odds_ml" . "</label><input type='checkbox' name='genre6' value='100odds' /></td>\n";
			echo "<td id='odds'><label class='bfd' for='genre8'>" . "$point_spread2_pwp" . " " . "$entry2_odds_pwp" . "</label><input type='checkbox' name='genre8' value='108odds' /></td>\n";
		echo "</tr>\n";

		echo "<tr>\n";
			echo "<td></td>\n";
			echo "<td></td>\n";
			echo "<td></td>\n";
			echo "<td></td>\n";
			echo "<td id='odds'><label class='bfd' for='genre9'>" . "Push" . " " . "$entry3_odds_pwp" . "</label><input type='checkbox' name='genre9' value='109odds' /></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br />\n";
  	  echo "</div>\n";
?> 
