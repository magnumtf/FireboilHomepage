<?php
	//Start session
	session_start();
	//Check whether the session variable SESS_MEMBER_ID is present or not
	$_SESSION['SESS_MEMBER_ID'] = '';
	if(isset($_SESSION['SESS_MEMBER_ID']) && (trim($_SESSION['SESS_MEMBER_ID']) != '')) {
		header("location: access-denied.php");
		exit();
	}
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
<body id="type-b">
<div id="wrap">

	<div id="header">
		<div id="site-name">FireBoil</div>
<!-- mtf use this for html
		<div id="search">
			<form action="login-exec2.php" method="post">
			<label for="username" id="loginHeader"><b>Username or Email:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPassword:</b></label><br />
			<input id="username" name="username" type="text" />
			<input id="password" name="password" type="password" />
			<input type="submit" value="Login" class="f-submit" /><br />
			</form>
			<label for="dummy1" id="loginHeader"><a href="resetPassword.html">Forgot your password?</a></label>
			<label for="dummy2" id="loginHeader">Not a member yet? <a href="registration3.html">Join Now!</a></label>
		</div>
end of mtf use this -->
		<div id="helloFirstname">		
			<span>Nathaniel<br />Available Balance $10,000.51</span>
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
			<h1>No Juice, No Vig, No Take!</h1>
			<h2>On the internet, everything should be free.</h2>
			<hr />
			<p>Fireboil uses market and parimutuel concepts to come up with a truly no-fee sports betting system. For any serious bettor, it would be foolish to use anything else.<br />
			See our <a href="fb_faq.html">FAQ</a> for more details behind the magic of FireBoil.
			Other reasons to try FireBoil:
			So, give FireBoil a try you retard.
			</p>
			<hr />
<!-- test some ajax here
	<div id="myDiv"><h2>Let AJAX change this text</h2></div>
	<button type="button" onclick="loadXMLDoc()">Change Content</button>
	-->
<?php
    print "Environmental Variables Start <br />";
    foreach ($_SERVER as $var => $value) {
        echo "$var => $value <br />";
    }
    print "Environmental Variables End<br />";
?>

<form action="subscribe.php" method="post">
    <p>
        Email address:<br />
        <input type="text" name="email" size="20" maxlength="50" value="" />
    </p>

    
    <p>
        Password:<br />
        <input type="text" name="pswd" size="20" maxlength="15" value="" />
    </p>
    
    <p>
        <input type="submit" name="subscribe" value="subscribe!" />
    </p>
</form>

<form>
<select name="users" onchange="showUser(this.value)">
<option value="">Select a person:</option>
<option value="1">Peter Griffin</option>
<option value="2">Lois Griffin</option>
<option value="3">Glenn Quagmire</option>
<option value="4">Joseph Swanson</option>
</select>
</form>
<br />
<div id="txtHint"><b>Person info will be listed here.</b></div>

