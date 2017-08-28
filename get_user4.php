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
	$new_num = round($ret_odds,2);
	$fraction_part = $new_num % 1;
	$integer_part = floor($new_num);
	$rounded_fractional_part = grfp($fraction_part, $integer_part);
	if ($rounded_fractional_part >= 1.0)
	{
		$integer_part++; 
	}
	$new_num2 = $integer_part + $fraction_part;
	$temp_val = $fraction_part * 10;
	$temp_val2 = $fraction_part * 100;
	$num_dig1 = floor($temp_val);
	$num_dig2 = $temp_val % 1;
	if ($num_dig1 == $num_dig2)
	{
		$numerator = $num_dig1;
		$denominator = 9;
	}
	elseif ($num_dig2 == 0)
	{
		$numerator = $num_dig1;
		$denominator = 10;
	}
	else
	{
		$numerator = round($temp_val2,0);
		$denominator = 100;
	}
	$reduce_factor = gcd($numerator,$denominator);
	$str_num = strval($numerator/$reduce_factor);
	$str_den = strval($denominator/$reduce_factor);
	$ret_string = $str_num . "/" . $str_den;
}
else
{
	if ($ret_odds >= 100)
	{
		$ret_string = strval(round($ret_odds,0));
	}
	else if ($ret_odds >= 10)
	{
	$ret_string = strval(round($ret_odds,1));
	}
	else
	{
	$ret_string = strval(round($ret_odds,2));
	}
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
  	  echo "<div id="pool_view">";
	  	echo "<table class="tabley">";
		echo "<caption><strong>FireBoil Odds</strong></caption>";
	  	echo "<tr>";
			echo "<th colspan="7"; id="gameName">" . "$gamename" . "</th>";
		echo "</tr>
	  	echo "<tr>
			<th id='rot'>Rot</th>
			<th id='teamName'>Team</th>
			<th id='pointSpread'>Point Spread</th>
			<th id='pointSpread'>Moneyline</th>
			<th id='pointSpread'>PWP</th>
			<th id='ouHeaderLeft'></th>			
			<th id='ouHeaderRight'>Total</th>
		</tr>";
		echo "<tr>";
			echo "<td>" . "$entry1_rot" . "</td>";
			echo "<td>" . "$entry1_name" . "</td>";
			echo "<td id="odds"><label class="bfd" for="genre2">" . "$point_spread1" . " " . "$entry1_odds" . "</label><input type="checkbox" name="genre2" value="100odds" /></td>";
			echo "<td id="odds"><label class="bfd" for="genre">" . "$entry1_odds_ml" . "</label><input type="checkbox" name="genre" value="101odds" /></td>";
			echo "<td id="odds"><label class="bfd" for="genre7">" . "$point_spread1_pwp" . " " . "$entry1_odds_pwp" . </label><input type="checkbox" name="genre7" value="107odds" /></td>";
			echo "<td rowspan="2"; id="overUnderNumber">53.5</td>";
			echo "<td rowspan="2"; id="overUnder"><label id="overUnderLabel" for="genre3"><span class="bfd">O</span> +210</label><input type="checkbox" name="genre3" value="overUnderOdds1" />";
			echo "<br />";
			echo "<label id="overUnderLabel" for="genre4"><span class="bfd">U</span> +190</label><input type="checkbox" name="genre4" value="overUnderOdds2" /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>" . "$entry2_rot" . "</td>";
			echo "<td>" . "$entry2_name" . "</td>";
			echo "<td id="odds"><label class="bfd" for="genre5">" . "$point_spread2" . " " . "$entry2_odds" . "</label><input type="checkbox" name="genre5" value="102odds" /></td>";
			echo "<td id="odds"><label class="bfd" for="genre6">" . "$entry2_odds_ml" . "</label><input type="checkbox" name="genre6" value="100odds" /></td>";
			echo "<td id="odds"><label class="bfd" for="genre8">" . "$point_spread2_pwp" . " " . "$entry2_odds_pwp" . </label><input type="checkbox" name="genre8" value="108odds" /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td id="odds"><label class="bfd" for="genre9">" . "Push" . " " . "$entry3_odds_pwp" . "</label><input type="checkbox" name="genre9" value="109odds" /></td>";
		echo "</tr>";
		echo "</table>";
		echo "<br />";
	  	echo "<table class="tabley">";
		echo "<caption>Compare with current odds at: <strong>Bodog</strong></caption>";
	  	echo "<tr>";
			echo "<th id="badRot"></th>";
			echo "<th id="badTeamName"></th>";
			echo "<th id="badPointSpread"></th>";
			echo "<th id="overlay">Overlay</th>";		
			echo "<th id="badPointSpread"></th>";
			echo "<th id="overlay">Overlay</th>";
			echo "<th id="badOuHeaderLeft"></th>";			
			echo "<th id="badOuHeaderRight"></th>";
			echo "<th id="overlay">Overlay</th>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>101</td>";
			echo "<td>New York Giants</td>";
			echo "<td id="odds"><label class="bfd" for="genre2">+3 -110</label><input type="checkbox" name="genre2" value="100odds" DISABLED /></td>";
			echo "<td id="olPercent">18.2%</td>";
			echo "<td id="odds"><label class="bfd" for="genre">+120</label><input type="checkbox" name="genre" value="101odds" DISABLED /></td>";
			echo "<td id="olPercent">18.2%</td>";
			echo "<td rowspan="2"; id="overUnderNumber">53.5</td>";
			echo "<td rowspan="2"; id="overUnder"><label id="overUnderLabel" for="genre3"><span class="bfd">O</span> +190</label><input type="checkbox" name="genre3" value="overUnderOdds1" DISABLED />";
			echo "<br />";
			echo "<label id="overUnderLabel" for="genre4"><span class="bfd">U</span> +190</label><input type="checkbox" name="genre4" value="overUnderOdds2" DISABLED /></td>";
			echo "<td id="olPercent">18.2%</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>102</td>";
			echo "<td>New England Patriots</td>";
			echo "<td id="odds"><label class="bfd" for="genre5">-3 -110</label><input type="checkbox" name="genre5" value="102odds" DISABLED /></td>";
			echo "<td id="olPercent">18.2%</td>";
			echo "<td id="odds"><label class="bfd" for="genre6">-140</label><input type="checkbox" name="genre6" value="100odds" DISABLED /></td>";
			echo "<td id="olPercent">18.2%</td>";
			echo "<td id="olPercent">18.2%</td>";
		echo "</tr>";
		echo "</table>";
		echo "<br />";
	  echo "</div>";
		echo "<br />";
?> 
