<?php
require("scriptheader.php");
require("frontendheader.php");
require("bb_function_lib.php");
?>



<div class='sitecontent'>
<?php
 
?>



<form name="BForm"  action="signin.php" method="post"  >
 
			<div class="instructions" align='center'>
  			Please enter your user name and password. <br>
			Don't have an account?  <a href="register.php">Register now</a>! It's free!<br>
			<!--
  			Forgotten your password? <a href="signin.php?mode=forgotpassword">Click here</a> to have us email it to you.<BR><BR>
			-->
			</div>
			<TABLE align="center">
				<TR><TD></TD></TR>
				<TR><TD class="formcaption">Email or Username</TD><TD><input name="login_username" id="USERNAME"  type="text" maxlength="86" size="30" /></TD></TR>
				<TR><TD class="formcaption">Password</TD><TD><input name="login_password" id="PASSWORD"  type="password" maxlength="86"  size="30" /></TD></TR>
				<TR><TD>&nbsp;</TD></TR>
				<?php
					$alttext="login";
					$butwidth=112;
					$butheight=24;
					$butfilename="login_btn";
				?>
				<TR><TD colspan=2 ALIGN="center"><div id='b4' style='background-image: url(images/<?=$butfilename?>.png);width:<?=$butwidth?>px;height;<?=$butheight?>px'><a href='javascript:document.BForm.submit()'><img alt="<?=$alttext?>" id='b4h' src='images/<?=$butfilename?>_hover.gif' border='0'></a></div></TD></TR>
				<TR><TD>&nbsp;</TD></TR>
				<input name="login_dest" type="hidden" value="<?=$_REQUEST["login_dest"]?>"  />
				<input name="ultdest" type="hidden" value="<?=$ultdest?>"  />
				<TR>
					<TD colspan=2 CLASS="instructions" align="center">




  
 					</td>
 				</TR>
			</TABLE>
		</form>

</div>


<?php
require("frontendfooter.php"); 
?>