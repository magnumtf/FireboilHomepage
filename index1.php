<?php
	//Start session
	session_start();
	
//  mtf index1 remove
	$_SESSION['SESS_FIRST_NAME'] = "";
	$_SESSION['SESS_MEMBER_ID'] = "";
	$_SESSION['SESS_BALANCE'] = "0";
	$_SESSION['SESS_ADMIN_LEVEL'] = "0";
	session_destroy();
//  end mtf index1
	//Check whether the session variable SESS_MEMBER_ID is present or not
//  mtf index1 add
//	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
//		header("location: index1.php");
//		exit();
//	}
// end mtf index1
// for now, use post, later make cookies.
	if(isset($_COOKIE['ppkCompareSite']))
		$setval = intval($_COOKIE['ppkCompareSite']); 
	else
	{
		$setval = 1;
	}
    $_SESSION['SESS_COMPARE_SITE'] = $setval;

	if(isset($_COOKIE['ppkDisplayOdds']))
		$setval = intval($_COOKIE['ppkDisplayOdds']); 
	else
	{
		$setval = 0;
	}
    $_SESSION['SESS_DISPLAY_ODDS'] = $setval;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--
Too convert to php, add auth.php at top and uncomment all mtf_yo_enable 's 
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
<body id="type-b" onLoad="mainLoad()"> 
<!-- onload="loadUpdateTimer(5), showUser()"> -->
<script>
myVar=window.int=self.setInterval(function(){onTimerUpdate()},4000);
showUser();
</script>

<div id="wrap">

	<div id="header">
		<div id="site-name">FireBoil</div>
		<div id="search">
			<form action="login-exec2.php" method="post">
			<label for="username" id="loginHeader"><b>Username or Email:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPassword:</b></label><br />
			<input id="username" name="username" type="text" />
			<input id="password" name="password" type="password" />
			<input type="submit" value="Sign in" class="f-submit" /><br />
			</form>
			<label for="dummy1" id="loginHeader"><a href="resetPassword.html">Forgot your password?</a></label>
			<label for="dummy2" id="loginHeader">Not a member yet? <a href="registration3.html">Join Now!</a></label>
		</div>
<!--		<div id="helloFirstname">	
			<span>
<!-- mtf index1 remove html
	echo $_SESSION['SESS_FIRST_NAME'];
	echo "<br />Available Balance $";
	echo $_SESSION['SESS_BALANCE'];
	if ($_SESSION['SESS_ADMIN_LEVEL'] >= 1)
	{
		echo "<br />";
		echo "<label for='dummy3' id='loginHeader'><a href='gs_191.php'>Admin: game setup</a></label>\n";
	}	

//	echo "<form action='index.php' method='post'>";
//		echo "<input type='submit' value='Sign out' name='logout' class='f-logout' />";
//	echo "</form>";
			<br />
			<label for="dummy1" id="logoutHeader"><a href="index1.html">Sign out</a></label>
			</span>
		</div>
-- end mtf -->
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
	</div>  <!-- end header -->
	
	<div id="content-wrap">
	
		<div id="utility">
<!-- Same as above, probably with betting games  -->
			<ul id="nav-secondary">
			<li class="first"><a href="#">Latinus Wordus</a></li>
			<li><a href="#">Catsnamus Mitenus</a></li>
			<li class="active"><a href="#">Beautus Weatherus</a>
			
				<ul>
				<li class="first"><a href="#">Letsgo Surfingus</a></li>
				<li><a href="#">Nothingo on tivio</a></li>
				<li class="active"><a href="#">Wanta a coffeo</a></li>
				<li class="last"><a href="#">Nothingo on tivio</a></li>
				</ul>
			</li>
			<li><a href="#">Bottomus Navigationus</a></li>
			<li><a href="#">Gee my neckus issore</a></li>
			<li class="last"><a href="#">Last buttus notleastus</a></li>
			</ul>
		</div>
		
		<div id="content">
		
			<div id="breadcrumb">
			<a href="homepage.php"><strong>Page Name Here</strong></a></div>  <!-- todo define homepage.php -->
			<br />	
			<img src="lr2.jpg" alt="large product photo" border="0" />		
			<br />	
			<h1>No Juice, No Vig, No Take, No House Edge!</h1>
			<h2>On the internet, everything should be free.</h2>
			<hr />
			<p>lr2 Fireboil uses market and parimutuel concepts to come up with a truly no-fee sports betting system. For any serious bettor, it would be foolish to use anything else.<br />
			See our <a href="fb_faq.html">FAQ</a> for more details behind the magic of FireBoil.
			Other reasons to try FireBoil:
			So, give FireBoil a try you retard. The difference will astound you, give us a try shan't we.
			</p>
			<hr />

