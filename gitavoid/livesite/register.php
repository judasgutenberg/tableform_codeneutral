<?php
require("scriptheader.php");
$sql=conDB(); 
$mode=$_REQUEST["mode"];
 
if($mode=="new")
{
	$ur=$_POST;
	$button="register";
	$titleheading="(Register)";

}
else
{
	$ur=GenericDBLookup(our_db,"USERS", "EMAIL", $strUser, "");
	
	$button="save";
	$titleheading="(My Account)";
}
//var_dump($ur);
//GenericFormSaver($strDatabase, $strTable, $strPrimaryKey, $strPKVal, $strFieldIgnoreList, $bwlDebug=false, $bwlWorkFromSchema=false, $bwlDontOverwriteWithNulls=true, $bwlCreateSchema=false, $strImageUploadKeyFieldName="")

if(count($_POST )>2)
{
	//need some basic validation here!!
 	$_POST["EMAIL"]=strtolower($_POST["EMAIL"]);
	$_POST["USERNAME"]=strtolower($_POST["USERNAME"]);
 	$possibleEmailConflict=GenericDBLookup(our_db,"USERS", "EMAIL", $_POST["EMAIL"], "ID");
	
	$possibleUsernameConflict=GenericDBLookup(our_db,"USERS", "USERNAME", $_POST["USERNAME"], "ID");
	
	if($mode=="new")
	{
		//$_POST["EMAIL"]=str_replace("'", "", $_POST["EMAIL"]);
		//prepopulate the $_POST with things i need to set in the db that are not in the form
		$_POST["TIMESTAMP"]=date("Y-m-d H:i:s");
		$_POST["ROLES"]="C";
		$_POST["ACTIVE"]="1";
		$_POST["EMAIL_FORMAT"]="H";
		$_POST["EMAIL_DOW"]="2";
		$_POST["RATING_ID"]="12";
		$_POST["HITS"]="1";
		$_POST["USER_AGENT"]=addslashes($_SERVER['HTTP_USER_AGENT']);
		$_POST["REMOTE_ADDR"]=addslashes($_SERVER['REMOTE_ADDR']);
		if($possibleEmailConflict!="")
		{
			$errors.="The email you have entered is already in use by another account.<br>";
		}
		if($possibleUsernameConflict!="")
		{
			$errors.="The username you have entered is already in use by another account.<br>";
		}
	}
	else
	{
		if($possibleEmailConflict!=$ur["ID"])
		{
			$errors.="The email you have entered is already in use by another account.<br>";
		}
		if($possibleUsernameConflict!=$ur["ID"])
		{
			$errors.="The username you have entered is already in use by another account.<br>";
		}
	
	
	}
	if($errors=="")
	{
		if($_POST["EMAIL"]!=""  && $_POST["LAST_NAME"]!="")
		{
			$IDOut=GenericFormSaver(our_db, "USERS", "ID", $ur["ID"], "CATEGORY_ID[] mode login_dest", false, false, true, false, "");
			setLoggedIn($_POST["EMAIL"]);
			$ur=GenericDBLookup(our_db,"USERS", "EMAIL", $strUser, "");
			
			$userID=gracefuldecay($IDOut , $ur["ID"] );
		}
		else
		{
			$errors="You must be trying to hack this site.";
		}
	}
	//handle checkbox stuff!
	//$strSQL="DELETE FROM USER_CATEGORY WHERE USER_ID=" . intval($userID);
	//echo $strSQL . "<BR>";
	//$sql->query($strSQL);
	DeleteBySpec(our_db, "USER_CATEGORY", Array("USER_ID"=>intval($userID)));
	//echo mysql_error() . "<BR>";
	foreach($_POST["CATEGORY_ID"] as $catid)
	{
		 
		//$strSQL="INSERT INTO   USER_CATEGORY(USER_ID, CATEGORY_ID ) VALUES (".  intval($userID) . "," . intval($catid) . ")";
		//echo $strSQL . "<BR>";
		//$sql->query($strSQL);
		UpdateOrInsert(our_db, "USER_CATEGORY", "", Array("USER_ID"=>intval($userID), "CATEGORY_ID"=>intval($catid)));
		//echo mysql_error() . "<BR>";
	}
	if( $login_destination =="")
	{
		$login_destination=$homepage . "?c=";
	}
	if($mode=="new"  && $errors=="")
	{
		
		 
		header("location: " . $login_destination . "&messages=Your account was created successfully." );
	}
	else if($mode!="new"  && $errors=="")
	{
		header("location: " . $login_destination . "&messages=Your account was updated successfully." );
	}
}

//populate user categories
$strSQL="SELECT CATEGORY_ID  FROM   USER_CATEGORY   WHERE USER_ID=" . intval($ur["ID"]) . "";
$records = $sql->query($strSQL);
//echo $strSQL . "<BR>";
//echo mysql_error();
$usercats=array();
foreach($records as $record)
{
	$usercats[]=$record["CATEGORY_ID"];
}

