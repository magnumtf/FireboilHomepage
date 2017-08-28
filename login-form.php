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
	<div id="cb-wrap-1">
<?php
	//Start session
	session_start();
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['ERRMSG_ARR']) || (trim($_SESSION['ERRMSG_ARR']) == '')) 
	{
			echo "<h3>No Message</h3>";
	}
	else
	{
			foreach ($_SESSION['ERRMSG_ARR'] as $value) {
    			echo "<h4> $value</h4><br />\n";
			}
	}	
?>			
			<hr />
			</div>

			<form action="login-exec2.php" method="post" class="f-wrap-1">
			
			<div class="req"><b>*</b> Indicates required field</div>
			<fieldset>
			
			<h3>Member Login</h3>
			
			<label for="username"><b><span class="req">*</span>Username or Email:</b>
			<input id="username" name="username" type="text" class="f-name" tabindex="1" /><br />
			</label>
			
			<label for="password"><b><span class="req">*</span>Password:</b>
			<input id="password" name="password" type="password" class="f-name" tabindex="2" /><br />
			</label>
			
			
			
			<label for="comments"><b>Comments:</b>
			<textarea id="comments" name="comments" class="f-comments" rows="6" cols="20" tabindex="11"></textarea><br />
			</label>
			
			<div class="f-submit-wrap">
			<input type="submit" value="Submit" class="f-submit" tabindex="12" /><br />
			</div>
			</fieldset>
			</form>
			
			<div id="footer">
			<p>A note here to go in the footer</p>
			<p><a href="#">Contact Us</a> | <a href="#">Privacy</a> | <a href="#">Links</a></p>
			</div>
			
		</div>		
	</div>
</body>
<?php
		exit();
?>			
</html>