<!-- test some ajax here
	<div id="myDiv"><h2>Let AJAX change this text</h2></div>
	<button type="button" onclick="loadXMLDoc()">Change Content</button>
	-->
<br />
<div id="txtHint"><b>Person info will be listed here.</b></div>
<div id="txtHint2"><b>She Shant Shart Her Shorts.</b></div>
<form>
<input type="button" value="Display timed text!" onclick="timedText()" />
<input type="text" id="txt" />
<input type="button" value="ReadCookie" onclick="testCompareSiteCookie()" />
<div id="cookie_answer"><b>Cookie Value Displayed Here.</b></div>
<br />
</form>
<input type="button" id="realTimeUpdates" value="Turn Off Real-Time Updates" onclick="myVar=turnOnRealTime(myVar)" />
<br />
<input type="text" id="clock2" />
<button onclick="myVar=window.int=self.setInterval(function(){onTimerUpdate()},4000)">Starty</button>
<br />
<input type="text" id="clock" />
<button onclick="myVar=window.clearInterval(myVar)">Stoppy</button>
<br />

<!-- mtf fb overlay form  -->
	<br />
	<p>
<!--		<form action="index.php" method="post">  -->
		<label for="form-compare">Overlay Versus </label><select name="oddsCompareSite" id="myselect" onchange="writeCompareSiteCookie(this.value)">
			<option value="1"
<?php
	if($_SESSION['SESS_COMPARE_SITE'] == 1)
	{
		echo " selected";
  	}
?>
			>Bovada Online Sportsbook</option>
			<option value="2" 
<?php
	if($_SESSION['SESS_COMPARE_SITE'] == 2)
	{
		echo " selected ";
  	}
?>
			disabled="disabled">BetUS Online Sportsbook</option>
			<option value="3"
<?php
	if($_SESSION['SESS_COMPARE_SITE'] == 3)
	{
		echo " selected";
  	}
?>
			>Caesars-Hilton Las Vegas</option>
			<option value="4" 
<?php
	if($_SESSION['SESS_COMPARE_SITE'] == 4)
	{
		echo " selected ";
  	}
?>
			disabled="disabled">MGM-Mirage Las Vegas</option>
			<option value="5"
<?php
	if($_SESSION['SESS_COMPARE_SITE'] == 5)
	{
		echo " selected";
  	}
?>
			>None</option>
		</select>&nbsp;
<!--		<input type="submit" name="compareSite" value="Submit"/>
		<form action="index.php" method="post" id="displayOddsF"> -->
		<label for="form-compare">Display Odds </label><select name="displayOddsP" id="myselectDO" onchange="writeDisplayOddsCookie(this.value)">
			<option value="0" 
<?php
	if($_SESSION['SESS_DISPLAY_ODDS'] == 0)
	{
		echo " selected";
  	}
?>
			>American</option>
			<option value="1" 
<?php
	if($_SESSION['SESS_DISPLAY_ODDS'] == 1)
	{
		echo " selected";
  	}
?>
			>Decimal</option>
			<option value="2" 
<?php
	if($_SESSION['SESS_DISPLAY_ODDS'] == 2)
	{
		echo " selected ";
  	}
?>
		disabled="disabled">Fractional</option>
		</select>
<!--		<input type="submit" id="displayOddsO" name="displayOdds" value="Submit"/> -->
	</p>
<?php
if(isset($_COOKIE['ppkCompareSite']))
	$visit = $_COOKIE['ppkCompareSite']; 
else
{
	$clen = count($_COOKIE);
	$visit = "shit" . strval($clen);
}
	
echo "Your last visit was - ". $visit;
foreach ($_COOKIE as $key => $val) {
    print "$key = $val\n";
	}
?>
	<br />
	<p>
		<label for="form-compare">Overlay Versus </label><select name="oddsCompareSite" id="myselect">
			<option>Bodog Online Sportsbook</option>
			<option>BetUS Online Sportsbook</option>
			<option>Caesar's Palace Las Vegas</option>
			<option>None</option>
		</select>&nbsp;
		<label for="form-compare">Display Odds </label><select name="displayOdds" id="myselectDO">
			<option>American</option>
			<option>Decimal</option>
			<option>Fractional</option>
		</select>
	</p>
<!-- mtf end of eb overlay form -->			
			<div class="featurebox"><h3>Feature Game July 22, 2012</h3><p> <!-- mtf needs update -->
<!-- start of fb pool views -->
	  <div id="pool_view">
