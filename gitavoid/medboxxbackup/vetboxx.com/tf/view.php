<?php


//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
 $title=sitename . " : Home";
 include("calendar_functions.php");

//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 
///////////THIS FILE IS A MESS BUT IT WORKS SORT OF

$bwlOffice=true;
$action=$_REQUEST[qpre . "action"];
$strTable=$_REQUEST[qpre . "table"];
$strOtherTable=$_REQUEST[qpre . "othertable"];
$searchterm=$_REQUEST[qpre . "searchterm"];
$searchtype=$_REQUEST[qpre . "search_type"];
$viewmode=$_REQUEST[qpre . "viewmode"];
if(!contains($strTable, " " ))
{
	$strPKName=gracefuldecay($_REQUEST[qpre . "idfield"], $strTable . "_id");//hacky!!!
}
else
{
	$strPKName="client_id";
}
$strPKVal=$_REQUEST[$strPKName];
$editevent=$_REQUEST[qpre . "editevent"];
$deleteevent=$_REQUEST[qpre . "deleteevent"];
$bwlSuppressNewButton=false;
$strDatabase=our_db;
$prepiece="";
$sql=conDB();

//die( $_REQUEST[qpre . "submit"]);
if($action=="delete")
{	
	$strSQL="DELETE FROM " . $strDatabase ."." . $strTable . " WHERE " . $strPKName . "='" .$strPKVal  . "'";
	$records = $sql->query($strSQL);
	if($table=="client")
	{
		$noun=strtolower(customertype);
	}
	else
	{
		$noun=strtolower(professionaltype);
	}
 	
	$message="A " . $noun . " was deleted from your " . locationtype . ".";
	header("location: " . $strPHP . "?" . qpre . "table=" . $strTable  );
}
if($deleteevent!="" && $intOurLoginID!="")
{

	$strSQL="DELETE FROM " . $strDatabase .".personal_calendar_event WHERE office_id='" .$intOurOfficeID  . "' AND calendar_event_id='" . $deleteevent. "'";
	$records = $sql->query($strSQL);
	$strSQL="DELETE FROM " . $strDatabase .".phone_call WHERE  office_id='" .$intOurOfficeID  . "' AND calendar_event_id='" . $calendar_event_id. "'";
	$records = $sql->query($strSQL);
 	
	header("location: " . $strPHP . "?" . qpre . "table=" . $strTable . "&" . qpre . "othertable=personal_calendar_event&" . $strPKName . "=" . $strPKVal  );
	 
 
}
else if($_REQUEST[qpre . "submit"]!="")
{
	//echo "$";
	//echo $strPKName . " " . $strPKVal . "<BR>";;
	
	//NEED SOME SECURITY CODE HERE TO ENSURE ONLY USERS/PRACTITIONERS BELONGING TO THIS OFFICE ARE BEING CHANGED
	if($_POST["user_id"]!="")
	{
		if(!ClientBelongsToOffice($_POST["client_id"], $intOurLoginID))
		{
			die("You attempted to alter a " . strtolower(customertype) . " who doesn't belong to your " . strtolower(locationtype) . ".");
		}
	}
	if($strTable=="client")
	{

		$_POST["type"]="client";
		$_POST["is_active"]=1;
	}
	else if($strTable=="practitioner")
	{
		$_POST["office_id"]=$intOurOfficeID;
	
	}
	//die( $strTable . " " . $strPKVal);
	
	$strPKVal=GenericFormSaver($strDatabase,$strTable,$strPKName, $strPKVal, $strFieldIgnoreList,  false, false,  true, false);
	if($strTable=="personal_calendar_event")
	{
	
		$event_id=$strPKVal;
		if($event_id!="")
		{
			
			ScheduleAPhoneCall($event_id, $_REQUEST["no_phone"]);
		}
	
	}
	//die($strTable);
	if($strTable=="client")
	{
	 
		//die( $strPKVal  .  "+" .$intOurLoginID . "@" . $officetoken);
		AssociateClientWithOffice($strPKVal, $officetoken, "", $intOurLoginID);
		 
	}
	if($strTable=="personal_calendar_event")
	{
	header("location: " . $strPHP . "?" . qpre . "table=client&type=client");
	}
	else if($strTable=="client"  || $strTable=="login")
	{
		if($viewmode=="client")
		{
			header("location: reg.php?" . qpre . "profilemode=profile");
		}
		else
		{
			header("location: " . $strPHP . "?" . qpre . "table=client&type=client");
		}
	}
 
	else
	{
	header("location: " . $strPHP . "?" . qpre . "table=" . $strTable . "");
	}
}

 

