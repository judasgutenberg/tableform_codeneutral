<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
  
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 //echo phpinfo();
$ouruserid=gracefuldecay($ouruserid,$_POST["user_id"], GetFrontEndUserID());
//echo $ouruserid . "_______" ;
 
 
$strPHP=$_SERVER['PHP_SELF'];
$intStartRecord=$_REQUEST["r"];
$recsperpage=14;
$profilemode=$_REQUEST[qpre . "profilemode"];
 
$strTable="user";
$strPK="user_id";
if($profilemode!="profile")
{
	$ouruserid="";
}

if($_POST[qpre . "save"]!="")
{
	//echo "EEE";
//GenericFormSaver($strDatabase, $strTable, $strPrimaryKey, $strPKVal, $strFieldIgnoreList, $bwlDebug=false, $bwlWorkFromSchema=false, $bwlDontOverwriteWithNulls=true, $bwlCreateSchema=false)
	$ouruserid=GenericFormSaver(our_db, $strTable, $strPK, $ouruserid, "", false, false, true, true);
	if($officetoken!=""  && $mode!="office")
	{
		//echo "EEE";
		AssociateUserWithOffice($ouruserid, $officetoken);
	}
	header("location: .");
	 
};

//echo $ouruserid;
include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
$imagetopurl="reg_pinktop.png";
if($mode!="office")
{
	$imagetopurl="reg_pinktop_patient.png";
}
else if($profilemode=="profile")
{
	$imagetopurl="reg_pinktop_office_edit.png";
}

?>
 
    <div style="background-image:url('images/<?=$imagetopurl?>');width: 568px;height:41px"></div>
     <div style="background-image:url('images/pinkybg.png');width: 568px;background-repeat:repeat-y;"></div>
            <div id="pinkinfocontent">  
			<div class="pinkboxinfo"> 
			<!--reg form-->
			<?
	 		
			$strPHP="reg.php";
		
			
			
			$arrDefaults=GenericDBLookup(our_db, $strTable, $strPK, $ouruserid, "");
			//foreach($arrDefaults as $k=>$v)
			//{
				//echo $k . " " . $v . "<BR>";
			//}	
			$arrDefaults[qpre . "mode"]=$mode;
			$arrDefaults[qpre . "savemode"]="";
			$arrDefaults[ "user_id"]=$ouruserid;
			//table_name|table_pk|table_labelfield|localfieldname|whereclause
			$statefieldcomplex="state|code|state_name|state_code|";
			$arrFieldConfig=Array("office_name"=>"size:55", "subdomain"=>"size:55", "password"=>"size:25", qpre . "password"=>"size:25", "address"=>"size:55", "city"=>"size:55",  "zip"=>"size:55", "phone"=>"size:33","email"=>"size:55", "contact_info"=>"size:55", "doctor_number"=>"size:3", "staff_number"=>"size:4", "patients_per_day"=>"size:3" );
			$strRequiredConfig ="";
			if( $mode=="office")
			{
				//$arrSizes=Array("55", "55", "55", "55","55","55","13",  "55","55","55" ,"55", "3", "3", "3", 12,12);
				$arrFieldNames=Array("office_name", "subdomain", "password", qpre . "password", "address", "city", $statefieldcomplex, "zip", "phone","email", "contact_info", "doctor_number", "staff_number", "patients_per_day" );
				$arrLabels=Array("Office Name", "Your MedBoxx subdomain name", "Password", "Password (again)", "Office Address", "City","State","Zipcode",  "Phone","Email" ,"Office Manager direct contact info", "Number of Doctors", "Number of Staff", "Approximate patients seen per day");
				$arrConfig=Array();
				//echo $ouruserid;
				 $arrDefaults[qpre . "profilemode"]=$profilemode;
				 $arrDefaults["is_office"]=1;
			
			//function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrSizes, $arrHiddenMask, $strPHP, $strButtonLabel="Save", $width=630)
			}
			else
			{
				//$arrSizes=Array("55", "55", "55", "55","55","55","55",  "55","55","55" ,"55", "3", "3", "3", 12,12);
				$arrFieldConfig=array_merge($arrFieldConfig, Array("firstname"=>"size:55", "lastname"=>"size:55"));
				$arrFieldNames=Array(
				"firstname",
				"lastname",  
				"address", 
				"city", 
				$statefieldcomplex, 
				"zip", 
				"phone",
				"email", 
				"password", 
				qpre . "password" 
				);
				$arrLabels=Array(
				"First Name", 
				"Last Name",  
				"Address", 
				"City",
				"State", 
				"Zipcode",  
				"Phone",
				"Email" ,
				"Password", 
				"Password (again)",
				);
				$arrConfig=Array();
				$arrDefaults["is_office"]=0;
				$strRequiredConfig.="firstname|You must enter your first name.|0|~lastname|You must enter your last name.|0|~";
			
			}
			if($profilemode!="profile")
			{
				$arrDefaults["date_created"]=date("Y-m-d H:i:s");
				$arrDefaults["date_lastvisited"]=date("Y-m-d H:i:s");
				$arrDefaults["visitcount"]=1;
			}
			//echo "-".$ouruserid;
			//return(regcheckform())
			//GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="")
			////to use the following include, populate $strRequiredConfig with a string in this format:
			//requiredfield|errormessage|isdate(1 or 0)|additionaltest(such as indexOf('@')>0)~next record....
			$strRequiredConfig.="zip|You must enter a valid zipcode|0|length>3~email|You must enter a valid email|0|indexOf('@')>0~password|You must enter a password of at least four characters.|0|length>3";
			include "regcheckjs.php";
			echo GenericForm($arrFieldNames,  $arrLabels, $arrDefaults,   $arrFieldConfig, $strPHP, "Register", 550,$arrSizes, " onSubmit='return(regcheckform())'","genericbutton");
			
 	
			?>
			
		 </div>
		  </div>
            <div style="background-image:url('images/pinkybot.png');width: 568px;height:3px"> </div>
			
		
<br/>
	
	
	
	 <br/><br/>
	

 
 
<?pagebottom();  ?>
 
 
 