<!-- call get pool vars -->
<?php require 'odd_funcs.php'; ?>
<?php
	$gamename = "4:15 PM, Wembley Stadium, Washington";  //from game_desc, need game_id;
	$gamedate = "Saturday, February 06, 2012";
	$game_desc_id = 2;
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
//	$odds_type = $_SESSION['SESS_DISPLAY_ODDS'];
	$odds_type = 1; // american
	$logged_in = 1;
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
	if ($logged_in == 0)
	{
		$colspan_gameday = "7";
		$colspan_header = "4";
		$betheader_id = "olPercent2_nd";
		$betheadergame_id = "betBoxHeaderHeader_nd";
		$bets_disabled = "DISABLED";
	}
	else
	{
		$colspan_gameday = "8";
		$colspan_header = "5";
		$betheader_id = "olPercent2";
		$betheadergame_id = "betBoxHeaderHeader";
		$bets_disabled = "";
	}
?>
			
	  	<table class="tabley">
	  	<tr>
			<th colspan=
<?php
	echo $colspan_gameday;
?>
			; id="gameDate">
<?php 
	echo $gamedate;
?>
			</th>
		</tr>
	  	<tr>
			<th id="rotHeader">Rot</th>
			<th id="teamNameHeader">Team</th>
			<th id="pointSpreadHeader">Point Spread</th>
			<th id="pointSpreadHeader">PWP</th>
			<th id="pointSpreadHeader">Moneyline</th>
			<th id="ouHeaderLeftHeader"></th>			
			<th id="ouHeaderRightHeader">Total</th>
			<th id=
<?php
	echo $betheadergame_id;
?>			
				>Amount</th>
		</tr>
		</table>
		<br />
		<form action="bet-exec1.php" method="post" class="f-wrap-100">
	  	<table class="tabley">
		<tr>
		<th colspan="3"; id="gameName">
<?php 
	echo $gamename;
?>
		</th>
<th colspan=
<?php
	echo $colspan_header;
?>
; id="gameDate">
<strong>Fireboil Current Odds</strong>
</th>
		</tr>
	  	<tr>
			<th id="rot"></th>
			<th id="teamName"></th>
			<th id="pointSpread"></th>
			<th id="pointSpread"></th>
			<th id="pointSpread"></th>
			<th id="ouHeaderLeft"></th>			
			<th id="ouHeaderRight"></th>
			<th id="betBoxHeader_nd"></th>
		</tr>
		<tr>
			<td>
<?php 
	echo $entry1_rot;
?>
<input type="hidden" name="game_desc_id" id="game_desc_id" value=
<?php 
	echo $game_desc_id;
?>
 />
<input type="hidden" name="rot_id_e1_game1" id="rot_id_e1_game1" value=
<?php 
	echo $entry1_rot;
?>
 />
<input type="hidden" name="rot_id_e2_game1" id="rot_id_e2_game1" value=
<?php 
	echo $entry2_rot;
?>
 />
			</td>
			<td id="teamNameData">
<?php 
	echo $entry1_name;
?>
			</td>
			<td id="odds"><label class="bfd-betform" for="genre2">
<?php
	echo "$point_spread1" . " " . "$entry1_odds";
?>
			</label><input type="checkbox" name="spread_game1[]" id="testchecks" value="e1" 
<?php
	echo $bets_disabled;
?>
			
			/></td>
			<td id="odds"><label class="bfd-betform" for="genre7">
<?php
	echo "$point_spread1_pwp" . " " . "$entry1_odds_pwp";
?>			
			</label><input type="checkbox" name="pwp_game1[]" value="e1" 
<?php
	echo $bets_disabled;
?>			
			/></td> 
			<td id="odds"><label class="bfd-betform" for="genre">
<?php
	echo $entry1_odds_ml;
?>
			
			</label><input type="checkbox" name="ml_game1[]" value="e1" 
<?php
	echo $bets_disabled;
?>
			
			/></td> 
			<td rowspan="2"; id="overUnderNumber">53.5</td>
			<td rowspan="2"; id="overUnder"><label id="overUnderLabel" for="genre3"><span class="bfd">O</span> +210</label><input type="checkbox" name="overunder_game1[]" value="e1" 
<?php
	echo $bets_disabled;
?>			
			/>
			<br />
			<label id="overUnderLabel" for="genre4"><span class="bfd">U</span> +190</label><input type="checkbox" name="overunder_game1[]" value="e2" 
<?php
	echo $bets_disabled;
?>
			/></td>
			<td id=
<?php
	echo $betheader_id;
?>
				><input name="betbox_e1_game1" id="betbox_e1_game1" type="text" tabindex="14" /></td>
		</tr>
		<tr>
			<td>
<?php 
	echo $entry2_rot;
?>
			</td>
			<td id="teamNameData">
<?php 
	echo $entry2_name;
?>
			</td>
			<td id="odds"><label class="bfd-betform" for="genre5">
<?php
	echo "$point_spread2" . " " . "$entry2_odds";
?>
			</label><input type="checkbox" name="spread_game1[]" value="e2" 
<?php
	echo $bets_disabled;
