<?php
include("header.php");
$title=sitename . " : Home";
$bwlAcceptPayments=false;
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 
  
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 //echo phpinfo();
$intOurLoginID=gracefuldecay($intOurLoginID,$_POST["login_id"], GetFrontEndLoginID());
//echo $intOurLoginID . "_______" ;
if($_REQUEST[qpre . "mode"]=="client"  && $intOurOfficeID!="")
{
	header("location: view.php?office_id=" . $intOurOfficeID . "&x_action=new&x_table=client");
}
 
$strPHP=$_SERVER['PHP_SELF'];
$intStartRecord=$_REQUEST["r"];
$recsperpage=14;
$profilemode=$_REQUEST[qpre . "profilemode"];
$buttonname="Register";
$strTable="login office";
$strPK="login_id";
$errors="";

$bwlNewOffice=false;

if($profilemode!="profile")
{
	$intOurLoginID="";
}
else
{
	$buttonname="Save";
}
 
if($_POST[qpre . "save"]!="")
{
	//echo "EEE";
//GenericFormSaver($strDatabase, $strTable, $strPrimaryKey, $strPKVal, $strFieldIgnoreList, $bwlDebug=false, $bwlWorkFromSchema=false, $bwlDontOverwriteWithNulls=true, $bwlCreateSchema=false)
	//DO SOME IMPORTANT DB LOOKUPS:
	$subdomain=strtolower($_POST["subdomain"]);
	$strLimitspec="48-57 a-z A-Z _ . -";
	$subdomain=FilterString($subdomain, $strLimitspec, "-");
	$subdomain=deMultiple($subdomain, "-");
	$subdomain=deMultiple($subdomain, ".");
	$subdomain=trim(RemoveEndCharactersIfMatch($subdomain, "."));
	if($subdomain!="")
	{
		if(contains($subdomain, "."))
		{
			$arrSub=explode(".", $subdomain);
			$subdomain=$arrSub[0];
			if($subdomain=="")
			{
				$subdomain=$arrSub[1];
			}
		}
	}
	if($_POST["username"]=="")
	{
		$_POST["username"]=$subdomain;
	}
	if( $intOurLoginID=="")
	{
		//this part would only execute in the creation of an office because only then would we have a subdomain being passed in
		if( $subdomain!="")
		{
			
			//a place to catch them on the paypalio
			$exists=GenericDBLookup(our_db, $strTable, "subdomain", $subdomain, "subdomain");
			if($exists!=""  || $subdomain=="www")
			{
				$errors.="The subdomain " . $subdomain . " is already in use. Please choose another.<p/>";
			}
			else
			{	
				$_REQUEST["subdomain"]=$subdomain;
				$_POST["subdomain"]=$subdomain;
				$bwlNewOffice=true;
			}
		}
		//$exists=GenericDBLookup(our_db, "login", "subdomain", $subdomain, "user_id");
		//echo $strTable;
		$email_exists=GenericDBLookup(our_db, "login", "email", $_REQUEST["email"], "user_id");
		if($email_exists!="")
		{
			//DONT REALLY NEED TO WORRY ABOUT THIS SCENARIO NOW THAT WE'VE MOVED TO USERNAMES
			$errors.="The email " . $_REQUEST["email"] . " is already being used for an account. Please choose another.<p/>";
			$bwlNewOffice=false;
		}
		 
	}
	if($errors=="")
	{
		if(!$bwlNewOffice )
		{
			//if we're not an office, then we're always active
			$_POST["is_active"]=1;
			$_REQUEST["is_active"]=1;
		}
		//echo $intOurLoginID;
		//GenericFormSaver($strDatabase, $strTable, $strPrimaryKey, $strPKVal, $strFieldIgnoreList, $bwlDebug=false, $bwlWorkFromSchema=false, $bwlDontOverwriteWithNulls=true
		//$mode allows this to handle either offices or client creations or edits
		//echo "#$";
 		//echo $intOurLoginID . "=loginid " . $mode . "=mode " . $intOurModeID . "=ourmodeid " . $strPK . "=strpk " . $intOurOfficeID . "=ourofficeid<BR>";
		$intPossibleModeID=GenericFormSaver(our_db, "login " . $mode, $strPK, $intOurLoginID, "", "log", false, false, true, "subdomain");
		$intOurModeID=gracefuldecay($intOurOfficeID,$intOurClientID,$intPossibleModeID);
		if(!is_numeric($intOurModeID)  && $intOurModeID!="")
		{
			header("location: index.php?" . qpre . "message=" . urlencode(gracefuldecay($errors, "The registration failed; please try again!.")));
			die();
		}
		//echo mysql_error();
		//echo $intOurModeID . "=ourmodeid<BR>";
		//got to regenerate the user info so we have it for the editor form
		$userdetails=GenericDBLookup(our_db,$mode, $mode . "_id", $intOurModeID);
		$intOurLoginID=$userdetails["login_id"];
		$ouruserrecord=GenericDBLookup(our_db,"login", "login_id",$intOurLoginID);
		//echo $intOurLoginID . " " . $mode;
		
		
		$ouruserrecord=array_merge($ouruserrecord,$userdetails);
		$intOurOfficeID=$ouruserrecord["office_id"];
		$intOurClientID=$ouruserrecord["client_id"];
		if($officetoken!=""  && $mode!="office")
		{
			//die( $intOurClientID . " " . $officetoken);
			AssociateClientWithOffice($intOurClientID, $officetoken);
		}
		SetFrontEndCookie($intOurLoginID);
		if($bwlNewOffice )
		{
			$productname="Recurring " . strtolower(locationtype) . " reminder plan through " . sitename;
			$cost=1;
			$store= "payments@standardsourcemedia.com";
			//$store="gaprimack@yahoo.com";
			if($bwlAcceptPayments)
			{
				$transaction_id=$intOurLoginID; //since the product is always the same, just pass the userid back
				ChangeActiveState($intOurLoginID, 0);//set inactive until paid up!
				echo PayPal($cost, $productname,$transaction_id, $store );
				
				die();
			}
			else
			{	
				
				ChangeActiveState($intOurLoginID, 1);//set inactive until paid up!
				header("location: index.php?" . qpre . "message=" . urlencode("Thank you for signing up your " . locationtype . " (membership is free for now)!"));
			}
		}
		
		else if($mode!="office")
		{
			header("location: index.php?" . qpre . "message=" . urlencode("Thank you for registering!"));
		}
		else
		{
			header("location: index.php?" . qpre . "message=" . urlencode(""));
		}
	}
	 
};
//hmmm??
//$mode="";
//echo $intOurLoginID;
include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
$imagetopurl="reg_pinktop.png";
if($mode!="office")
{
	$imagetopurl="reg_righttabblank_120.png";
	$tabtext=strtoupper(customertype) . " INFORMATION";
}
else if($profilemode=="profile")
{
	$imagetopurl="reg_righttabblank_120.png";
	$tabtext=strtoupper(locationtype) . " INFORMATION";
}

