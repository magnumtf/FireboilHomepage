/*
son of suckerfish menu script from:
http://www.htmldog.com/articles/suckerfish/dropdowns/
 */
 
 sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
			this.style.zIndex=200; //this line added to force flyout to be above relatively positioned stuff in IE
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);

function loadXMLDoc()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax_info.txt",true);
xmlhttp.send();
}

function showUser(dispType)
{
		// yo, mtf. for now use reload but figure out how to reset ajax and not have to reload the page from the server.
		// also, i took a pic of miami versus cincinatti, theres an over / under display problem (deicmal mode)
		// also, the team names have underscores. 

	var str = "catsbigvag";
	var tempStr = "gu_";
	var fileStr1;
	var fileStr2;

	var heart_beat = readCookie("ppkHeartBeat");
	var heart_beat_int = parseInt(heart_beat);
	var heart_beat_int2;
	var pulse_str;

	if (isNaN(heart_beat_int))
		heart_beat_int2 = 0;
	else
		heart_beat_int2 = heart_beat_int;
	heart_beat_int2 += 1;
	createCookie("ppkHeartBeat", heart_beat_int2.toString(), "");
	if (heart_beat_int2 % 2)
		pulse_str = '+<br />';
	else
		pulse_str = '-<br />';
	document.getElementById("txtHint3").innerHTML=pulse_str;

	if (str == "")
 	{
 		document.getElementById("txtHint").innerHTML="";
  		return;
 	}
// 	document.getElementById("txtHint").innerHTML=ans;
	if (window.XMLHttpRequest)
  	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  		xmlhttp2=new XMLHttpRequest();
		
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
   			document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
    	}
  	}
	xmlhttp2.onreadystatechange=function()
  	{
  		if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    	{
   			document.getElementById("txtHint").innerHTML=xmlhttp2.responseText;
    	}
  	}
	var ans = readCookie("ppkCompareSite");
	fileStr2 = tempStr.concat(dispType,"_6.php?q=");

	if (ans == "5")
	{
		fileStr1 = tempStr.concat(dispType,"_2.php?q=");
	}
	else
	{
		fileStr1 = tempStr.concat(dispType,"_2_bov.php?q=");
	}
	
	xmlhttp.open("GET",fileStr1+str,true);
	xmlhttp.send();
	xmlhttp2.open("GET",fileStr2+str,true);
	xmlhttp2.send();
}

function showUser6()
{
	var str = "catsbigvag";
	if (str=="")
  	{
  		document.getElementById("txtHint").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest)
  	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
   			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    	}
  	}
	xmlhttp.open("GET","get_user7.php?q="+str,true);
	xmlhttp.send();
}

function showUser6_bov()
{
	var str = "catsbigvag";
	if (str=="")
  	{
  		document.getElementById("txtHint2").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest)
  	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
   			document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
    	}
  	}
	xmlhttp.open("GET","get_user6_bov.php?q="+str,true);
	xmlhttp.send();
}

function clearBetFields()
{
	document.getElementById("betbox_e1_game1").value="";
	document.getElementById("betbox_e2_game1").value="";
	document.getElementById("betbox_e3_game1").value="";
// mtf, next do checkboxes
// what about more than one bet ...

}

function loadUpdateTimer(i)
{
var timer_period = i * 1000;
var myVar=setInterval(function(){onTimerUpdate()},timer_period);
}

function onTimerUpdate(dispType)
{
	showUser(dispType);
//	showUser6();
//	var randomnumber=Math.floor(Math.random()*11);
//	var str1 = randomnumber.toString();
//	var str2 = ' seconds, vaggy!';
//	var str3 = str1.concat(str2);
//	document.getElementById('txt').value=str3;
	return 1;
}

function timedText()
{
var t1=setTimeout("document.getElementById('txt').value='2 seconds!'",2000);
var t2=setTimeout("document.getElementById('txt').value='4 seconds!'",4000);
var t3=setTimeout("document.getElementById('txt').value='6 seconds!'",6000);
	showUser6();
}