$strPHP=$_SERVER['PHP_SELF'];
$strHiddenList="";
$postprocessing="";
$labels="";
$bwlCatchTablename=false;
if($strTable=="")
{
	$bwlCatchTablename=true;
}
$arrRestrictions=Array();
$keycount=0;
foreach($_GET as $k=>$v)
{
	if(!beginswith($k, qpre))
	{
		$arrRestrictions[$k]=$v;
		if($bwlCatchTablename  && $keycount==0)
		{
			$arrTableFrack=explode("_", $k);
			array_pop($arrTableFrack);
			$strTable=join("_", $arrTableFrack);
		}
		$keycount++;
	}
}
//echo $strTable;
$searchWhere="";
if($searchterm!="")
{
	if($strTable=="practitioner")
	{
		$searchWhere .= " AND name LIKE '%" . singlequoteescape($searchterm) . "%'";
	}
	else
	{
		if($searchtype=="")
		{
			$searchWhere .= " AND (firstname LIKE '%" . singlequoteescape($searchterm) . "%' OR 
			lastname LIKE '%" . singlequoteescape($searchterm) . "%' OR
			city LIKE '%" . singlequoteescape($searchterm) . "%' OR
			zip LIKE '%" . singlequoteescape($searchterm) . "%' OR
			name_of_guardian LIKE '%" . singlequoteescape($searchterm) . "%') ";
		}
		else
		{
			$searchWhere .= " AND  " . singlequoteescape($searchtype) . " LIKE '%" . singlequoteescape($searchterm) . "%' ";
		}
	}
}
		
