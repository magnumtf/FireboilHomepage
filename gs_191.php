<?php
	//Start session
	session_start();
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '') || ($_SESSION['SESS_ADMIN_LEVEL'] < 1) || !isset($_SESSION['SESS_ADMIN_LEVEL']) || (trim($_SESSION['SESS_ADMIN_LEVEL']) == ''))
	{
		header("location: access-denied.php");
		exit();
	}
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
<title>FireBoil - Game Setup</title>
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
		<div id="search">
<!---Put login here, odds display too -->
			<form action="">
			<label for="searchsite">Login, Registration, and Dislpay Odds:</label>
			<input id="searchsite" name="searchsite" type="text" />
			<input type="submit" value="Go" class="f-submit" />
			</form>
		</div>
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
			<a href="homepage.php"><strong>Admin Game Setup</strong></a></div>  <!-- todo define homepage.php -->
			<br />	
			<img src="lr2.jpg" alt="large product photo" border="0" />		
			<br />	
			<hr />
			<form id="gameSetupForm" name="gameSetupForm" class="f-wrap-1" method="post" action="gameSetup-exec.php">
						
			<fieldset>
			
			<h3>Game Setup</h3>
			
			<label for="gamename"><b>Game name:</b>
			<input id="gamename" name="gamename" type="text" class="f-name" tabindex="4" /><br />
			</label>

			<label for="game category"><b>Category/Subcategory:</b>
			<select name="game_category" id="game_category" tabindex="1">
				<option value="1">Football</option>
				<option value="2">Basketball</option>
				<option value="3">Baseball</option>
				<option value="4">Hockey</option>
				<option value="5">Horseracing</option>
				<option value="6">Nascar</option>
				<option value="7">Golf</option>
				<option value="8">Soccer</option>
			</select>
			</label>

			<label for="game_subcategory">
			<select name="game_subcategory" id="game_subcategory" tabindex="2">
				<option value="0">None</option>
				<option value="1">NFL</option>
				<option value="2">MLB</option>
				<option value="3">NBA</option>
				<option value="4">NCAA</option>
				<option value="5">Olympics</option>
			</select><br />
			</label>
			
			<label for="gametime_month"><b>Game date month:</b>
			<input id="gametime_month" name="gametime_month" type="text" class="f-name" tabindex="5" /><br />
			</label>
						
			<label for="gametime_day"><b>Game date day:</b>
			<input id="gametime_day" name="gametime_day" type="text" class="f-name" tabindex="6" /><br />
			</label>

			<label for="gametime_year"><b>Game date year:</b>
			<input id="gametime_year" name="gametime_year" type="text" class="f-name" tabindex="7" /><br />
			</label>

			<label for="gametime_hour"><b>Game time hour:</b>
			<input id="gametime_hour" name="gametime_hour" type="text" class="f-name" tabindex="8" />
			</label>

			<label for="gametime_ampm">
			<select name="gametime_ampm" tabindex="9">
				<option value="AM">AM</option>
				<option value="PM" selected="selected">PM</option>
			</select><br />
			</label>

			<label for="gametime_minute"><b>Game time minute:</b>
			<input id="gametime_hour" name="gametime_hour" type="text" class="f-name" tabindex="10" /><br />
			</label>

			<label for="num_entries"><b>Number of Entries:</b>
			<input id="num_entries" name="num_entries" type="text" class="f-name" onblur="getNumEntries()" tabindex="11" /><br />
			</label>

			<label for="entry1_name"><b>Entry 1 (Home Team):</b>
			<input id="entry1_name" name="entry1_name" type="text" class="f-name" tabindex="12" /><br />
			</label>

			<label for="entry2_name"><b>Entry 2 Name:</b>
			<input id="entry2_name" name="entry2_name" type="text" class="f-name" tabindex="13" /><br />
			</label>

			<label for="entry3_name" class="labelly-invisible" id="entry3_label"><b>Entry 3 Name:</b>
			<input id="entry3_name" name="entry3_name" type="text" class="f-name-invisible" tabindex="27" /><br />
			</label>

			<label for="entry4_name"><b>Entry 4 Name:</b>
			<input id="entry4_name" name="entry4_name" type="text" class="f-name-invisible" tabindex="28" /><br />
			</label>

			<label for="entry5_name"><b>Entry 5 Name:</b>
			<input id="entry5_name" name="entry5_name" type="text" class="f-name-invisible" tabindex="29" /><br />
			</label>

			<label for="entry6_name"><b>Entry 6 Name:</b>
			<input id="entry6_name" name="entry6_name" type="text" class="f-name-invisible" tabindex="30" /><br />
			</label>

			<label for="entry7_name"><b>Entry 7 Name:</b>
			<input id="entry7_name" name="entry7_name" type="text" class="f-name-invisible" tabindex="31" /><br />
			</label>

			<label for="entry8_name"><b>Entry 8 Name:</b>
			<input id="entry8_name" name="entry8_name" type="text" class="f-name-invisible" tabindex="32" /><br />
			</label>

			<label for="entry9_name"><b>Entry 9 Name:</b>
			<input id="entry9_name" name="entry9_name" type="text" class="f-name-invisible" tabindex="33" /><br />
			</label>

			<label for="entry10_name"><b>Entry 10 Name:</b>
			<input id="entry10_name" name="entry10_name" type="text" class="f-name-invisible" tabindex="34" /><br />
			</label>

			<label for="entry11_name"><b>Entry 11 Name:</b>
			<input id="entry11_name" name="entry11_name" type="text" class="f-name-invisible" tabindex="35" /><br />
			</label>

			<label for="entry12_name"><b>Entry 12 Name:</b>
			<input id="entry12_name" name="entry12_name" type="text" class="f-name-invisible" tabindex="36" /><br />
			</label>

			<label for="entry13_name"><b>Entry 13 Name:</b>
			<input id="entry13_name" name="entry13_name" type="text" class="f-name-invisible" tabindex="37" /><br />
			</label>

			<label for="entry14_name"><b>Entry 14 Name:</b>
			<input id="entry14_name" name="entry14_name" type="text" class="f-name-invisible" tabindex="38" /><br />
			</label>

			<label for="entry15_name"><b>Entry 15 Name:</b>
			<input id="entry15_name" name="entry15_name" type="text" class="f-name-invisible" tabindex="39" /><br />
			</label>

			<label for="entry16_name"><b>Entry 16 Name:</b>
			<input id="entry16_name" name="entry16_name" type="text" class="f-name-invisible" tabindex="40" /><br />
			</label>

			<label for="entry17_name"><b>Entry 17 Name:</b>
			<input id="entry17_name" name="entry17_name" type="text" class="f-name-invisible" tabindex="41" /><br />
			</label>

			<label for="entry18_name"><b>Entry 18 Name:</b>
			<input id="entry18_name" name="entry18_name" type="text" class="f-name-invisible" tabindex="42" /><br />
			</label>

			<label for="entry19_name"><b>Entry 19 Name:</b>
			<input id="entry19_name" name="entry19_name" type="text" class="f-name-invisible" tabindex="43" /><br />
			</label>

			<label for="entry20_name"><b>Entry 20 Name:</b>
			<input id="entry20_name" name="entry20_name" type="text" class="f-name-invisible" tabindex="44" /><br />
			</label>

			<label for="point_spread"><b>Point spread:</b>
			<input id="point_spread" name="point_spread" type="text" class="f-name" tabindex="14" /><br />
			</label>

			<label for="pwp_spread"><b>PWP spread:</b>
			<input id="pwp_spread" name="pwp_spread" type="text" class="f-name" tabindex="15" /><br />
			</label>

			<label for="over_under"><b>Over under:</b>
			<input id="over_under" name="over_under" type="text" class="f-name" tabindex="16" /><br />
			</label>

			<label for="entry1_over_under"><b>Entry1 Over under:</b>
			<input id="entry1_over_under" name="entry1_over_under" type="text" class="f-name" tabindex="17" /><br />
			</label>

			<label for="entry2_over_under"><b>Entry2 Over under:</b>
			<input id="entry2_over_under" name="entry2_over_under" type="text" class="f-name" tabindex="18" /><br />
			</label>

			<label for="ass_pools"><b>Associated pools:</b>
			<input type="checkbox" name="ap_spread" value="1" tabindex="19" />spread<br />
			<input type="checkbox" name="ap_moneyline" value="2" tabindex="20" />moneyline<br />
			<input type="checkbox" name="ap_pwp" value="3" tabindex="21" />PWP<br />
			<input type="checkbox" name="ap_over_under" value="4" tabindex="22" />over under<br />
			<input type="checkbox" name="ap_team_over_under" value="5" tabindex="23" />team over under<br />
			<input type="checkbox" name="ap_spread" value="6" tabindex="24" />multi-entry<br />
			<input type="checkbox" name="ap_spread" value="7" tabindex="25" />meta-game<br />
			</label>
			
			<div class="f-submit-wrap">
			<input type="submit" value="Submit" class="f-submit" tabindex="26" /><br />
			</div>
			</fieldset>
			</form>
			
			<div id="footer">
			<p>A note here to go in the footer</p>
			<p><a href="#">Contact Us</a> | <a href="#">Privacy</a> | <a href="#">Links</a></p>
			</div>
			
		</div>		
	</div>
	
</div>
</body>
</html>