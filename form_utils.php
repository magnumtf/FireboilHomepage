<?php
define('MIN_BET_VALUE', '1.0'); 
define('MAX_BET_VALUE', '10000000.0'); 
define('MAX_BET_VALUE2', '100.0'); 
define('STABLE_POOL_SIZE', '10000'); 
define('OVER', '1'); 
define('UNDER', '2'); 
define('PUSH', '3');
// does the actual 'html' and 'sql' sanitization. customize if you want.


function checkIllegalChars($text)
{
	$retval = true;
	$pos = strpos($text, "<");
	if ($pos === false) 
	{
		$pos = strpos($text, ">");
		if ($pos === false) 
		{
			$pos = strpos($text, "\"");
			if ($pos === false) 
			{
				$pos = strpos($text, "'");
				if ($pos === false) 
				{
					$pos = strpos($text, "\\");
					if ($pos === false) 
					{
						$pos = strpos($text, "*");
						if ($pos === false) 
						{
							$pos = strpos($text, "/");
							if ($pos === false) 
							{
								$retval = false;
							}
						}
					}
				}
			}
		}
	} 

	return $retval;
} 

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) 
{
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysqli_real_escape_string($str);
}

function addzero($strval)
{
	$ival = intval($strval);
	if ($ival < 10)
	{
		$retstring = "0" . $strval;
	}
	else
	{
		$retstring = $strval;
	}
	return $retstring; 
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
