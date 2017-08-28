<?php
	session_start();

	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) 
	{
		header("location: index1.php");
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
<title>FireBoil Confirmation Page</title>
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
<?php
	include ('class.Form_pool.php'); 
	include ('form_utils.php');

	$pool_ids = $_POST['pool_id_arr'];
	$acct_ids = $_POST['acct_id_arr'];
	echo "<br />\n";

	if(!isset($_POST['total_games']) || (trim($_POST['total_games']) == ''))
	{
		$total_games = 0;		
	}
	else
	{
		$total_games = intval($_POST['total_games']);
	}

	$k = 0;
	$pool_bet_num = 0;
	$tbets = 0;
	$tbets1 = 0;
	$lm = 0;
	$pool_obj_arr = array();
	$bet_total = 0.0;
	$bet_num = 0;
	$number_of_asts = 0;
	$after_box_char = '*';
	echo "<form action='bet-conf1.php' method='post' name='b_conf' class='f-wrap-100'>\n";
	echo "<div id='pool_view'>\n";
	for ($i=0; $i<$total_games; $i++)
	{
		$bet_str1 = 'betbox_e1_game' . strval($i+1);
		$bet_str2 = 'betbox_e2_game' . strval($i+1);
		$bet_str3 = 'betbox_e3_game' . strval($i+1);

		$val1 = $_POST[$bet_str1];
		$val2 = $_POST[$bet_str2];
		$val3 = $_POST[$bet_str3];

		$print_header = 1;
		$type_str2 = "";
		for ($j=0; $j<4; $j++)
		{
			$pool_id = $pool_ids[$k];
			$acct_id = $acct_ids[$k];
			if ($j == 3)
			{
				$type_str = 'ou';
				$type_str2 = "OverUnder";				
				$num_ents = 2;
				$pts_str = "pts ";
			}
			else if ($j == 2)
			{
				$type_str = 'pwp';
				$type_str2 = "PWP";
				$num_ents = 3;
				$pts_str = "pts ";
			}
			else if ($j == 1)
			{
				$type_str = 'ml';
				$type_str2 = "Moneyline";
				$num_ents = 2;
				$pts_str = "";
			}
			else
			{
				$type_str = 'sp';
				$type_str2 = "Spread";
				$num_ents = 2;
				$pts_str = "pts ";
			}
			$pool_size_str = 'pool_size_' . $type_str . '_game' . strval($i+1);
			$pss = $_POST[$pool_size_str];
			$obj_sp = new Form_pool($pool_id, $acct_id, $i+1, $type_str, $pss, $num_ents, $tbets);
			$tbets1 = $obj_sp->getNumBets();
			$tbets += $tbets1;
			$pool_obj_arr[$lm] = $obj_sp;
			$lm++;
			if ($print_header && ($tbets1 > 0))
			{
				$print_header = 0;
				echo "<br />\n";
				echo "<p id='bet_slip_tname'>" . $obj_sp->game_name2 . "</p>\n";
				echo "<p id='bet_slip_tname'>" . $obj_sp->game_date .  "</p>\n";
				echo "<table id='confpage-a'>\n";
				echo "<tr>\n";
				echo "<th width='60'></th>\n";
				echo "<th width='140'>" . $type_str2 . "</th>\n";
				echo "<th width='100'></th>\n";
				echo "<th width='120'></th>\n";
				echo "</tr>\n";
			}
			
			$betbox_name_str_base = "betbox_";
			$betbox_name_str = "";
			$oddbox_name_str_base = "oddbox_";
			$oddbox_name_str = "";
			for ($pool_bet_num=0; $pool_bet_num<$tbets1; $pool_bet_num++)
			{
				$bet_num += 1;
				if ($obj_sp->pick_rot_id_arr[$pool_bet_num] == intval(PUSH))
					$pts_str = "";
				$bet_amount = $obj_sp->getBetAmount($pool_bet_num);
				echo "<tr>\n";
				$betbox_name_str = $betbox_name_str_base . $bet_num;
				echo "<td>$" . "<input name='" . $betbox_name_str . "' value='" . $bet_amount . "' width='59' type='text' onchange='recalcTotals(" . $_SESSION['SESS_BALANCE'] . ")' />" . "</td>\n";
				echo "<td>" . $obj_sp->pick_rot_id_name_arr[$pool_bet_num] . "</td>\n";
				echo "<td>&nbsp;" . $pts_str . $obj_sp->getSpread($pool_bet_num) . "</td>\n";
				$estimated_payoff = number_format($bet_amount, 2) + number_format(floatval($obj_sp->getOdds($pool_bet_num)) * $bet_amount, 2);
				$oddbox_name_str = $oddbox_name_str_base . $bet_num;
				if (intval($obj_sp->pool_size) >= intval(STABLE_POOL_SIZE))
				{
					$after_box_char = ' ';
				}
				else
				{
					$number_of_asts += 1;
					$after_box_char = '*';
				}
				echo "<td>&nbsp;to win $" . "<input name='" . $oddbox_name_str . "' value='" . $estimated_payoff . "' width='59' type='text' disabled />" . $after_box_char . "</td>\n";
				echo "</tr>\n";
				$bet_total += $bet_amount;
			}
			if ($tbets1 > 0)
			{
				echo "</table>\n";
				$obj_sp->echoHiddenValues($bet_num);
			}
			$k++;
		}
	}
	$bet_total = number_format($bet_total, 2);
	echo "<hr id='hardy' />\n";	
	echo "<table id='confpage-a'>\n";
	echo "<tr>\n";
	echo "<th width='60'></th>\n";
	echo "<th width='140'></th>\n";
	echo "<th width='100'></th>\n";
	echo "<th width='120'></th>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	if ($bet_num == 1)
	{
		$bets_str = ' Bet ';
	}
	else
	{
		$bets_str = ' Bets';
	}
	$url_str = 'index.php';
	echo "<td>" . $bet_num . $bets_str . "</td>\n";
	echo "<td>TOTAL</td>\n";
	echo "<td>$" . "<input name='total_bet_val' value='" . $bet_total . "' width='59' type='text' disabled /></td>\n";
	echo "<td></td>\n";
	echo "</tr>\n";
	echo "</table>\n";

	echo "</div>\n";
	echo "<br />\n";
	echo "<input type='submit' value='Submit Ticket' />\n";
	echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='button' value='Cancel Ticket' class='f-submit' onclick='goBack()' /><br />\n";
	echo "</form>\n";
	echo "<hr />\n";
	if ($number_of_asts > 0)
	{
		echo "<div>\n";
		echo "<small>*The pool is growing, there may be some fluctuation in the odds. You can check the odds near Game Time to get a more accurate probable payoff.</small>\n";
		echo "</div>\n";
		echo "<br />\n";
	}
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