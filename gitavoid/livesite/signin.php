<?php
require("scriptheader.php");
require("frontendheader.php");

$name=$_REQUEST["n"];

$strSQL="SELECT * FROM content  WHERE name='" . singlequoteescape($name) . "'";
$sql=conDB();
$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
 
$record=$records[0];

 
echo "<tr><td valign='top'>\n";
 
 
 
		if($mode=="forgotpassword")
		{
			echo "<div class='taskheading'>(Password Reminder)</div>";
		?>
		<form name="BForm"  action="signin.php" method="post"  >
		<div class="instructions">
		 Please enter your Featurewell.com username or your email address, so we can email you your password.<BR><BR> 
		 </div>
		<table><tr><td class="formcaption">
		 Email</td><td> <input name="email_forgottenuser" id="USERNAME"  type="text" maxlength="36"  size="30"/> </td><td><a href='javascript:document.BForm.submit()'><img id='g2' src='images/emailbutton.png' border='0'></td></tr></table>

		
		 
		 </div>
		</form>
		<?php
		
		}
		else
		{	
			echo "<div class='taskheading'>(Sign-in)</div>";
		?>
 		<form name="BForm"  action="signin.php" method="post"  >
		<INPUT TYPE="hidden" NAME="x_dest" VALUE="index.cfm?Doc=Signin.cfm&Action=1">
			<FONT class="instructions">
  			Please enter your user name and password.<BR><BR>
  			Forgotten your password? <a href="signin.php?mode=forgotpassword">Click here</a> to have us email it to you.<BR><BR>

			</FONT>
			<TABLE align="center">
				<TR><TD></TD></TR>
				<TR><TD class="formcaption">Username or Email</TD><TD><input name="login_username" id="USERNAME"  type="text" maxlength="86" size="30" /></TD></TR>
				<TR><TD class="formcaption">Password</TD><TD><input name="login_password" id="PASSWORD"  type="password" maxlength="86"  size="30" /></TD></TR>
				<TR><TD>&nbsp;</TD></TR>
				<TR><TD colspan=2 ALIGN="center"><a href='javascript:document.BForm.submit()'><img id='g2' src='images/submitbutton.png' border='0'></a></TD></TR>
				<TR><TD>&nbsp;</TD></TR>
				<input name="login_dest" type="hidden" value="<?=$_REQUEST["login_dest"]?>"  />
				<TR>
					<TD colspan=2 CLASS="Instructions" align="center">Having Trouble? <a href="content.php?n=cookiehelp">Click here</a> to find out how to enable cookies.</TD>
				</TR>
				<TR>
					<TD colspan=2 CLASS="instructions" align="center">




  
  
					<div class="instructions">
					<BR><BR>Have questions?<BR>Please call our sales office at +1 (212) 924 2283<BR>or email <A HREF="mailto:sales@featurewell.com?subject=Sales%20Information%20Request">sales@featurewell.com</A></B>
					</div>
 					</td>
 				</TR>
			</TABLE>
		</form>
		
 
 
 
 
<?php
 		}
echo "</td></tr>\n";
?>













<?php
require("frontendfooter.php");
?>