function turnOnRealTime(mvar)
{
	var ans = readCookie("ppkRealTimeUpdates");
	var myVar;
	if ( ans == "1" )
	{
		document.getElementById('realTimeUpdates').value='Turn On Real-Time Updates';
		createCookie("ppkRealTimeUpdates","0","");
		self.clearInterval(mvar);
	}
	else
	{
		document.getElementById('realTimeUpdates').value='Turn Off Real-Time Updates';
		createCookie("ppkRealTimeUpdates","1","");
		myVar=self.setInterval(function(){onTimerUpdate()},4000);
		location.reload(true);
		// yo, mtf. for now use reload but figure out how to reset ajax and not have to reload the page from the server.
		// also, i took a pic of miami versus cincinatti, theres an over / under display problem (deicmal mode)
		// also, the team names have underscores. 
	}	
	document.getElementById('txt').value=ans;
	return myVar;
}

function resetForm()
{
	location.reload(true);
}

function turnOffRealTime(mvar)
{
	document.getElementById('realTimeUpdates').value='Turn On Real-Time Updates';
	createCookie("ppkRealTimeUpdates","0","");
	self.clearInterval(mvar);
}

function notTimedText()
{
	document.getElementById('txt').value='2 seconds, homey!';
}

function upperCase()
{
var x=document.getElementById("fname");
x.value=x.value.toUpperCase();
}

function displayResult2()
{
	var x=document.getElementById("js_val");
//	document.getElementById("js_val").innerHTML = "all about the beautiful republic of Costa Rica";
	var xout = document.getElementById("txtHint3");
	var x2;
	x2 = parseInt(x.innerHTML);
	x2++;
//  returns undefined	x2 = x.innerHtml;
//	x.innerHtml = "all about the beautiful republic of Costa Rica";
	xout.innerHTML = "this document loves me some " + x2.toString();
//	document.writeln("this document loves me some ");
//	document.writeln(x2);
}


function displayResult()
{
	var x=document.getElementById("js_val");
	var x2;
	var x3;
	
	if (isNaN(parseInt(x.innerHTML)))
		x2 = 0;
	else
		x2 = parseInt(x.innerHTML);
		
	x3 = x2 % 2;
	if ((x2%10) == 0)
	{
		showUser6();
	}

//	if (x3 == 0)
	if (true)
	{
		document.getElementById("tr_row1_block2").style.display="none";
		document.getElementById("tr_row2_block2").style.display="none";
		document.getElementById("tr_row3_block2").style.display="none";
		document.getElementById("tr_row4_block2").style.display="none";
		document.getElementById("tr_row5_block2").style.display="none";

		document.getElementById("tr_row1_block1").style.display="inline";
		document.getElementById("tr_row2_block1").style.display="inline";
		document.getElementById("tr_row3_block1").style.display="inline";
		document.getElementById("tr_row4_block1").style.display="inline";
		document.getElementById("tr_row5_block1").style.display="inline";
	}
	else if (x3 == 1)
	{
		document.getElementById("tr_row1_block1").style.display="none";
		document.getElementById("tr_row2_block1").style.display="none";
		document.getElementById("tr_row3_block1").style.display="none";
		document.getElementById("tr_row4_block1").style.display="none";
		document.getElementById("tr_row5_block1").style.display="none";

		document.getElementById("tr_row1_block2").style.display="inline";
		document.getElementById("tr_row2_block2").style.display="inline";
		document.getElementById("tr_row3_block2").style.display="inline";
		document.getElementById("tr_row4_block2").style.display="inline";
		document.getElementById("tr_row5_block2").style.display="inline";
	}	
	x2++;
	x.innnerHTML = x2.toString();
//	document.getElementById("peel").style.display="none";
}

function clearLowers2()
{
	document.getElementById("p6_block1").style.display="inline";
	document.getElementById("p6_block2").style.display="none";
}

function clearUppers2()
{
	document.getElementById("p6_block1").style.display="none";
	document.getElementById("p6_block2").style.display="inline";
}

function clearAllRows2()
{
	document.getElementById("p6_block1").style.display="none";
	document.getElementById("p6_block2").style.display="none";
}

function showAllRows2()
{
	document.getElementById("p6_block1").style.display="inline";
	document.getElementById("p6_block2").style.display="inline";
}

function clearLowers()
{
	document.getElementById("tr_row1_block2").style.display="none";
	document.getElementById("tr_row2_block2").style.display="none";
	document.getElementById("tr_row3_block2").style.display="none";
	document.getElementById("tr_row4_block2").style.display="none";
	document.getElementById("tr_row5_block2").style.display="none";

	document.getElementById("tr_row1_block1").style.display="inline";
	document.getElementById("pg131").style.width="85px";
	document.getElementById("pg132").style.width="85px";
	document.getElementById("pg133").style.width="85px";
	document.getElementById("pg134").style.width="85px";
	document.getElementById("pg135").style.width="85px";
	document.getElementById("pg136").style.width="85px";
	document.getElementById("pg137").style.width="85px";
	document.getElementById("pg13o").style.width="85px";

	document.getElementById("tr_row2_block1").style.display="inline";
	document.getElementById("tr_row3_block1").style.display="inline";
	document.getElementById("tr_row4_block1").style.display="inline";
	document.getElementById("tr_row5_block1").style.display="inline";
}