if($editevent!="")
{
 		$strWhereClause.=IFAThenB($strWhereClause, "AND") . " office_id='" . $intOurOfficeID . "'";
		$strPKName="calendar_event_id";
		$strTable="personal_calendar_event";
		$strSQL="SELECT *  FROM " . our_db . "." . $strTable . " WHERE " . $strPKName . "='" . $editevent . "'";
		$tabtitle="Edit Appointment";
		$thisid=$editevent;
		$strHiddenList="calendar_event_id recurrence_id sort_id type office_id";
		$labels=Array("datecode"=>"date", "time"=>"time (24 hr format)", "client_id"=>"patient");
		$bwlSuppressNewButton=true;
}
else if($strTable=="client"  )
{

	if($_REQUEST["type"]=="client")
	{
		$strSuppressFields="subdomain office_name password address call_type_id";
	}
	
	
	
	include_once("frontend.php");
	
	$strPKName="client_id";
	$thisid=$_REQUEST[$strPKName];

	if($thisid=="")
	{
		
		
		//SQL ETC TO MAKE A LIST OF AN OFFICE'S PATIENTs
		if($strTable!="client")
		{
			$strWhereClause=ArrayToWhereClause($arrRestrictions);
		}
		$strWhereClause.=IFAThenB($strWhereClause, "AND") . " office_id='" . $intOurOfficeID . "'";
		$strWhereClause.=$searchWhere;
		
		$strTable="client";
		$strSQL="SELECT *  FROM  " . our_db . ".client c   JOIN " . our_db . ".client_office_map m ON m.client_id=c.client_id WHERE " . $strWhereClause . " ORDER BY lastname, firstname";
		//echo $strSQL;
		//$strSQL="SELECT *  FROM " . our_db . ".client c   JOIN " . our_db . ".client_office_map m ON m.client_id=c.client_id WHERE " . $strWhereClause;
		//echo $strSQL;
		$tabtitle=pluralize(customertype) ;
		$strPKName="client_id";
		//SELECT * FROM medboxx_box.user t JOIN medboxx_box.client_office_map m ON t.user_id=m.client_login_id WHERE is_office='0' AND office_login_id='1' 
		//echo $strSQL;
		$postprocessing=Array("login_id"=>"'<a href=view.php?" . qpre . "table=login&login_id=<value/>>login</a>'","client_id"=>"'<a href=view.php?" . qpre . "table=client&client_id=<value/>>info</a> | <a onclick=return(deleteconfirm())  href=view.php?" . qpre . "action=delete&" . qpre . "table=client&client_id=<value/>>delete</a>'");
		if(strtolower(sitename)=="vetboxx.com")
		{
			$postprocessing["client_id"]=RemoveLastCharacterIfMatch($postprocessing["client_id"], "'"); //want to append to a str that gets eval'd, so remove single quote
			$postprocessing["client_id"].=" | <a    href=view.php?" . qpre . "action=viewdependents&" . qpre . "table=client&client_id=<value/>>" . strtolower(pluralize(dependenttype)) . "</a>'";
		}
		$labels=Array("client_id"=>"", "login_id"=>"");
		$strSuppressFields="guardian_client_id name_of_guardian weight description client_type_id";
		$entity=strtolower(customertype) ;
		
	}
	else
	{	
		 
		$entity=strtolower(customertype);
		if($strOtherTable!="")
		{

			//SQL TO DISPLAY A LIST OF APPOINTMENTS FOR A PATIENT
			//echo $strOtherTable;
			$strWhereClause=ArrayToWhereClause($arrRestrictions) ;
			$strSQL="SELECT client_id, calendar_event_id as `id`  , datecode ,   time, name, es.status_name as 'response' FROM " . our_db . "." . $strOtherTable . " e JOIN " . our_db . ".practitioner p ON e.practitioner_id=p.practitioner_id   LEFT JOIN " . our_db . ".event_status es ON e.event_status_id=es.event_status_id WHERE client_id='" . $_REQUEST["client_id"] . "' ORDER BY datecode  DESC";
			$postprocessing=Array("datecode"=>"displaydatecode(<value/>)", "time"=>"cleanuptime('<value/>')");
		
			$labels=Array("datecode"=>"date", "name"=>strtolower(professionaltype));
			//echo $strSQL;
			//echo mysql_error();
			$tabtitle=customertype . " Appointments";
			$strSuppressFields="practitioner_id type notes recurrence_id calendar_event_id client_id id";
			$prepiece=ClientEditLink($_REQUEST["user_id"]);
			$entity="appointment";
			
		 
		}
		else
		{
			if($action=="viewdependents")
			{
				 
			}
			else
			{
				//SQL TO FILL EDIT FORM FOR A PATIENT
				$strWhereClause=ArrayToWhereClause($arrRestrictions) ;
				$strSQL="SELECT *  FROM " . our_db . ".client   WHERE " . $strWhereClause;
				$strTable="client";
			 	
				$tabtitle="Edit " . customertype;
			}

			 
		}
	}
	//echo $strSQL;
	if($viewmode=="client")
	{
		$strHiddenList.="date_created date_lastvisited";
	}
	$strHiddenList.=" name_of_guardian timezone guardian_client_id login_id client_id is_active office_name subdomain client_id is_office patients_per_day staff_number doctor_number call_type_id first_email second_email third_email first_phonecall second_phonecall third_phonecall phonecall_time office_text visitcount holidays hours_open days_open midday_closed scheduling_unit_size office_id weight description";
	if(strtolower(sitename)=="vetboxx.com")
	{
		$strHiddenList.=" birthday social_security_number employed_by";
		if(1==1)
		{
			$strHiddenList.=" client_type_id";
		}
	}
	else
	{
		
	}
	//echo $strSQL;

}
else if($strTable=="login")
{
	$tabtitle="Edit Login Information";
	$thisid=$_REQUEST[$strPKName];
	$strWhereClause=ArrayToWhereClause($arrRestrictions) ;
	$strSQL="SELECT *  FROM " . our_db . ".login   WHERE " . $strWhereClause;
	//FrontEndTableForm($strDatabase, $strSQL, $strTable, $strIDField, $strPKValue, $strPHP,  $strHiddenList, $strDisplayOnlyList, $arrPassedInDefaults, $strConfigBehave, $strUser="", $bwlSuppressNewButton=false, $breadcrumb="", $bwlPlaintextPWD=false, $bwlSuppressSubmitButtons=false, $intWidth=630, $bwlSuppressTableNameOnButton=true, $bwlFriendlyLabels=false)
	$bwlSuppressNewButton=true;
	$strHiddenList="type login_id";
	//echo $strSQL;
}
else if ($strTable=="practitioner" )
{
 
 	$strPKName="practitioner_id";
	$thisid=$_REQUEST[$strPKName];
	$tabtitle=pluralize(professionaltype);
	$entity=strtolower(professionaltype);
	$strSuppressFields=" facility address practitioner_type_id";
	//echo "_";
	if($thisid=="")
	{
 		//SQL FOR A LIST OF PRACTITIONERS

		$strWhereClause=MergeSQLConditionals($searchWhere, " office_id='" . $intOurOfficeID . "'", true) ;
		$strSQL="SELECT *  FROM " . our_db . "." . $strTable . " p JOIN practitioner_type t ON p.practitioner_type_id=t.practitioner_type_id  " . $strWhereClause . " ORDER BY name";
		//echo $strSQL;
		$postprocessing=Array("practitioner_id"=>"'<a href=view.php?" . qpre . "table=practitioner&practitioner_id=<value/>>info</a>  <a onclick=return(deleteconfirm()) href=view.php?" . qpre . "action=delete&" . qpre . "table=practitioner&practitioner_id=<value/>>delete</a>'");
		$labels=Array("practitioner_id"=>"" );
		$strSuppressFields.=" office_id";
		//$strSuppressFields="practitioner_id office_login_id"; 
		 
	}
	else
	{
		
		if($strOtherTable!="")
		{
			//SQL TO DISPLAY APPOINTMENTS FOR A PRACTICIONER
		 
			$strWhereClause=ArrayToWhereClause($arrRestrictions) ;
			$strSQL="SELECT practitioner_id, u.client_id, calendar_event_id as `id` , CONCAT(SUBSTR(datecode, 3, 2), '/' , SUBSTR(datecode, 5, 2) , '/', SUBSTR(datecode, 1, 2)) as `date` ,   time,   firstname , lastname ,phone, email, city, zip FROM " . our_db . "." . $strOtherTable . " e JOIN " . our_db . ".client u ON u.client_id=e.client_id    WHERE practitioner_id='" . $_REQUEST["practitioner_id"] . "' " . $searchWhere . " ORDER BY datecode  DESC";
			//echo $strSQL;
			//echo mysql_error();
			$tabtitle=professionaltype. " Appointments";
			$strSuppressFields="practitioner_id type notes recurrence_id calendar_event_id client_id id ";
			$prepiece=PractitionerEditLink($_REQUEST["practitioner_id"]);

			
		}
		else
		{
			//SQL TO EDIT A PRACTITIONER
			$strWhereClause=ArrayToWhereClause($arrRestrictions)   ;
			$strSQL="SELECT *  FROM " . our_db . "." . $strTable . "    WHERE " . $strWhereClause;
		
		}
	}
	//echo $strSQL;
	include_once("frontend.php");
	
	
	

	$strHiddenList="practitioner_id office_id";
	//echo $strSQL;

}
 

