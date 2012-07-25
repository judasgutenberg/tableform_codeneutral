<?
include("constants_user.php");
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

///////////////////////////////////////
/////////User functions///////////////
/////////////////////////////////////

function GenericWhoIsLoggedIn()
{
	global $COOKIE_VARS;
	
	$strCookieVal= subtractletters( $_COOKIE[cookie], encryptionkey);

	if ($strCookieVal!="")
	{
		return($strCookieVal);
	}
}

function GenericIsLoginValid($strDatabase, $strUser, $strPassword)
{
	$out=false;
	$sql=conDB();
	//use the function data to do a query 
 	$strSQL="SELECT " . password . "  from " . $strDatabase . "." . user_table . " WHERE " . username ." = '" . $strUser . "'";
	$records = $sql->query($strSQL);
	$record=$records[0];
	if ($record[password]==$strPassword and $strPassword!="")
		{
			$out=true;
		}
	return($out);
}

function GenericTestAndSetLogin($strDatabase, $strUser, $Password)
{
	if (GenericIsLoginValid($strDatabase, $strUser, $Password))
	{
		GenericsetLoggedIn($strUser);
		$out=$strUser;
	}
	else
	{
		$out="";
	}
	return($out);
}

 


function GenericsetLoggedIn($strUser)
{

	//setcookie("these",$strUser, time()+9999, "/");
	if ( setcookie(cookie, addletters($strUser, encryptionkey), time()+1131536000, "/" ))
	{
		//echo "cookie set!";
	}
}

function Genericlogout()
{
	//echo "#";
 	//global $COOKIE_VARS;
	if (setcookie(cookie, "x", mktime(12,0,0,1, 1, 1990), "/" ))
	{
		//echo "cookie cleared!";
	}
}

function Genericloginarrest($strPHP)
{
	$strUserNameFormItem= qpre . username;
	$strPasswordFormItem=qpre . password;
	$preout="";
	$out="";
	$preout.="<h2>Log in here:</h2>\n";
 
	$out.="<form target=\"_top\" action=\"" . $strPHP . "\" method=\"POST\">\n";
	$out.="\n";
	$out.="<tr><td>\n";
	$out.="Username:</td><td><input type=\"text\" name=\"" . $strUserNameFormItem . "\" value=\"\"></td></tr>\n";
	$out.="<tr><td>\n";
	$out.="Password:</td><td><input type=\"password\" name=\"" . $strPasswordFormItem . "\" value=\"\"></td></tr>\n";
	$out.="<tr><td colspan=\"2\" align=\"right\"><input type=\"Submit\" value=\"Login\"></td></tr>\n";
	$strAvoidList=$strUserNameFormItem . " " . $strPasswordFormItem;
	if ($_REQUEST[qpre . "mode"]=="logout")
	{
		$strAvoidList.= " " .  qpre .   "mode";
		$out.=HiddenInputs(Array( qpre .   "mode"=>""), "", "");
	}
	//echo  $strAvoidList;
	$out.=HiddenInputs($_REQUEST, "", $strAvoidList);
	$out.="</form>\n";
	$out=$preout . TableEncapsulate($out, false);
	return $out;
}

function GenericLoginDecisions($strDatabase,  $strPHP,  &$strUser, $bwlSimpleOutput)
//returns $strUser as a "by reference" variable
{
	$strUser=$_REQUEST[qpre . username];
	$Password=$_REQUEST[qpre . password];
	$skiplogintest=false;
	$out="";
	if ($_REQUEST[ qpre . "mode"]=="logout")
		{
			Genericlogout();
			$out="You have been logged out.";
			
			$skiplogintest=true;
		}
	if (countrecords($strDatabase , user_table )<1)
		{
			$strUser="-no security-";
			$skiplogintest=true;
			$bwlSimpleOutput=true;
		}
	elseif ($strUser!="" && $Password!="")
		{
			$strUser=GenericTestAndSetLogin($strDatabase, $strUser, $Password);
			
			if ($strUser=="")
			{
				$out="<span class=\"feedback\">The Username/Password combination you typed has failed.</span>";
			}
			else 
			{
				$skiplogintest=true;
			}
		}
 	if (!$skiplogintest)
		{
			//if ($_REQUEST[ qpre . "mode"]!="logout")
			{
				$strUser=GenericWhoIsLoggedIn();
			}
		}	
	if (!$bwlSimpleOutput)
		{
			if ($strUser!="")
				{
					$strPHP = replaceMultipleQueryVariables(qpre .username, "", qpre . password,  "", qpre ."mode", "logout");
					$out="<div class=\"loginstring\">You are currently logged in as <b>" . $strUser . "</b>.  (<a href=\"" . $strPHP  . "\">Logout</a>)</div>\n";
				}
			if ($strUser=="" )
				{
					$out.=Genericloginarrest($strPHP);
				}
		}
	elseif ($strUser=="")
		{
			$out="You do not have permissions to see this content.";
		}
	return $out;
}




 

function GenericGetUserID($strDatabase, $strAdmin)
{
	$sql=conDB();
	$strSQL="SELECT " . user_pk . " FROM  " . $strDatabase . "." . user_table . "  WHERE " . username ." = '" . $strAdmin . "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$out= $record[user_pk];
	return $out;
}

?>