function clearUppers()
{
//	document.getElementById("tr_row1_block1").style.display="none";
	document.getElementById("tr_row2_block1").style.display="none";
	document.getElementById("tr_row3_block1").style.display="none";
	document.getElementById("tr_row4_block1").style.display="none";
	document.getElementById("tr_row5_block1").style.display="none";

	document.getElementById("tr_row1_block2").style.display="inline";
	document.getElementById("tr_row2_block2").style.display="inline";
	document.getElementById("tr_row3_block2").style.display="inline";
	document.getElementById("tr_row4_block2").style.display="inline";
	document.getElementById("tr_row5_block2").style.display="inline";
}

function clearAllRows()
{
//	document.getElementById("tr_row1_block1").style.display="none";
	document.getElementById("tr_row2_block1").style.display="none";
	document.getElementById("tr_row3_block1").style.display="none";
	document.getElementById("tr_row4_block1").style.display="none";
	document.getElementById("tr_row5_block1").style.display="none";

	document.getElementById("tr_row1_block2").style.display="none";
	document.getElementById("tr_row2_block2").style.display="none";
	document.getElementById("tr_row3_block2").style.display="none";
	document.getElementById("tr_row4_block2").style.display="none";
	document.getElementById("tr_row5_block2").style.display="none";
}

function showAllRows()
{
//	document.getElementById("tr_row1_block1").style.display="inline";
	document.getElementById("tr_row2_block1").style.display="inline";
	document.getElementById("tr_row3_block1").style.display="inline";
	document.getElementById("tr_row4_block1").style.display="inline";
	document.getElementById("tr_row5_block1").style.display="inline";

	document.getElementById("tr_row1_block2").style.display="inline";
	document.getElementById("tr_row2_block2").style.display="inline";
	document.getElementById("tr_row3_block2").style.display="inline";
	document.getElementById("tr_row4_block2").style.display="inline";
	document.getElementById("tr_row5_block2").style.display="inline";
}

function getNumEntries()
{
	var x=document.getElementById("num_entries");
	var i = 0;
	var x2 = parseInt(x.value);
	var idName;
	var element1;
	if ((x2 > 2) && (x2<=20))
	{
		for (i=3; i<=x2;i++)
		{
			id="entry1_name" 
			idName = "entry" + i.toString() + "_name";
			element1 = document.getElementById(idName);
			element1.style.display = 'inline';  
		}
	}
	idName = "entry" + "3" + "_label";
	element1 = document.getElementById(idName);
	element1.style.display = 'inline';  

}

function testJandys(str)
{
	document.getElementById("myselectDO").name="displayOddsP";
	document.getElementById("myselectDO").value = str;
	document.getElementById("displayOddsO").name="displayOdds";
	document.getElementById("displayOddsO").value = "Submit";
	document.forms["displayOddsF"].submit();
}