$tablength=CalculateTabLength($tabtitle);
$sql=conDB();
$strPHP=$_SERVER['PHP_SELF'];
include_once("frontend.php");
 
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!

?>
<script language="javascript" src="tf.js" type="text/javascript"><!-- --></script>
<script language="javascript" src="tf_tablesort.js" type="text/javascript"><!-- --></script>
<?
 
if($intOurLoginID=="")
{
 
 
}
else
{

	if($bwlOffice)
	{
		
	?>
 
<script>
function deleteconfirm()
{
	return confirm("Are you sure you want to delete this?");
}

</script>
	<form name="BForm">
	<input type="hidden" name="calendardata" value=""> 
 	<input type="hidden" name="thisdate" value="">
 	</form>

 
	<br/>
	<div id="idblanktablabel" style="background-image:url('images/blankredtabtop_<?=$tablength?>.png');width:595px;height:28px; font-family:helvetica, arial;color:#<?=textcolorontheme?>;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px"><?=$tabtitle?></span></div>
	<div style="background-image:url('images/596_back.png');width:595px; ; background-repeat:repeat-y;">
	<center>
<?
// GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
 
if($thisid=="" && $action!="new" || $strOtherTable=="personal_calendar_event"  || $action=="viewdependents")
{
////GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
	$strAdditionalLink="";
	if($strOtherTable=="")
	{
		
		if($strTable=="practitioner")
		{
			$strAdditionalLink="<a href=\"view.php?" . qpre . "othertable=personal_calendar_event&" . qpre . "table=practitioner&practitioner_id=<practitioner_id>\"> appointments</a>";
		}
		else
		{
			$strAdditionalLink="<a href=\"view.php?" . qpre . "othertable=personal_calendar_event&" . qpre . "table=client&client_id=<client_id>\"> appointments</a>";
		}
	}
	else
	{	
		$strThisID=$strPKName;
 		if($strTable=="client")
		{
			$strThisID="client_id";
		}
		$strAdditionalLink="<a href=\"view.php?" . qpre . "editevent=<id/>\"> edit</a>";
		$strAdditionalLink.=" | <a onclick='return(confirm(\"Are you sure you want to unschedule this appointment?\"))'  href=\"view.php?" . qpre . "deleteevent=<id/>&" . qpre . "table=" . $strTable . "&" . $strTable . "_id=<". $strThisID . "/>\">cancel</a>";
		
	}
	echo $prepiece;
	//echo $strSQL;
	if($strOtherTable=="")
	{
	 	if($strTable=="practitioner")
		{
			$arrSearchHidden= Array( qpre . "searchterm"=>$searchterm, qpre . "search_type"=>$searchtype,qpre . "action"=>$action, qpre ."table"=>$strTable, qpre ."othertable"=>$strOtherTable, qpre ."idfield"=>$strPKName, "practitioner_id"=>$practitioner_id);
 
				
			$searchform= GenericForm(Array(qpre . "searchterm" ),  Array("Search For a " . professionaltype), $arrSearchHidden, Array("searchterm"=>"size:40"), $strPHP,  "Search", "550",  "",  "", "AForm", true);
		}
		else
		{
			$arrSearchHidden= Array( qpre . "searchterm"=>$searchterm, qpre . "search_type"=>$searchtype,qpre . "action"=>$action, qpre ."table"=>$strTable, qpre ."othertable"=>$strOtherTable, qpre ."idfield"=>$strPKName, "practitioner_id"=>$practitioner_id);
			//GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="", $formname="BForm", $bwlAllOneRow=false)
		
			$searchform= GenericForm(Array(qpre . "searchterm", qpre . "search_type"),  Array("Search For a " . customertype, "Search by"), $arrSearchHidden, Array(qpre  . "search_type"=>"dropdown:firstname|First&nbsp;name-lastname|Last&nbsp;name-city|City-zip|Zip Code-email|Email-phone|Home Phone-client_id|Client&nbsp;ID", "searchterm"=>"size:40"), $strPHP,  "Search", "550",  "",  "", "AForm", true);
		}
	}
//HACKY HACK::::
	$searchform=str_replace(">-none-", ">All",$searchform);
	echo $searchform;
 
	$results=GenericRSDisplay(our_db, $strPHP,"", $strSQL, true, 550,  $strPKName,$strPKName, $strAdditionalLink, $strSuppressFields ,  false,  true, 9,  "",  $postprocessing, $labels);
	if($results=="")
	{
		echo "<div class='extralinks'>None were found.</div>";
	}
	echo $results;
}
else  
{ 
 
//FrontEndTableForm($strDatabase, $strSQL, $strTable, $strIDField, $strPKValue, $strPHP,  $strHiddenList, $strDisplayOnlyList, $arrPassedInDefaults, $strConfigBehave, $strUser="", $bwlSuppressNewButton=false, $breadcrumb="", $bwlPlaintextPWD=false, $bwlSuppressSubmitButtons=false, $intWidth=630)
	//echo $prepiece;
	if($strPKName=="")
	{
		$strPKName=$strTable. "_id";
	}
	//echo $viewmode;
	$arrPassedInDefaults[qpre . "viewmode"]=$viewmode;
 	//echo  $strSQL;
	echo FrontEndTableForm(our_db, $strSQL, $strTable,$strPKName, $thisid, $strPHP,  $strHiddenList, $strDisplayOnlyList, $arrPassedInDefaults, $strConfigBehave, $intOurLoginID,  $bwlSuppressNewButton,  "", false, false, 500, true, true, $labels);
	
	if($strTable=="client"   &&  $thisid!="" )
	{
		$thislogin_id=GenericDBLookup(our_db, "client", "client_id", $thisid, "login_id");
		if($thislogin_id=="")
		{
			echo "<br><div class='extralinks'>This " . strtolower(customertype) . " does not have a login.  <a class='extralinks' href=\"view.php?" . qpre . "table=login&client_id=" . $thisid ."\">Add one for this " . strtolower(customertype) . "</a>.</div>";
		}
		else
		{
			echo "<br><div class='extralinks'>This " . strtolower(customertype) . " has a login.  <a class='extralinks' href=\"view.php?" . qpre . "table=login&login_id=" . $thislogin_id ."\">Edit it</a>.</div>";
		}
	}
}
if($strOtherTable==""  && $editevent==""  && $strTable!="login"  && $thisid==""  && $action!="new")
{
?>
	 <div class='extralinks'<a class="nav" href="view.php?office_id=<?=$intOurOfficeID?>&<?=qpre?>action=new&<?=qpre?>table=<?=$strTable?>">add new <?=$entity?></a></div>
	 <?
}
else
{
	echo "<br/>";
}
	?>
	</center>
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	<br/>
	<?
	 
	}
	else
	{
	?>
	<form action="appointments.php"><input class="profilebutton" type="submit" name="submit" value="View your appointment schedule"></form>
	<br/>
	<form action="reg.php"><input type="hidden" name="<?=qpre?>profilemode" value="profile"><input class="profilebutton" type="submit" name="submit" value="Edit your profile"></form>

	<?
}
}

pagebottom();


function PractitionerEditLink($practitioner_id)
{
	$record=GenericDBLookup(our_db, "practitioner", "practitioner_id", $practitioner_id);
	$out="<div class='header'>Appointments for <a href=\"view.php?practitioner_id=" . $practitioner_id. "\">" . $record["name"] . "</a></div>";
	return $out;
}


function ClientEditLink($client_id)
{
	$record=GenericDBLookup(our_db, "client", "client_id", $client_id);
	$out="<div class='header'>Appointments for <a href=\"view.php?client_id=" . $client_id. "\">" . $record["firstname"] . " " . $record["lastname"] . "</a></div>";
	return $out;
}
	
	
?>

 
 
 
