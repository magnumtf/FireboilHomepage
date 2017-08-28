<?php
function convertOdds($entry_odds,$odds_type,$other_val)
{
// $odds_type 0 american, 1 decimal, 2 fraction
// so when do  you use 6, answer decimal and not convert, else use format 4.
$odds_type2a = intval($odds_type);
$ot_int = $odds_type2a / 3;
$odds_type2 = $odds_type2a % 3;
$entry_odds2 = floatval($entry_odds);
$other_val2 = floatval($other_val);
$other_val3 = $other_val2 * 100;
$entry_odds3 = $entry_odds2 * 100;
if (($odds_type2 > 2) || ($odds_type2 < 0))
{
	$odds_type2 = 0;
}

if ( $odds_type2 == 1 )
{
	if ($ot_int < 1)
		$format_spec = "%'#6.2f";
	else
		$format_spec = "%'#4.2f";	
}
else if ( $odds_type2 == 0 )
{
	if ($ot_int < 1)
		$format_spec = "%+'#6.0f"; 
 	else
		$format_spec = "%+'#4.0f";	

//	$format_spec = "%+'#4.0f";
} 
else
{
	$format_spec = "%+'#4.0f";
} 

$debg = 1;
if ($odds_type2 == 0)
{
	if ($entry_odds2 == 0.0) 
	{
		if ($other_val3 >1000000.0)
		{
			$other_val3 = -$other_val3 / 100;
			$ret_string = sprintf_nbsp($format_spec, $other_val3);
//			$ret_string = "-" . strval(round($other_val3,0));
$debg = 2;
		}
		else if ($other_val3 > 100000.0)
		{
			$other_val3 = -$other_val3 / 10;
			$ret_string = sprintf_nbsp($format_spec, $other_val3);
//			$ret_string = "-" . strval(round($other_val3,0));
$debg = 3;
		}
		else if ($other_val3 > 0.0)
		{		
			$ret_string = sprintf_nbsp($format_spec, -$other_val3);
//			$ret_string = "-" . strval(round($other_val3,0));
$debg = 4;
		}
		else
		{
			$ret_odds = 0.0;
			$ret_string = "-0.0";
$debg = 5;
		}
	}
	else if ($entry_odds2 <= 1.0)
	{
		$ret_odds = -(100.0 / $entry_odds2);
		$ret_string = sprintf_nbsp($format_spec, $ret_odds);
//		$ret_string = strval(round(100 * $ret_odds,0));
$debg = 6;
	}
	else
	{
		if ($entry_odds3 > 1000000.0)
		{
			$entry_odds3 = $entry_odds3 / 100;
			$ret_string = sprintf_nbsp($format_spec, $entry_odds3);
//			$ret_string = "+" . strval(round($entry_odds3,0));
$debg = 7;
		}
		else if ($entry_odds3 > 100000.0)
		{
			$entry_odds3 = $entry_odds3 / 10;
			$ret_string = sprintf_nbsp($format_spec, $entry_odds3);
//			$ret_string = "+" . strval(round($entry_odds3,0));
$debg = 8;
		}
		else
		{
			$ret_string = sprintf_nbsp($format_spec, $entry_odds3);
//			$ret_string = "+" . strval(round($entry_odds3,0));
$debg = 9;
		}
	}
}
else if ($odds_type2 == 2) // fraction stuff here
{
	$ret_string = "catsbigolevaggy";
$debg = 10;
}
else
{
//	$ret_string = strval(round($entry_odds2,2));
	$ret_string = sprintf_nbsp($format_spec, $entry_odds2);
$debg = 11;
}

return $ret_string;
}

function sprintf_nbsp() 
{
   $args = func_get_args();
   return str_replace('#', '&nbsp;', vsprintf(array_shift($args), array_values($args)));
}
?>