function createCookie(name,value,days) 
{
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

// maybe use this "createCookie('ppkCompareSite',this.value,'')"
function writeCompareSiteCookie(str)
{
	createCookie("ppkCompareSite",str,30);
	location.reload();
}

function mainLoad()
{
//	showUser();
// mtf, temporarary	loadUpdateTimer(4);
	createCookie("ppkRealTimeUpdates","1","");
	createCookie("ppkHeartBeat","0","");
	document.getElementById('realTimeUpdates').value='Turn Off Real-Time Updates';
	var ans = readCookie("ppkCompareSite");
	if (ans == "1")
	{
//		showUser6_bov();
		ans = "2";
	}
	else
	{
//		showUser6();
		ans = "3";
	}
}

var MIN_BET_VALUE = 1;
var MAX_BET_VALUE = 10000000;
var MAX_BET_VALUE2 = 100;
var ENTRY_DIGITS = 1; // change if entry_num > 9
var MAX_GAMES = 50;

function writeDisplayOddsCookie(str)
{
	createCookie("ppkDisplayOdds",str,30);
	location.reload();
}

function clocky()
{
var d=new Date();
var t=d.toLocaleTimeString();
document.getElementById("clock").value=t;
}

function testCompareSiteCookie()
{
	var ans = readCookie("ppkRealTimeUpdates");
 	document.getElementById("cookie_answer").innerHTML=ans;
//	loadUpdateTimer(300);
//	myVar=clearInterval(myVar);
//	var =self.setInterval(function(){clock()},1000);
}

function goBack()
{
	window.history.back();
}

function redirect(url)
{
//	window.location.assign(url);
	window.location.assign("http://www.hellokisses.com")
}

function validateBetForm2()
{
	var x=document.forms["bform"]["betbox_e2_game1"].value;
//	var checkbox_arr=document.forms["bform"]["spread_game1[]"].value;
	var checkbox_arr=document.getElementById('testchecks1');
//	if (checkbox_arr==null || checkbox_arr=="")
// 	{
//  		alert("Checkbox_arr must be filled out");
//  		return false;
//  	}

  	if (!checkbox_arr.checked)
  	{
  		alert("Checkbox_arr must be checked");
  		return false;
  	}

	if (x==null || x=="")
  	{
  		alert("Betbox_e2_game1 must be filled out");
  		return false;
  	}
}

function check_checkboxes()
{
  var cins = document.getElementsByTagName('input');

  for (var i = 0; i < cins.length; i++)
  {
    if (cins[i].type == 'checkbox')
    {
       if (cins[i].checked && cins[i].id == 'testchecks1') 
       {
       		return true;
       }
    }
  }
  return false;
}

function get_betbox_str(str)
{
	var bet_box_val=document.forms["bform"][str].value;
	var retstr = "";

	if (bet_box_val!=null && bet_box_val!="")
		retstr = bet_box_val;
  	return retstr;
}

function get_pool_size(acct_type)
{
	var str = "pool_size_" + acct_type + "_" + game_num;
	var bet_box_val=document.forms["bform"][str].value;
	var retstr = "";

	if (bet_box_val!=null && bet_box_val!="")
		retstr = bet_box_val;
  	return retstr;
}


function check_betbox_val(bet_box_val, pool_size_str)
{
	var retval = 0;
	var bb_val_int = parseInt(bet_box_val);
	var pool_size = parseInt(pool_size_str);
	var pool_max_int = 0;

	if (pool_size !== pool_size)  // test for Nan
		retval = 1;
	else if (bb_val_int !== bb_val_int)  // test for Nan
		retval = 1;
	else if ((bb_val_int < MIN_BET_VALUE) || (bb_val_int > MAX_BET_VALUE))
		retval = 1;
	if (!retval)
	{
		pool_max_int = pool_size / 10;
  		if ((bb_val_int > pool_max_int) && (bb_val_int > MAX_BET_VALUE2))
  		{
  			if (pool_max_int > MAX_BET_VALUE2)
  				retval = pool_max_int;
  			else
  				retval = MAX_BET_VALUE2;
  		}
  	}
  	return retval;
}

function check_valid_betbox(str, pool_size_str)
{
	var bet_box_val=get_betbox_str(str);
	var retval = 0;  // is good
	var retval2 = 0;
	var bet_val_flt = 0.0;
	var pool_size = document.getElementById(pool_size_str).value; 	
 	retval2 = check_betbox_val(bet_box_val, pool_size);
 	if (retval2)
 		retval = -1 * retval2;  // error
 	else
 	{
		bet_val_flt = parseFloat(bet_box_val);
		if (bet_val_flt !== bet_val_flt)  // test for Nan
			bet_val_flt = 0.0;

 		retval = bet_val_flt;  // good
 	}
  	return retval;
}

function validate_checkboxes(acct_balance_str="")
{
	var cins = document.getElementsByTagName('input');
  	var id_str = "";
  	var entry_num_ind = -1;
  	var game_num_ind = -1;
  	var acct_type_ind = -1;
  	var acct_type_str = "";
  	var game_num_str = "";
  	var acct_type_str2 = "";
  	var acct_type_str3 = "";
  	var entry_num_str = "";
  	var checkBoxName = "";
  	var retval = 0; // 0 is good
  	var retval2 = 0;
  	var total_bet_val = 0.0;
 
  	for (var i=0; i<cins.length; i++)
  	{
  		if (cins[i].type == 'checkbox')
    	{
    		if (cins[i].checked)
    		{
  				id_str = cins[i].id;
  				entry_num_ind = id_str.indexOf("_e") + 2;
  				game_num_ind = id_str.indexOf("_g") + 2;
  				acct_type_ind = id_str.indexOf("cb_") + 3;
  				if ((game_num_ind > 1) && (entry_num_ind > 1) && (acct_type_ind > 2))
  				{
  					acct_type_str = id_str.substring(acct_type_ind, acct_type_ind+2);
  					game_num_str = id_str.substring(game_num_ind);
  					entry_num_str = id_str.substring(entry_num_ind, entry_num_ind+ENTRY_DIGITS);
  					acct_type_str3 = acct_type_str;
  					if (acct_type_str == 'sp')
  					{
  						acct_type_str2 = 'spread';
  					}
  					else if (acct_type_str== 'ou')
  					{
  						acct_type_str2 = 'overunder';
  					}
  					else if (acct_type_str == 'pw')
  					{
  						acct_type_str2 = 'pwp';
  						acct_type_str3 = 'pwp';
  					}
  					else
  					{
  						acct_type_str2 = acct_type_str;
  					}
  					checkBoxName = 'betbox_e' + entry_num_str + '_game' + game_num_str;
  					pool_size_str = 'pool_size_' + acct_type_str3 + '_game' + game_num_str;
// yo, mtf
  					retval2 = check_valid_betbox(checkBoxName, pool_size_str);
  					if (retval2 >= 0)
  					{
  						retval = 0;
						total_bet_val += retval2;
  					}
  					else
  						retval = -1 * retval2;
  				}
 
 /* 
  * this shouldn't happen, but if it does let the server handle it.
  				else
 				{	
  					retval = false;
  				}
*/
  				if  (retval > 0)
  					break;
  			}
  		}
  	}  

	if (!retval)
	{
		acct_balance = parseFloat(acct_balance_str);
		if (acct_balance !== acct_balance)  // test for Nan
  		{
  			acct_balance = -1.1;
  		}

  		if ((total_bet_val > acct_balance) && (acct_balance > -1.0))
  			retval = 3;
	}
	return retval;
}


function is_checkbox_checked(acct_type, entry_num, game_num)
{
	var cb_id_str = 'cb_' + acct_type + '_e' + entry_num + '_g' + game_num;
	var cins = document.getElementsByTagName('input');
  	var retval = false;

   	for (var i=0; i<cins.length; i++)
  	{
  		if (cins[i].id == cb_id_str)
    	{
    		if (cins[i].checked)
   			{
   				retval = true;
   			}
   			break;
   		}
   	}
	return retval;
}

function get_hidden_val(id_str)
{
	var cins = document.getElementsByTagName('input');
  	var retstr = "";
 
  	for (var i=0; i<cins.length; i++)
  	{
  		if ((cins[i].id == id_str) && (cins[i].type == 'hidden'))
    	{
    		retstr = cins[i].value;
    		break;
    	}
    }
    return retstr;
}


function validate_betboxes()
{
	var total_games_str = get_hidden_val('total_games');
	var total_games_int = 0;
	var total_games = 0;
  	var num_entries = 3;
  	var retval = true; 
  	var j = 0;
  	var game_num = 0;
  	var entry_num = 0;
  	var retval = true;
  	var num_checked_boxes = 0;
  	var getbox_val = "";

  	if (total_games_str != "")
  	{
  		total_games_int = parseInt(total_games_str);
  		if ((total_games_int > 0) && (total_games_int <= MAX_GAMES))
  			total_games = total_games_int;
  	}

  	if (total_games != 6)
  		total_games = 6;

  	for (var i=0; i<total_games; i++)
  	{
  		game_num = i + 1;
	  	for (j=0; j<num_entries; j++)
	  	{
	  		entry_num = j + 1;
	  		num_checked_boxes = 0;
  			checkBoxName = 'betbox_e' + entry_num.toString() + '_game' + game_num.toString();

			getbox_val = get_betbox_str(checkBoxName);
			if (getbox_val.Trim() != "")
  			{
  				if (check_valid_betbox(checkBoxName, "") >= 0)
  				{
  					if (j < (num_entries-1))
  					{
 						if (is_checkbox_checked('sp', entry_num.toString(), game_num.toString()))
 							num_checked_boxes++;
						if (is_checkbox_checked('ml', entry_num.toString(), game_num.toString()))
 							num_checked_boxes++;
						if (is_checkbox_checked('ou', entry_num.toString(), game_num.toString()))
 							num_checked_boxes++;
 					}
					if (is_checkbox_checked('pwp', entry_num.toString(), game_num.toString()))
						num_checked_boxes++;

 					if (num_checked_boxes < 1)
 						retval = false;
  				}
  				else
  				{
  					retval = false;
  				}
  			}

  			if (retval == false)
  				break;
	  	}

		if (retval == false)
			break;
	}

	return retval;
}

function validateBetForm(acct_balance_str="")
{
	var retval = true;
	var vcb = validate_checkboxes(acct_balance_str);
	if(vcb == 1)
    {
        alert("Checked boxes have invalid bet amounts, asshole!");  
        retval = false;
	}
	else if(vcb == 3)
    {
        alert("Bet Amount Exceeds Balance. Account Balance = " + acct_balance_str);
        retval = false;
	}
	else if(vcb > 1)
    {
        alert("Bet Amount Too Much For Pool Size. Max Bet For Pool is " + vcb.toString() + ".\nLarger Bets Will be Accepted As Pool Size Grows.");
        retval = false;
	}
	else if(!validate_betboxes())
    {
 		alert("Bet amount entered, but no selection made, asshole ho!");
        retval = false;
    }
    return retval;
}

function testfunc_mtf()
{
	var tb_name = 'betbox_1';
	var x=document.getElementsByName(tb_name)[0];
	x.value="32.32";
}

function recalcTotals(acct_balance_str="")
{
	var i = 0;
	var j = 0;
	var reterr = 0;
	var string_b = 'betbox_';
	var string_p = 'pool_size_p';
	var bbox_str = '';
	var result = '';
	var e1;
	var total_bet_val = 0.0;
	var bet_vals_arr = new Array();
	var odd_vals_arr = new Array();
	var pool_size_arr = new Array();
	var acct_balance = -1.0;

	string_b = 'betbox_';
	for (i=0; i<100000; i++)
	{
		j = i + 1;
		bbox_str = string_b + j.toString();
		e1 = document.getElementsByName(bbox_str)[0];
		if (document.contains(e1))
		{
			result = parseFloat(e1.value);
  			if (result !== result)  // test for Nan
  			{
  				reterr = 1;
  				break;
  			}
			e1.value = result.toFixed(2);
			bet_vals_arr[i] = result;
			total_bet_val += result;
		}
		else
			break;
  	}  	

  	string_b = 'odds_bet_b';
  	string_p = 'pool_size_b'
	for (i=0; i<bet_vals_arr.length; i++)
	{
		j = i + 1;
		bbox_str = string_b + j.toString();
		e1 = document.getElementsByName(bbox_str)[0];
		if (document.contains(e1))
		{
			result = parseFloat(e1.value);
			if (result !== result)  // test for Nan
  			{
  				result = 1.0;
  			}
			odd_vals_arr[i] = result;
		}
		else
			odd_vals_arr[i] = 1.0;

		bbox_str = string_p + j.toString();
		e1 = document.getElementsByName(bbox_str)[0];
		if (document.contains(e1))
		{
			result = parseFloat(e1.value);
			if (result !== result)  // test for Nan
  			{
  				result = 0.0;
  			}
			pool_size_arr[i] = result;
		}
		else
			pool_size_arr[i] = 0.0;
  	}

  	string_b = 'oddbox_';
  	var est_win = 0.0;
	for (i=0; i<bet_vals_arr.length; i++)
	{
		if (reterr)
			break;
		j = i + 1;
		bbox_str = string_b + j.toString();
		e1 = document.getElementsByName(bbox_str)[0];
		if (document.contains(e1))
		{
			est_win = bet_vals_arr[i] + (odd_vals_arr[i] * bet_vals_arr[i]);
			e1.value = est_win.toFixed(2);
		}
		else
			est_win = 1.0;

		reterr = check_betbox_val(bet_vals_arr[i], pool_size_arr[i]);
		if (reterr)
			break;
  	}  	

  	if (!reterr)
  	{
		acct_balance = parseFloat(acct_balance_str);
		if (acct_balance !== acct_balance)  // test for Nan
  		{
  			acct_balance = -1.1;
  		}

  		if ((total_bet_val > acct_balance) && (acct_balance > -1.0))
  			reterr = 3;
  	}

	e1 = document.getElementsByName('total_bet_val')[0];
	if (document.contains(e1))
	{
		if (reterr)
			e1.value = "catsbigvag" + reterr.toString();	
		else
			e1.value = total_bet_val.toFixed(2);
	}
}