<!-- mtf fb overlay form  -->
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
<?php 
function grfp($fraction_part, $integer_part)
{
	$ret_val_int = 0;
	$ret_val_fract = 0.0;
	if ($integer_part >= 10)
	{
		if ($fraction_part >= 0.5)
		{
			$ret_val_int++;
		}
		$ret_val_fract = 0.0;
	}
	else if ($integer_part >= 5)
	{
		if ($fraction_part >= 0.75)
		{
			$ret_val_int++;
			$ret_val_fract = 0.0;
		} 
		else if ($fraction_part >= 0.25)
		{
			$ret_val_fract = 0.5;
		}
		else
		{
			$ret_val_fract = 0.0;
		}
	}
	else if ($integer_part >= 1)
	{
		if ($fraction_part >= 0.9)
		{
			$ret_val_int++;
			$ret_val_fract = 0.0;
		} 
		else if ($fraction_part >= 0.83)
		{
			$ret_val_fract = 0.88;
		} 
		else if ($fraction_part >= 0.78)
		{
			$ret_val_fract = 0.8;
		} 
		else if ($fraction_part >= 0.76)
		{
			$ret_val_fract = 0.77;
		} 
		else if ($fraction_part >= 0.68)
		{
			$ret_val_fract = 0.75;
		} 
		else if ($fraction_part >= 0.63)
		{
			$ret_val_fract = 0.66;
		} 
		else if ($fraction_part >= 0.58)
		{
			$ret_val_fract = 0.6;
		}
		else if ($fraction_part >= 0.53)
		{
			$ret_val_fract = 0.55;
		}
		else if ($fraction_part >= 0.48)
		{
			$ret_val_fract = 0.5;
		}
		else if ($fraction_part >= 0.43)
		{
			$ret_val_fract = 0.55;
		}
		else if ($fraction_part >= 0.38)
		{
			$ret_val_fract = 0.4;
		}
		else if ($fraction_part >= 0.28)
		{
			$ret_val_fract = 0.33;
		}
		else if ($fraction_part >= 0.24)
		{
			$ret_val_fract = 0.25;
		}
		else if ($fraction_part >= 0.21)
		{
			$ret_val_fract = 0.22;
		}
		else if ($fraction_part >= 0.16)
		{
			$ret_val_fract = 0.20;
		}
		else if ($fraction_part >= 0.11)
		{
			$ret_val_fract = 0.11;
		}
		else if ($fraction_part >= 0.05)
		{
			$ret_val_fract = 0.10;
		}
		else
		{
			$ret_val_fract = 0.0;
		}
	}
	else
	{
		if ($fraction_part >= 0.97)
		{
			$ret_val_int++;
			$ret_val_fract = 0.0;
		} 
		else if ($fraction_part >= 0.93)
		{
			$ret_val_fract = 0.95;
		} 
		else if ($fraction_part >= 0.89)
		{
			$ret_val_fract = 0.9;
		} 
		else if ($fraction_part >= 0.86)
		{
			$ret_val_fract = 0.88;
		} 
		else if ($fraction_part >= 0.83)
		{
			$ret_val_fract = 0.85;
		} 



		else if ($fraction_part >= 0.78)
		{
			$ret_val_fract = 0.8;
		} 
		else if ($fraction_part >= 0.68)
		{
			$ret_val_fract = 0.75;
		} 
		else if ($fraction_part >= 0.63)
		{
			$ret_val_fract = 0.66;
		} 
		else if ($fraction_part >= 0.58)
		{
			$ret_val_fract = 0.6;
		}
		else if ($fraction_part >= 0.53)
		{
			$ret_val_fract = 0.55;
		}
		else if ($fraction_part >= 0.48)
		{
			$ret_val_fract = 0.5;
		}
		else if ($fraction_part >= 0.43)
		{
			$ret_val_fract = 0.55;
		}
		else if ($fraction_part >= 0.38)
		{
			$ret_val_fract = 0.4;
		}
		else if ($fraction_part >= 0.28)
		{
			$ret_val_fract = 0.33;
		}
		else if ($fraction_part >= 0.24)
		{
			$ret_val_fract = 0.25;
		}
		else if ($fraction_part >= 0.21)
		{
			$ret_val_fract = 0.22;
		}
		else if ($fraction_part >= 0.16)
		{
			$ret_val_fract = 0.20;
		}
		else if ($fraction_part >= 0.11)
		{
			$ret_val_fract = 0.11;
		}
		else if ($fraction_part >= 0.05)
		{
			$ret_val_fract = 0.10;
		}
		else
		{
			$ret_val_fract = 0.0;
		}
	}
	return $ret_val_int + $ret_val_fract;
}

function gcd($x, $y)
{
	$x = abs($x);
	$y = abs($y);

	if($x + $y == 0)
	{
		return "0";
	}
	else
	{
		while($x > 0)
		{
			$z = $x;
			$x = $y % $x;
			$y = $z;
         }
		 return $z;
	}
}
	
function calculateOdds($entry_pool,$total_pool,$odds_type,$max_odds)
{
// $odds_type 0 american, 1 decimal, 2 fraction
if (($odds_type > 2) || ($odds_type < 0))
{
	$odds_type = 0;
}
if ($entry_pool == 0.0)
{
	$ret_odds = $max_odds;
}
else
{
	$ret_odds = ($total_pool - $entry_pool) / $entry_pool;
}

if (($odds_type == 0) && ($ret_odds <= 1.0))
{
	$ret_odds = -(1.0 / $ret_odds);
}


$ret_string = strval(round($ret_odds,2));

return $ret_string;
}

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
	$entry1_pool = 450.0; // a join from accounts and pool.
	$entry2_pool = 550.0; // a join from accounts and pool.
// 	yo format strings, odds_type yo
//	$odds_type = $_SESSION['SESS_ODDS_DISPLAY'];
	$odds_type = 0; // american
	$entry1_odds = calculateOdds($entry1_pool, $total_pool, $odds_type, 20);
//	$entry1_odds = "+105";
//	$entry2_odds = calculateOdds($entry1_pool, $total_pool, $odds_type, 20);
	$entry2_odds = "-105";
?>


	  	<table class="tabley">
		<caption><strong>FireBoil Odds</strong></caption>
	  	<tr>
			<th colspan="7"; id="gameName">