if($errors!="")
{
	echo "<div class='errors'>" . $errors . "</div>";
}

?>
 	
    <div class='righttab' style="background-image:url('images/<?=$imagetopurl?>');width: 568px;height:36px"><?=$tabtext?></div>
     <div style="background-image:url('images/pinkybg.png');width: 568px;background-repeat:repeat-y;"></div>
            <div id="pinkinfocontent">  
			<div class="pinkboxinfo"> 
			<!--reg form-->
			<?
	 		
			$strPHP="reg.php";
		
			
			//old way:
			//$arrDefaults=GenericDBLookup(our_db, $strTable, $strPK, $intOurLoginID, "");
			$strTable="office";
			//$sql=conDB();
			//$strSQL="SELECT * FROM " . our_db . "." . $strTable . " t JOIN login l on t.login_id=l.login_id WHERE t.login_id='" . intval($intOurLoginID). "'";
			//echo $strSQL;
			//$records = $sql->query($strSQL);

			$arrDefaults=$ouruserrecord;//$records[0];
			//echo  $arrDefaults["call_type_id"];
			//foreach($arrDefaults as $k=>$v)
			//{
				//echo $k . " " . $v . "<BR>";
			//}	
			$arrDefaults[qpre . "mode"]=$mode;
			$arrDefaults[qpre . "savemode"]="";
			$arrDefaults[ "login_id"]=$intOurLoginID;
			//table_name|table_pk|table_labelfield|localfieldname|whereclause
			$statefieldcomplex="state|code|state_name|state_code|";
			$timezonecomplex="timezone|timezone_id|timezone_name|timezone_id|";
			$bstatefieldcomplex="state|code|state_name|business_state_code|";
			$maritalcomplex="marital_status|marital_status_id|mstatus_name|marital_status_id|";
			$arrFieldConfig=Array("office_name"=>"size:55", "subdomain"=>"size:55 info:'Your website address will be <em>your_choice</em>." . strtolower(sitename) . ".  Do not use spaces or punctuation in your subdomain.'", "password"=>"size:25", qpre . "password"=>"size:25", "address"=>"size:55", "city"=>"size:55",  "zip"=>"size:55", "phone"=>"size:33",
		"email"=>"size:55", 
		"office_graphic"=>"type:file_keytorecord",
		"contact_info"=>"size:55", "doctor_number"=>"size:3", "staff_number"=>"size:3", "patients_per_day"=>"size:3", "scheduling_unit_size"=>"action:startover class:!bgclassclear dropdown:5|5 minutes-10|10 minutes-15|15&nbsp;minutes-20|20 minutes-30|30 minutes-60|1 hour-120|2 hours", "days_open"=>"dropdown:1*5|weekdays-0*6|all days", 
		"hours_open"=>"dropdown:9*18|nine am to six pm-9*17|nine am to five pm-9*16|nine am to four pm-10*17|ten am to fiv pme-10*16|ten am to four pm-9*21|nine am to nine pm-8*21|eight am to nine pm-8*22|eight am to ten pm-0*23|24 hours",
		"holidays"=>"dropdown:12/25 01/01 thanksgiving|important holidays","midday_closed"=>"dropdown:12*13|noon to one-12:13.5|noon to 1:30", 
		"contact_info"=>"size:3050" ,
		"office_text"=>"size:3060" , 
		"first_phonecall"=>"class:!bgclassclear action:startover", "second_phonecall"=>"class:!bgclasscleardarker", "third_phonecall"=>"class:!bgclasscleardarkest",  "first_email"=>"class:!bgclassclear action:startover", "second_email"=>"class:!bgclasscleardarker", "third_email"=>"class:!bgclasscleardarkest", "phonecall_time"=>"action:startover");
			$strRequiredConfig ="";
			if( $mode=="office")
			{
				if($intOurLoginID=="")
				{
				//setup some useful default values
					$arrDefaults["first_email"]="18";
					$arrDefaults["second_email"]="9";
					$arrDefaults["third_email"]="";
					$arrDefaults["first_phonecall"]="1";
					$arrDefaults["second_phonecall"]="";
					$arrDefaults["third_phonecall"]="";
					//$arrDefaults["phonecall_time"]="10";//was ten
					$arrDefaults["phonecall_time"]="19";
					$arrDefaults["scheduling_unit_size"]="15";
					$arrDefaults["days_open"]="1*5";
					$arrDefaults["hours_open"]="9*17";
					$arrDefaults["midday_closed"]="12*13";
					$arrDefaults["holidays"]="12/25 01/01 thanksgiving";
					//$arrDefaults["call_type"]="1";
				}
				//FOR OFFICES::::
				//$arrSizes=Array("55", "55", "55", "55","55","55","13",  "55","55","55" ,"55", "3", "3", "3", 12,12);
				$arrFieldNames=Array("office_name", "subdomain", "password", qpre . "password", "address", "city", 
				$statefieldcomplex, 
						"zip", 
						"phone",
						$timezonecomplex,
						"email", 	
						"office_graphic",
						"contact_info", 
						"doctor_number", 
						"staff_number", 
						"patients_per_day", 
						"scheduling_unit_size", 
						//"days_open", 
						"hours_open",
						//"holidays", 
						//"midday_closed", 
						//"call_type|call_type_id|description|call_type_id",
						"first_email|1|30",
						"second_email|1|30",
						"third_email|1|30",
						"first_phonecall|1|30",
						//"second_phonecall|1|30",
						//"third_phonecall|1|30",
						//"phonecall_time|8|19|if(<value/>>12){return strval(<value/>-12). \":00pm\" ;}else{return strval(<value/>). \":00am\";}",
						"office_text"
						 );
				$arrLabels=Array(
						locationtype . " Name", 
						"Your " . sitename . " subdomain name", 
						"Password", "Password (again)", 
						locationtype. 
						" Address", 
						"City",
						"State",
						"Zipcode",  
						"Phone",
						"Timezone", 
						"Email" ,
						"Office Image" ,
						"Office Manager direct contact info", 
						"Number of " . pluralize(eliteprofessionaltype) , 
						"Number of Staff", 
						"Approximate " . pluralize(strtolower(customertype)) . " seen per day", 
						"Scheduling time unit", 
						//"Days open", 
						"Hours open", 
						//"Holidays", 
						//"Midday hours closed",  
						"Email Reminders (days before appointments)", 
						"2nd Emails",
						"3rd Emails",
						"Phone Reminders (days before appointments)", 
						//"2nd Phonecalls", 
						//"3rd Phonecalls", 
						//"Reminder Phonecall Time", 
						locationtype . " Info"
						);
				$arrConfig=Array();
				//echo $intOurLoginID;
			 	$arrDefaults[qpre . "profilemode"]=$profilemode;
				$arrDefaults["is_office"]=1;
				$strRequiredConfig.="~email|You must enter an email address.|0|~timezone_id|You must select a timezone.|0|~subdomain|You must enter a subdomain.|0|~address|You must enter an address.|0|~city|You must enter a city.|0|";
			//function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrSizes, $arrHiddenMask, $strPHP, $strButtonLabel="Save", $width=630)
			}
			else
			{
				//FOR PATIENTS::::
				//$arrSizes=Array("55", "55", "55", "55","55","55","55",  "55","55","55" ,"55", "3", "3", "3", 12,12);
				$arrFieldConfig=array_merge($arrFieldConfig, Array(
				"firstname"=>"size:55", 
				"lastname"=>"size:55", 
				"birthday"=>"type:date", 
				"why_visiting"=>"size:3050",
				"business_address"=>"size:50",
				"address"=>"size:50",
				"call_type_id"=>"hidden"
				));
				$arrFieldNames=Array(
				"firstname",
				"lastname",  
				"name_of_guardian",
				$maritalcomplex,
				"birthday",
				"address", 
				"city", 
				$statefieldcomplex, 
				"zip", 
				//$timezonecomplex,
				"phone",
				"social_security_number",
				"employed_by",
				"business_phone",
				"business_address",
				$bstatefieldcomplex,
				"business_zip",
				"email", 
				"referred_by",
				"emergency_contact_name",
				"emergency_contact_phone",
				"emergency_contact_cellphone",
				"insurance_type|insurance_type_id|itype_name|insurance1_type_id|",
				"insurance1",
				"insurance1_number",
				"insurance_type|insurance_type_id|itype_name|insurance2_type_id|",
				"insurance2",
				"insurance2_number",
				"password", 
				qpre . "password",
				"why_visiting" 
				);
				$arrLabels=Array(
				"First Name", 
				"Last Name",  
				"Name of Guardian (if a minor)",
				"Marital Status",
				"Birthday",
				"Address", 
				"City",
				"State", 
				"Zipcode",  
				//"Time Zone",
				"Home Phone",
				"Social Security Number",
				"Employed By",
				"Business Phone",
				"Business Address",
				"Business State",
				"Business Zipcode",
				"Email" ,
				"Referred By",
				"Emergency Contact Name",
				"Emergency Contact Phone",
				"Emergency Contact Cell",
				"First Insurance Type",
				"First Insurance Name",
				"First Insurance Number",
				"Second Insurance Type",
				"Second Insurance Name",
				"Second Insurance Number",
				"Password", 
				"Password (again)",
				"Why Are You Visiting?"
				
				);
				$arrConfig=Array();
				$arrDefaults["is_office"]=0;
				$strRequiredConfig.="~firstname|You must enter your first name.|0|~lastname|You must enter your last name.|0|";
			
			}
			if($profilemode!="profile")
			{
				$arrDefaults["date_created"]=date("Y-m-d H:i:s");
				$arrDefaults["date_lastvisited"]=date("Y-m-d H:i:s");
				$arrDefaults["visitcount"]=1;
				$arrDefaults["type"]=$mode;
			}
			//echo "-".$intOurLoginID;
			//return(regcheckform())
			//GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="")
			////to use the following include, populate $strRequiredConfig with a string in this format:
			//requiredfield|errormessage|isdate(1 or 0)|additionaltest(such as indexOf('@')>0)~next record....
			//$strRequiredConfig.="~email|You must enter a valid email|0|indexOf('@')>0~password|You must enter a password of at least four characters.|0|length>3";
			include "regcheckjs.php";
			
			//GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="", $formname="BForm" )

			echo GenericForm($arrFieldNames,  $arrLabels, $arrDefaults,   $arrFieldConfig, $strPHP, $buttonname, 550,$arrSizes, " onSubmit='return(regcheckform())'");
			//echo "$$$" . $strRequiredConfig;
 	
	
			if($mode=="client"  &&  $arrDefaults["login_id"]!="")
			{
				$strSuppressFields="login_id guardian_client_id name_of_guardian";
				$postprocessing=Array("client_id"=>"'<a href=view.php?" . qpre . "viewmode=client&" . qpre . "table=client&client_id=<value/>>info</a>'");
				$strSQL="SELECT * FROM " . our_db . ".client WHERE guardian_client_id ='" .$arrDefaults["client_id"] . "'";
				$results=GenericRSDisplay(our_db, "","", $strSQL, true, 550,  "client_id",$strPKName, $strAdditionalLink, $strSuppressFields ,  false,  true, 9,  "",  $postprocessing, Array("client_id"=>""));
				//if($results!="")
				 
				?>
				<div class="header">
				
				Family members whose information you can change:
				</div>
				<?
				echo $results;
				 
		
	
	
			?>
			<a href="view.php?<?=qpre?>viewmode=client&<?=qpre?>table=client&<?=qpre?>action=new&guardian_client_id=<?=$arrDefaults["client_id"]?>">Add family members...</a>

	<?
	}
	?>
		 </div>
		  </div>
            <div style="background-image:url('images/pinkybot.png');width: 568px;height:3px"> </div>
			
		
<br/>
	
	
	
	 <br/><br/>
	

 
 
<?
 

pagebottom();  ?>
 
 
 
