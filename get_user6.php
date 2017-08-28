<?php
session_start();
require 'odd_funcs.php';
$gamedate = "Sunday, October 07, 2012";
if(!isset($_SESSION["SESS_MEMBER_ID"]) || (trim($_SESSION["SESS_MEMBER_ID"]) == ""))
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

echo "<table class='tabley'>\n";
echo "<tr>\n";
echo "<th colspan=" . "$colspan_gameday" . "; id='gameDate'>" . "$gamedate" . "</th>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<th id='rotHeader'>Rot</th>\n";
echo "<th id='teamNameHeader'>Team</th>\n";
echo "<th id='pointSpreadHeader'>Point Spread</th>\n";
echo "<th id='pointSpreadHeader'>PWP</th>\n";
echo "<th id='pointSpreadHeader'>Moneyline</th>\n";
echo "<th id='ouHeaderLeftHeader'></th>\n";
echo "<th id='ouHeaderRightHeader'>Total</th>\n";
echo "<th id=" . "$betheadergame_id" . ">Amount</th>\n";
echo "</tr>\n";
echo "</table>\n";
echo "<br />\n";
if(isset($_COOKIE["ppkDisplayOdds"]))
{
$odds_type = intval($_COOKIE["ppkDisplayOdds"]);
}
else
{
$odds_type = 0;
}
$gamename_1 = "1:00 PM, FedEx Field, Landover";
$gameNum = "1";
$game_desc_id_1 = "40";
$entry1_rot_1 = "103";
$entry1_name_1 = "Atlanta Falcons";
$entry2_rot_1 = "104";
$entry2_name_1 = "Washington Redskins";
$num_entries_1 = "2";
$point_spread1_sp_1 = "-3.0";
$point_spread2_sp_1 = "+3.0";
$total_pool_sp_1 = "5800.0";
$entry1_pool_sp_1 = "2500.0";
$entry1_odds_sp_1p = "1.32";
$entry2_pool_sp_1 = "3300.0";
$entry2_odds_sp_1p = "0.757575757576";
$max_odds_sp_1 = "1.32";

$point_spread1_ml_1 = "pk";
$point_spread2_ml_1 = "pk";
$total_pool_ml_1 = "2700.0";
$entry1_pool_ml_1 = "1300.0";
$entry1_odds_ml_1p = "1.07692307692";
$entry2_pool_ml_1 = "1400.0";
$entry2_odds_ml_1p = "0.0";
$max_odds_ml_1 = "1.07692307692";
$entry1_odds_ml_1 = convertOdds($entry1_odds_ml_1p, $odds_type, 0);
$entry2_odds_ml_1 = convertOdds($entry2_odds_ml_1p, $odds_type, $max_odds_ml_1);
$nbsp1_count = substr_count($entry1_odds_ml_1, '&nbsp');
$nbsp2_count = substr_count($entry2_odds_ml_1, '&nbsp');
$point_spread1_pwp_1 = "-3.0";
$point_spread2_pwp_1 = "+3.0";
$total_pool_pwp_1 = "600.0";
$entry1_pool_pwp_1 = "600.0";
$entry1_odds_pwp_1p = "0.0";
$entry2_pool_pwp_1 = "0.0";
$entry2_odds_pwp_1p = "600.0";
$entry3_pool_pwp_1 = "0.0";
$entry3_odds_pwp_1p = "600.0";
$max_odds_pwp_1 = "600.0";
//$entry1_odds_pwp_1 = convertOdds($entry1_odds_pwp_1p, $odds_type, $max_odds_pwp_1);
//$entry2_odds_pwp_1 = convertOdds($entry2_odds_pwp_1p, $odds_type, 0);
//$entry3_odds_pwp_1 = convertOdds($entry3_odds_pwp_1p, $odds_type, $max_odds_pwp_1);
$point_spread1_ou_1 = "+51.0";
$point_spread2_ou_1 = "-51.0";
$point_spread_ou_1 = "51.0";
$total_pool_ou_1 = "700.0";
$entry1_pool_ou_1 = "0.0";
$entry1_odds_ou_1p = "700.0";
$entry2_pool_ou_1 = "700.0";
$entry2_odds_ou_1p = "0.0";
$max_odds_ou_1 = "700.0";

$entry1_pool_sp_1 = "2507.0";
$entry1_odds_sp_1p = "1.32";
$entry2_pool_sp_1 = "0.0";
$entry2_odds_sp_1p = "0.757575757576";

//$entry1_odds_ou_1 = convertOdds($entry1_odds_ou_1p, $odds_type, 0);
//$entry2_odds_ou_1 = convertOdds($entry2_odds_ou_1p, $odds_type, $max_odds_ou_1);
echo "<div id='pool_view'>\n";
echo "<h1>" . "$entry1_pool_sp_1" . "</h1>\n";
echo "<h1>" . "$entry2_pool_sp_1" . "</h1>\n";
echo "<h1>" . "$entry1_odds_ml_1" . "</h1>\n";
echo "<h1>" . "$entry2_odds_ml_1" . "</h1>\n";
echo "<h1>" . "$nbsp1_count" . "</h1>\n";
echo "<h1>" . "$nbsp2_count" . "</h1>\n";
//echo "<h1>$entry1_odds_pwp_1</h1>\n";
//echo "<h1>$entry2_odds_pwp_1</h1>\n";
//echo "<h1>$entry3_odds_pwp_1</h1>\n";
//echo "<h1>$entry1_odds_ou_1</h1>\n";
//echo "<h1>$entry2_odds_ou_1</h1>\n";
echo "</div>\n";
echo "<hr />\n";


//echo "<div id='pool_view'>\n";
//echo "<h1>" . "$entry1_pool_sp_1" . "</h1>\n";
//echo "<h1>" . "$entry2_pool_sp_1" . "</h1>\n";
//echo "<h1>$entry1_odds_ml_1</h1>\n";
//echo "<h1>$entry2_odds_ml_1</h1>\n";
//echo "<h1>$entry1_odds_pwp_1</h1>\n";
//echo "<h1>$entry2_odds_pwp_1</h1>\n";
//echo "<h1>$entry3_odds_pwp_1</h1>\n";
//echo "<h1>$entry1_odds_ou_1</h1>\n";
//echo "<h1>$entry2_odds_ou_1</h1>\n";
//echo "</div>\n";
//echo "<hr />\n";
?>