
<?php
class Form_pool
{        
	public $prop1 = "I'm a class property!";  
	public $iPool_id;
	public $iAcct_id;
	public $strPoolType;
	public $arrBetAmount;
	public $arrSpread;
	public $arrCurrentOdds;
	public $num_bets;
	public $form_bet_number_arr;
	public $pick_rot_id_arr;
	public $pick_rot_id_name_arr;
	public $game_name;
	public $game_name2;
	public $game_date;
//	public $isValid;  

	public function __construct($pool_id=0, $acct_id=0, $game_num=0, $acct_type="", $p_size=0, $num_entries=2, $base_num=0)
	{
		$this->iPool_id = $pool_id;
		$this->iAcct_id = $acct_id;
		$this->strPoolType = $acct_type;
		$this->pool_size = $p_size;
		$this->num_bets = 0;
		$this->game_name = "";
		$this->game_name2 = "";
		$this->game_date = "";
		if (intval($game_num) > 0)
		{
			if (!strcmp($acct_type, "sp"))
				$acct_type2 = "spread";
			else if (!strcmp($acct_type, "ou"))
				$acct_type2 = "overunder";
			else
				$acct_type2 = $acct_type;
			$this->strPoolType = $acct_type2;
			$checkBoxName = $acct_type2 . "_game" . $game_num;
			$num_checks = count($_POST[$checkBoxName]);
			$num_valid_bets = 0;
			$this->game_name = str_replace("_", " ", $_POST["gamename_arr"][$game_num-1]);
			$this->game_name2 = $this->game_name . "&nbsp;&nbsp;&nbsp;&nbsp;" . str_replace("_", " ", $_POST["gamename2_arr"][$game_num-1]);
			$this->game_date = str_replace("_", " ", $_POST["gamedate2_arr"][$game_num-1]);
			for ($i = 0; $i < $num_checks; $i++) 
			{

				// for each check box go through all the rot_id's until you get a hit.
				for ($j = 0; $j < $num_entries; $j++)
				{
					$entry_name = "entry" . strval($j+1) . "_name_arr";
					$odds_name = "entry" . strval($j+1) . "_odds_" . "$acct_type" . "_" . "$game_num";
					$odds_name2 = "entry" . strval($j+1) . "_odds_" . "$acct_type" . "_arr";
					$spread_name = "point_spread" . strval($j+1) . "_" . "$acct_type" . "_" . "$game_num";
					$game_ind = $game_num - 1;
					$rot_id_p = "rot_id_e" . strval($j+1) . "_game" . "$game_num";

					// some do-dads to fix some inconsistencies
					if (!strcmp($acct_type, 'ou'))
					{
						$rot_id = "$rot_id_p" . "_ou";
						$tstrO = constant("OVER"); 
						$tstrU = constant("UNDER"); 
                    	if ($_POST[$rot_id] == intval($tstrO))
							$entry_name2 = "Over";
                    	else if ($_POST[$rot_id] == intval($tstrU))
							$entry_name2 = "Under";
						else
						{
							$entry_name2 = 'None';
						}
						$spread_name2 = trim($_POST[$spread_name]);
					}
					else if (!strcmp($acct_type, 'pwp'))
					{
						$rot_id = "$rot_id_p";
						if ($j == 2)
						{
							$entry_name2 = "Push";
							$spread_name2p = trim($_POST[$spread_name]);
							$ret_arr = explode(",", $spread_name2p);
							$temp_str = "";
							if (count($ret_arr) == 2)
							{
								$temp_str = $this->getAbbrev($ret_arr[1]);
								$spread_name2 = $temp_str . " " . $ret_arr[0];
							}
							else
							{
								$spread_name2 = $spread_name2p;								
							}
						}
						else
						{
							$entry_name2 = trim($_POST[$entry_name][$game_ind]);
							$spread_name2 = trim($_POST[$spread_name]);
						}
					}
					else if (!strcmp($acct_type, 'ml'))
					{
						$rot_id = "$rot_id_p";
						$entry_name2 = trim($_POST[$entry_name][$game_ind]);
						$spread_name2 = "";
					}
					else
					{
						$rot_id = "$rot_id_p";
						$entry_name2 = trim($_POST[$entry_name][$game_ind]);
						$spread_name2 = trim($_POST[$spread_name]);
					}

					
					if (!strcmp(trim($_POST[$checkBoxName][$i]), trim($_POST[$rot_id])))
					{
						// outcome is arrBetAmount, arrCurrentOdds, arrSpread
						$betbox_amount = "betbox_e" . strval($j+1) . "_game" . $game_num;
						$flt_betbox_amount = number_format(floatval(trim($_POST[$betbox_amount])), 2);
						$ps_s = intval($this->pool_size) / 10;
						if (($flt_betbox_amount > floatval(MAX_BET_VALUE2)) && ($flt_betbox_amount > $ps_s) && ($ps_s > 0))
						{
							echo "Invalid betbox_amount2 = " . "$flt_betbox_amount" . "<br />";							
						}
						else if (($flt_betbox_amount >= floatval(MIN_BET_VALUE)) && ($flt_betbox_amount <= floatval(MAX_BET_VALUE))) 
						{
							$this->pick_rot_id_arr[$num_valid_bets] = trim($_POST[$rot_id]);
							$this->pick_rot_id_name_arr[$num_valid_bets] = str_replace("_", " ", $entry_name2);
							$this->arrSpread[intval(trim($_POST[$rot_id]))] = $spread_name2;
							$this->arrBetAmount[intval(trim($_POST[$rot_id]))] = $flt_betbox_amount;
							$this->form_bet_number_arr[$this->num_bets] = $base_num + $this->num_bets + 1;
							$this->num_bets++;
							$num_valid_bets++;
							$this->arrCurrentOdds[intval(trim($_POST[$rot_id]))] = trim($_POST[$odds_name2][$game_ind]);

						}
						else
						{
							echo "Invalid betbox_amount = " . "$flt_betbox_amount" . "<br />";
						}
					}
/*					else
					{
						echo "$checkBoxName" . ", " . "$rot_id" . "<br />";
						echo $_POST[$checkBoxName][$i] . ", " . $_POST[$rot_id] . "<br />";
					}				
*/
				}
				// no rot found for ...
			}
		}
	}