?>
			/></td>
			<td id="odds"><label class="bfd-betform" for="genre8">
<?php
	echo "$point_spread2_pwp" . " " . "$entry2_odds_pwp";
?>			
			</label><input type="checkbox" name="pwp_game1[]" value="e2" 
<?php
	echo $bets_disabled;
?>
			/></td>
			<td id="odds"><label class="bfd-betform" for="genre6">
<?php
	echo $entry2_odds_ml;
?>
			</label><input type="checkbox" name="ml_game1[]" value="e2" 
<?php
	echo $bets_disabled;
?>
			/></td>
			<td id=
<?php
	echo $betheader_id;
?>

				><input name="betbox_e2_game1" id="betbox_e2_game1" type="text" tabindex="14" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td id="odds"><label class="bfd-betform" for="genre9">
<?php
	echo "Push" . " " . "$entry3_odds_pwp";
?>			
			</label><input type="checkbox" name="pwp_game1[]" value="e3" 
<?php
	echo $bets_disabled;
?>
			/></td>
			<td></td>
			<td></td>
			<td></td>
			<td id=
<?php
	echo $betheader_id;
?>

				><input name="betbox_e3_game1" id="betbox_e3_game1" type="text" tabindex="14" /></td>
		</tr>
		</table>

	  	<table class="tabley">
	  	<tr>
			<th id="badRot"></th>
			<th id="badTeamName"></th>
			<th id="badPointSpread"></th>
			<th id="overlay_h2"></th>			
			<th id="badPointSpread_pwp"></th>
			<th id="overlay_h2"></th>
			<th id="badPointSpread_ml"></th>
			<th id="overlay_h2"></th>
			<th id="badOuHeaderRight"></th>
			<th id="overlay_h2"></th>
		</tr>
	  	<tr>
			<td colspan="2">Compare with current odds at: <strong>Bavada</strong></td>
			<td></td>
			<td id="overlay_data"><strong>Overlay</strong></td>			
			<td></td>
			<td id="overlay_data"><strong>Overlay</strong></td>			
			<td></td>
			<td id="overlay_data"><strong>Overlay</strong></td>
			<td></td>			
			<td id="overlay_data"><strong>Overlay</strong></td>
		</tr>
		<tr>
			<td>101</td>
			<td id="teamNameData">New York Giants</td>
			<td id="odds"><label class="bfd" for="genre2">+3 -110</label><input type="checkbox" name="genre2" value="100odds" DISABLED /></td>
			<td id="olPercent">18.2%</td>
			<td id="odds"><label class="bfd" for="genre2">-110</label><input type="checkbox" name="genre2" value="104odds" DISABLED /></td>
			<td id="olPercent">98.2%</td>
			<td id="odds"><label class="bfd" for="genre">+120</label><input type="checkbox" name="genre" value="101odds" DISABLED /></td> 
			<td id="olPercent">18.2%</td>
			<td rowspan="2"; id="overUnder"><label id="overUnderLabel" for="genre3"><span class="bfd">O</span> +190</label><input type="checkbox" name="genre3" value="overUnderOdds1" DISABLED />
			<br />
			<label id="overUnderLabel" for="genre4"><span class="bfd">U</span> +190</label><input type="checkbox" name="genre4" value="overUnderOdds2" DISABLED /></td>
			<td id="olPercent">17.9%</td>
		</tr>
		<tr>
			<td>102</td>
			<td id="teamNameData">New England Patriots</td>
			<td id="odds"><label class="bfd" for="genre5">-3 -110</label><input type="checkbox" name="genre5" value="102odds" DISABLED /></td>
			<td id="olPercent">18.2%</td>
			<td id="odds"><label class="bfd" for="genre5">-110</label><input type="checkbox" name="genre5" value="105odds" DISABLED /></td>
			<td id="olPercent">99.3%</td>
			<td id="odds"><label class="bfd" for="genre6">-140</label><input type="checkbox" name="genre6" value="100odds" DISABLED /></td>
			<td id="olPercent">18.2%</td>
			<td id="olPercent">17.8%</td>
		</tr>
		</table>
		<br />
			<input type="submit" value="Continue" class="f-submit" tabindex="12" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="button" name="Cancel" value="Cancel" onClick="clearBetFields()" /><br />
			</form>
	  </div>
		<br />
<!-- End of fireboil pool view -->
			</p></div> <!-- End of FeatureBox --->
			
			<hr />			
			<div id="footer">
			<p>A note here to go in the footer</p>
			<p><a href="#">Contact Us</a> | <a href="#">Privacy</a> | <a href="#">Links</a></p>
			</div>
			
		</div>  <!-- end of div content-wrap -->
	</div>  <!-- end of div warap -->
<!-- </div>  -->
</body>
</html>