require("frontendheader.php");
?>


	
<tr><td  valign='top'>

<div class="taskheading">
<?php
echo $titleheading;

?>
</div>
<?php
 if($mode=="new")
{
	?>
	<div class='instructions' style='padding-left:0px;padding-right:120px'>
	 <?php 
	echo GenericDBLookup(our_db,"content", "name", "reg_blurb", "content");
	?>
	 
	 </div>
			 <?php  
 }
			 
			 //requiredfield|errormessage|isdate(1 or 0)|additionaltest(such as indexOf('@')>0)~next record....
			$strRequiredConfig="FIRST_NAME|You must enter a first name.|0~";
			$strRequiredConfig.="LAST_NAME|You must enter a last name.|0~";
			$strRequiredConfig.="EMAIL|You must enter an email.|0|indexOf(String.fromCharCode(64))>1~";
			$strRequiredConfig.="PASSWORD|You must enter an password.|0|~";
			$strRequiredConfig.="CONFIRM|You must enter your password twice.|0~";
			$strRequiredConfig.="PHONE|You must enter your phone number.|0~";
			$strRequiredConfig.="USERNAME|You must enter a username.|0~";
			$strRequiredConfig.="CIRCULATION_ID|You must enter the circulation of your publication.|0~";
			$strRequiredConfig.="COUNTRY_CODE|You must enter your country.|0~";
			$strLastMinuteTests="if(f.PASSWORD.value.length<4){thiserror+=\"Your password must be longer than three characters.\"};\n";
			$strLastMinuteTests.="if(f.PHONE.value.length<10){thiserror+=\"Your phone must be longer than nine characters.\"};\n";
			 include "regcheckjs.php"; 
			 if( $errors!="")
			 {
				// echo "<div class='errors'>" . $errors . "</div>";
			 }
			 ?>
					
				<form name="BForm" id="frmReg" action="register.php" method="post"     ">
			 
				<INPUT TYPE="hidden" NAME="x_dest" VALUE='index.cfm?Doc=Register.cfm'>
					<TABLE cellpadding="1" cellspacing="0" width="90%" border="0">
						<TR><TD class="formcaption" WIDTH="35%">First Name</TD> <TD class="redstar"><input name="FIRST_NAME" id="FIRST_NAME"  type="text" maxlength="50"  size="38"  value="<?=$ur["FIRST_NAME"]?>" /></td></TR>
						<TR><TD class="formcaption">Last Name</td>  <TD class="redstar"><input name="LAST_NAME"   value="<?=$ur["LAST_NAME"]?>" id="LAST_NAME"  type="text" maxlength="50"  size="38"  /></td></TR>

						<TR><TD class="formcaption">Job Title</TD>  <TD class="redstar"><input name="JOB_TITLE" id="JOB_TITLE"  value="<?=$ur["JOB_TITLE"]?>" type="text" maxlength="50"  size="38"  /></td></TR>		
						<TR><TD class="formcaption">Publication</TD><TD class="redstar"><input name="PUBLICATION" id="PUBLICATION"  type="text" maxlength="50"  size="38" value="<?=$ur["PUBLICATION"]?>"  /></td></TR>
						<TR>
							<TD class="formcaption">Publication Type</TD>
							<TD class="redstar">
	 
								
								<?
								$dropdownconfig="11|N/A-5|Web Site-6|Local Newspaper-7|National Newspaper-8|Magazine-9|Corporation";
								echo  GenericDataPulldown($dropdownconfig, 0, 1, "PUBLICATION_TYPE_ID", $ur["PUBLICATION_TYPE_ID"] );
								?>
							
							</td>

						</TR>
						<TR>
							<TD class="formcaption">Circulation</TD>
						
							<TD class="redstar">
							<?
							$dropdownconfig="1|&lt; 100,000-2|100,000 &ndash; 250,000-3|250,000 &ndash; 500,000-4|&gt; 500,000";
							echo  GenericDataPulldown($dropdownconfig, 0, 1, "CIRCULATION_ID", $ur["CIRCULATION_ID"] );
							?>
	 
							</TD>
						</TR>
						<TR><TD class="formcaption">Phone</TD>  <TD class="redstar"><input name="PHONE" value="<?=$ur["PHONE"]?>" id="PHONE"  type="text" maxlength="20"  size="38"  /></td></TR>

						<TR><TD class="formcaption">E-mail</TD> <TD class="redstar"><input name="EMAIL" value="<?=$ur["EMAIL"]?>" id="EMAIL"  type="text" maxlength="50"  size="38"  /></td></TR>
						<TR><TD class="formcaption">Address</TD><TD class="redstar"><input name="ADDRESS_1" value="<?=$ur["ADDRESS_1"]?>"  id="ADDRESS_1"  type="text" maxlength="80"  size="38"  /></td></TR>
						<TR><TD class="formcaption">City</TD>   <TD class="redstar"><input name="ADDRESS_2" id="ADDRESS_2" value="<?=$ur["ADDRESS_2"]?>" type="text" maxlength="80"  size="38"  /></TD></TR>
						<TR><TD class="formcaption">State / Province</TD><TD class="redstar"><input name="STATE" id="STATE" value="<?=$ur["STATE"]?>" type="text" maxlength="80"  size="38"  /> </TD></TR>
                   <TR><TD class="formcaption"> Zip / Postcode</TD><TD class="redstar">
                    <input name="ZIP" id="ZIP" value="<?=$ur["ZIP"]?>" type="text" maxlength="80"  size="38"  />
                </TD>
            </TR>
						<TR>
							<TD class="formcaption">Country</TD>
							<TD class="redstar">
							<?php echo 
							 foreigntablepulldown(our_db, "COUNTRY", "PHONE_CODE", $ur["COUNTRY_CODE"], "COUNTRY_CODE", $namereturn, false, "", "", $strWhereClause="", "", $truncsize=66);
							?>
							 
							</td>
						</TR>
						<TR><TD class="formcaption">Username</TD><TD class="redstar"><input value="<?=$ur["USERNAME"]?>"  name="USERNAME" id="USERNAME"  type="text" maxlength="16"  size="25"  /></td></TR>

						<TR><TD class="formcaption">Password</TD><TD class="redstar"><input value="<?=$ur["PASSWORD"]?>" name="PASSWORD" id="PASSWORD"  type="password" maxlength="16"  size="25"  /></td></TR>
						<TR><TD class="formcaption">Confirm Password</TD> <TD class="redstar"><input   value="<?=$ur["PASSWORD"]?>" name="CONFIRM" id="CONFIRM"  type="password" maxlength="16"  size="25"  /></td></TR>
						<TR><TD class="formcaption">How did you hear of Featurewell.com?</TD><TD><input name="HOW_HEARD" value="<?=$ur["HOW_HEARD"]?>" id="HOW_HEARD"  type="text" maxlength="80"  size="38"  /></td></TR>
				 
						</table>
						<input type="hidden"   value="<?=$mode?>" name="mode"/>
						<input type="hidden"   value="<?=$login_destination?>" name="login_dest"/>
						<?php
						if($mode!="new")
						{
							?>
							
							<input type="hidden"  value="<?=$ur["ID"]?>" name="ID" />
							
							<?php
						
						}
						
						?>
						 <div class="instructions"  style='margin-top:50px;margin-left:90px'>We regularly send editors an electronic bulletin of our latest stories. <br>
              	Please select categories of stories that you wish to receive.</div>
						<div style='margin-left:70px;margin-top:20px'> 
							<?php echo DisplayCategoryCheckboxes($usercats);
							?>
						</div>
						<script>
						function selectall()
						{
							 
							for(i=0; i<30; i++)
							{
								var thiscb=document.getElementById('cb' + i);
								if(thiscb)
								{
									thiscb.checked=true;
								}
							}
						}
						function clearall()
						{
							 
							for(i=0; i<30; i++)
							{
								var thiscb=document.getElementById('cb' + i);
								if(thiscb)
								{
									thiscb.checked=false;
								}
							}
						}
			
						
						
						</script>
		 				<div style='margin-right:210px;margin-top:10px;text-align:right'> 
								<a href="javascript:selectall()"  ><img  id="g2" border='0' src="images/selectall.png"></a> 
								<a  href="javascript:clearall()"><img id="g3" border='0' src="images/clearall.png"></a>
								<a  style='margin-left:10px' href="javascript:if(regcheckform()){document.BForm.submit()}"><img id="g4" border='0' src="images/<?=$button?>.png"></a>
					 
						</div>
				 
				</form>

			</td>
		</tr>
 

<?php
function DisplayCategoryCheckboxes($arrDefaults)
{
	$sql=conDB();
	$strSQL="SELECT ID, NAME  FROM  " . our_db . ".CATEGORY ORDER BY NAME";
	$records = $sql->query($strSQL);
	$out="<table cellpadding=\"0\" border=\"0\" cellspacing=\"0\"  style='margin:5px'><tr>\n<td valign='top'>\n";
	$intCount=0;
	$totalcount=0;
	foreach($records as $record)
	{
		$strChecked="";
		if(in_array($record["ID"],$arrDefaults) )
		{
			$strChecked="checked";
		}
		$out.="<div class='formcaption-left'><input id='cb" . $totalcount. "' style='margin-left:24px;margin-right:5px; margin-top:2px' type='checkbox' name='CATEGORY_ID[]' value='" .$record["ID"]. "' " . $strChecked . ">" . $record["NAME"]. "</form>";
		$intCount++;
		if($intCount==7)
		{
			$out.="</td>\n<td valign='top'>\n";
			$intCount=0;
		}
		$totalcount++;
	}
	$out.="</td></tr></table>";
	return $out;
}


?>












<?php










 
require("frontendfooter.php");


?>