<?php 
	echo $gamename;
?>
			</th>
		</tr>
	  	<tr>
			<th id="rot">Rot</th>
			<th id="teamName">Team</th>
			<th id="pointSpread">Point Spread</th>
			<th id="pointSpread">Moneyline</th>
			<th id="pointSpread">PWP</th>
			<th id="ouHeaderLeft"></th>			
			<th id="ouHeaderRight">Total</th>
		</tr>
		<tr>
			<td>
<?php 
	echo $entry1_rot;
?>
			</td>
			<td>
<?php 
	echo $entry1_name;
?>
			</td>
			<td id="odds"><label class="bfd" for="genre2">+3 -105</label><input type="checkbox" name="genre2" value="100odds" /></td>
			<td id="odds"><label class="bfd" for="genre">+140</label><input type="checkbox" name="genre" value="101odds" /></td> 
			<td id="odds"><label class="bfd" for="genre7">+3&nbsp; +180</label><input type="checkbox" name="genre7" value="107odds" /></td> 
			<td rowspan="2"; id="overUnderNumber">53.5</td>
			<td rowspan="2"; id="overUnder"><label id="overUnderLabel" for="genre3"><span class="bfd">O</span> +210</label><input type="checkbox" name="genre3" value="overUnderOdds1" />
			<br />
			<label id="overUnderLabel" for="genre4"><span class="bfd">U</span> +190</label><input type="checkbox" name="genre4" value="overUnderOdds2" /></td>
		</tr>
		<tr>
			<td>
<?php 
	echo $entry2_rot;
?>
			</td>
			<td>
<?php 
	echo $entry2_name;
?>
			</td>
			<td id="odds"><label class="bfd" for="genre5">
<?php
	echo "$point_spread1" . " " . "$entry1_odds";
?>
			</label><input type="checkbox" name="genre5" value="102odds" /></td>
			<td id="odds"><label class="bfd" for="genre6">-140</label><input type="checkbox" name="genre6" value="100odds" /></td>
			<td id="odds"><label class="bfd" for="genre8">-3&nbsp; +115</label><input type="checkbox" name="genre8" value="108odds" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td id="odds"><label class="bfd" for="genre9">Push +1621</label><input type="checkbox" name="genre9" value="109odds" /></td>
		</tr>
		</table>
		<br />
	  	<table class="tabley">
		<caption>Compare with current odds at: <strong>Bodog</strong></caption>
	  	<tr>
			<th id="badRot"></th>
			<th id="badTeamName"></th>
			<th id="badPointSpread"></th>
			<th id="overlay">Overlay</th>			
			<th id="badPointSpread"></th>
			<th id="overlay">Overlay</th>
			<th id="badOuHeaderLeft"></th>			
			<th id="badOuHeaderRight"></th>
			<th id="overlay">Overlay</th>
		</tr>
		<tr>
			<td>101</td>
			<td>New York Giants</td>
			<td id="odds"><label class="bfd" for="genre2">+3 -110</label><input type="checkbox" name="genre2" value="100odds" DISABLED /></td>
			<td id="olPercent">18.2%</td>
			<td id="odds"><label class="bfd" for="genre">+120</label><input type="checkbox" name="genre" value="101odds" DISABLED /></td> 
			<td id="olPercent">18.2%</td>
			<td rowspan="2"; id="overUnderNumber">53.5</td>
			<td rowspan="2"; id="overUnder"><label id="overUnderLabel" for="genre3"><span class="bfd">O</span> +190</label><input type="checkbox" name="genre3" value="overUnderOdds1" DISABLED />
			<br />
			<label id="overUnderLabel" for="genre4"><span class="bfd">U</span> +190</label><input type="checkbox" name="genre4" value="overUnderOdds2" DISABLED /></td>
			<td id="olPercent">18.2%</td>
		</tr>
		<tr>
			<td>102</td>
			<td>New England Patriots</td>
			<td id="odds"><label class="bfd" for="genre5">-3 -110</label><input type="checkbox" name="genre5" value="102odds" DISABLED /></td>
			<td id="olPercent">18.2%</td>
			<td id="odds"><label class="bfd" for="genre6">-140</label><input type="checkbox" name="genre6" value="100odds" DISABLED /></td>
			<td id="olPercent">18.2%</td>
			<td id="olPercent">18.2%</td>
		</tr>
		</table>
		<br />
	  </div>
		<br />
<!-- End of fireboil pool view -->
			<a href="devtodo" class="morelink" title="A h3 level heading inside a featurebox div">More <span>about: A h3 level heading inside a featurebox div</span></a>
			</p></div>
			
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