	public function getAbbrev($fullname)
    {
		$str_list = explode("_", $fullname);
		$retval = "";
		$temp_str = "";
		$temp_str2 = "";
		$name_list_len = count($str_list);
		if ($name_list_len > 0)
		{
			$retval = strtoupper(substr($str_list[0],0,3));
			if ($name_list_len == 3)
			{
				$temp_str = substr($str_list[0], 0, 1);
				$temp_str2 = substr($str_list[0], -1);
				if (trim($str_list[1]) == 'York')
				{
					$retval = $temp_str . substr($str_list[1], 0, 1) . substr($str_list[2], 0, 1);
				}
				else
				{
					if (strpos($str_list[0], '.') == 2)
					{
						$temp_str2 = strtoupper(substr($str_list[0], 1, 1));
					}
					$retval = $temp_str . $temp_str2 . substr($str_list[1], 0, 1);
				}
			}
		}
		return $retval;
    }  

	public function setProperty($newval)
    {  
        $this->prop1 = $newval;  
    }  
  
	public function getNumBets()
    {  
        return $this->num_bets;  
    }

	public function getRotId($ind)
    {
    	$retval = -1;

		if (($ind >= 0) && ($ind < count($this->pick_rot_id_arr)))
		{
			$retval = $this->pick_rot_id_arr[$ind];
		}    	
        return $retval;
    }
    
	public function getBetAmount($ind)
    {  
    	$retAmount = 0.0;
		$rot_id = $this->getRotID($ind);
        if ($rot_id > 0)
        {
        	$retAmount = $this->arrBetAmount[$rot_id]; 
        }
        return $retAmount;  
    }

	public function getSpread($ind)
    {  
    	$retval = "";
		$rot_id = $this->getRotID($ind);
        if ($rot_id > 0)
        {
        	$retval = $this->arrSpread[$rot_id];
        }
        return $retval;  
    }

	public function getOdds($ind)
    {  
    	$retval = "";
		$rot_id = $this->getRotID($ind);
        if ($rot_id > 0)
        {
        	$retval = $this->arrCurrentOdds[$rot_id];
        }
        return $retval;  
    }

    public function printValidBets()  
    {  
		$rot_arr_len = count($this->pick_rot_id_arr);
		if ($rot_arr_len != $this->num_bets)
		{
			echo "Array Length Error. " . "$rot_arr_len" . ", " . "$this->num_bets" . " <br />";
		}
		else
		{
			for ($i=0; $i<$rot_arr_len; $i++)
			{
				if ($i == 0)
				{				        
					echo "Form bets: <br />";
        		}
        		$rot_id = $this->pick_rot_id_arr[$i];
        		if ($rot_id > 0)
        		{
       				echo "Bet Number = " . strval($this->form_bet_number_arr[$i]) . "<br />";
       				echo "GameName = " . $this->game_name . "<br />";
        			echo "rot_id = " . $rot_id . ". Entry_name = " . $this->pick_rot_id_name_arr[$i] . "<br />";
        			echo "Bet Amount = " . $this->arrBetAmount[$rot_id] . " for pool_id = " . $this->iPool_id . " and pool type of " . $this->strPoolType . "<br />";
        			echo "Acct id = " . $this->iAcct_id . " and pool size = " . $this->pool_size . "<br />";
        			echo "Current Odds = " . $this->arrCurrentOdds[$rot_id] . ". Spread = " . $this->arrSpread[$rot_id] . "<br />";
        		}
    		}
    	}
    }

    public function echoHiddenValues($bet_num)  
    {  
		$num_bets = count($this->pick_rot_id_arr);
		$rot_id = 0;
		$rot_name = "";
		$bet_amount = "0";

		$odds_name_base = 'odds_bet_b';
		$odds_name = '';
		$pool_size_base = 'pool_size_b';
		$pool_size_name = '';
		$bet_amount_base = 'bet_amount_b';
		$bet_amount_name = '';
		$bet_num2 = $bet_num - $num_bets + 1;

		for ($i=0; $i<$num_bets; $i++)
		{
			echo "<input type='hidden' name='pool_acct_id_arr[]' value=" . $this->iAcct_id . " />\n";
			echo "<input type='hidden' name='pool_type_arr[]' value=" . $this->strPoolType . " />\n";
			$rot_id = $this->pick_rot_id_arr[$i];
			$rot_name = $this->pick_rot_id_name_arr[$i];
			$bet_amount = $this->arrBetAmount[$rot_id];
			echo "<input type='hidden' name='rot_id_arr[]' value=" . $rot_id . " />\n";
			echo "<input type='hidden' name='rot_name_arr[]' value=" . $rot_name . " />\n";
			$bet_amount_name = $bet_amount_base . strval($bet_num2 + $i);
//			echo "<input type='hidden' name='bet_amount_arr[]' value=" . $bet_amount . " />\n";
			echo "<input type='hidden' name='" . $bet_amount_name . "' value=" . $bet_amount . " />\n";
			echo "<input type='hidden' name='game_name_arr[]' value=" . $this->game_name . " />\n";
			$odds_name = $odds_name_base . strval($bet_num2 + $i);
			echo "<input type='hidden' name='" . $odds_name . "' value=" . $this->arrCurrentOdds[$rot_id] . " />\n";
			$pool_size_name = $pool_size_base . strval($bet_num2 + $i);
			echo "<input type='hidden' name='" . $pool_size_name . "' value=" . $this->pool_size . " />\n";
		}
	}

    public function printProperties()  
    {  
        echo "Pool_id = " . $this->iPool_id . "<br />";  
        echo "Acct_id = " . $this->iAcct_id . "<br />";  
        echo "Pool_type = " . $this->strPoolType . "<br />";  
        echo "NumBets = " . $this->num_bets . "<br />";
    }

    public function printPickRotIdArr()
    {
		$arr_len = count($this->pick_rot_id_arr);
    	for ($i=0; $i<$arr_len; $i++)
    	{
        	echo "Pick_rot_id_" . "$i" . " = " . $this->pick_rot_id_arr[$i] . "<br />";
    	}
    }  

    public function printPickRotIdLength()
    {
		$arr_len = count($this->pick_rot_id_arr);
		return $arr_len;
    }  

   	public function areBetsValid($ps, $admin_level)
    {
    	$ret_size = -1;
		$arr_len = count($this->pick_rot_id_arr);
		$max_bet3 = 0.1 * floatval($ps);
		$max_bet2 = floatval(constant("MAX_BET_VALUE2"));
    	for ($i=0; $i<$arr_len; $i++)
    	{
        	$rot_id = $this->pick_rot_id_arr[$i];
			$fBet = $this->arrBetAmount[$rot_id];
			if (($fBet <= $max_bet3) || ($fBet <= $max_bet2) || (intval($admin_level) >= 1))
				$ret_size = $ps;
			else
			{
				$ret_size = -1;
				break;
			}
    	}
    	return strval($ret_size);
    }
}
?>