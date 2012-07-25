<? 
$bwltesting=false;
//Judas Gutenberg, dec 5 2007
//intercepts the result of a purchase of a product, and if it's a moodle online course, sets its order status to complete and dumps user onto his moodle page

//////////////////////////////////////////////////////////////////////
//testing block...all should be commented out in production
$bwltesting=true;
//end of testing block
//////////////////////////////////////////////////////////////////////<br>
	
require('header.php');
require('pseudotag_lib.php'); 
require("PearMail.php");
$sql=conDB();
$userid=$USER->id;
$username=$USER->username;
//we have a userid, let's find the latest order and see if it's for an online course
$strSQL="SELECT * FROM " . our_db . ".xcart_orders  o JOIN " . our_db . ".xcart_order_details d ON o.orderid=d.orderid JOIN " . our_db . ".xcart_products p on d.productid=p.productid WHERE login='" . $username . "' ORDER BY o.orderid, p.productid DESC LIMIT 0,1 ";
 
$records = $sql->query($strSQL);
logmysqlerror($strSQL, true);
$record=$records[0];
if($bwltesting)
{
	$mdl_course_id=447;
}
else
{
	$mdl_course_id=$record["mdl_course_id"];
}
$url="/moodle/";  //we're going to moodle home
if($_REQUEST["go"])//we're going to take a course
{
	$mdl_course_id=$_REQUEST["go"];
	$url="/moodle/course/view.php?id=" . $mdl_course_id;
}
if($mdl_course_id!="") //we're going somewhere, but we gotta logout and login first
{
	//we get the orderid
	if($bwltesting)
	{
		$orderid=1;
	}
	else
	{
		$orderid=$record["orderid"];
		
	}
	
	//die($orderid);
	//UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs, $bwlEscape=true, $bwlDebug=false)
	//we change its status to complete
	UpdateOrInsert(our_db, "xcart_orders", Array("orderid"=>$orderid),Array("status"=>"C"));
	AssignStudentToCourse($orderid, $bwltesting);
	//header("location: /moodle/user/view.php?id=" . $userid);
	
	
	header("location: getopost.php?doxcartlogin=1&username=" . $USER->username ."&testcookies=1&actioner=" . urlencode("moodle/login/index.php") . "&tourl=" . urlencode($url) . "&fillerpadding=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx&fillerington=" . $USER->password );
}
//off to moodle!
else
{
	header("location: /");
	
	
}




function AssignStudentToCourse($orderid, $bwltesting=false)
{
	//returns false if this wasn't an online course
	//working entirely off the orderid, folks!
	
	$sql=conDB();
	if(!$bwltesting)
	{
		$strSQL="SELECT u.id, c.id as 'courseid', p.productid FROM " . our_db . ".xcart_orders o JOIN " . our_db . ".mdl_user u ON o.login=convert(u.username, binary) JOIN " . our_db . ".xcart_order_details d ON o.orderid=d.orderid JOIN " . our_db . ".xcart_products p ON d.productid=p.productid JOIN " . our_db . ".mdl_course c ON p.mdl_course_id=c.id WHERE o.orderid=" . $orderid;
		//die($strSQL);
		$records = $sql->query($strSQL);
		//logmysqlerror($strSQL, true);
		$rs=$records[0];
		$userid=$rs["id"];
		$courseid=$rs["courseid"];
		$productid=$rs["productid"];
		$bwlOffline=IsOfflineCourse($productid);
	}
	else
	{
		$userid=$USER->id;
		$courseid=447;
		$productid=313;
		$bwlOffline=false;
	}
	//die("-" . $bwlOffline . "-");
	//die();

 
	$contextid=GetContextID(50, $courseid);
 	//die($contextid);
	if($contextid=="")
	{
		$strSQL="INSERT INTO  " . our_db . ".mdl_context(contextlevel, instanceid, path , depth) values(50, " . $courseid . ",'x',3)";
		
		$sql->query($strSQL);
		logmysqlerror($strSQL, true);
		$contextid=db_insert_id();
		//this is so fucking stupid!!!
		$strForPath="'/1/3/" .  $contextid . "'";
		$strSQL="UPDATE  " . our_db . ".mdl_context SET path=" . $strForPath . " WHERE id='". $contextid . "'";
		$sql->query($strSQL);
		 logmysqlerror($strSQL, true);
	}
	
	$strSQL="INSERT INTO  " . our_db . ".mdl_role_assignments(roleid, contextid, userid, `hidden`, timestart, timeend, timemodified, modifierid, enrol, sortorder) values
	(5, " . $contextid . "," . $userid. ",0,'" . time() . "','" .  time() . "','" .  time() . "',2,'manual',0)";
	
	
	//die($courseid . "  -  " . $strSQL);
	if($courseid!="")
	{
		if(!$bwlOffline)
		{
			 $sql->query($strSQL);
			 logmysqlerror($strSQL, true);
			 SendEnrollmentLetter( $courseid);
		}
		if($bwlOffline)
		{
			$courseid=-$courseid;
		}
		else
		{
			return $courseid;
		}
	}
	return 0;
	
	//also send out any email, dudes!
}


function GetContextID($contextlevel, $courseid)
{
	$sql=conDB();
	$strSQL="SELECT id FROM  " . our_db . ".mdl_context  WHERE instanceid='" . $courseid . "' AND contextlevel='" . $contextlevel . "'";
	$records=$sql->query($strSQL);
	$record=$records[0];
	$id=$record["id"];
	return $id;
}

function IsOfflineCourse($productid)
{
	$sql=conDB();
	$offlineID=445;
	$strSQL="SELECT  categoryid FROM  " . our_db . ".xcart_products_categories  WHERE productid=" . $productid;
	
	//$categoryids = db_query($strSQL);
	$records=$sql->query($strSQL);
	$bwlOffline=false;
	if (is_array($records))
 	{
		foreach($records as $record)
		{
			$categoryid=$record["categoryid"];
			if($categoryid==$offlineID)
			{
				$bwlOffline=true;
			}
		}
	}
	return $bwlOffline;
	
}

function SendEnrollmentLetter($course_id)
{
	Global $USER;
	$sql=conDB();
	$firstname=$USER->firstname;
	$lastname=$USER->lastname;
	$email=$USER->email;
	$strSQL="SELECT '" . $firstname . "' AS firstname,  '" . $lastname . "' AS lastname, '" . $course_id . "' AS courseid";
	//die($strSQL);
	$strTemplateText=sitetext("email enroll course");
	$body=ProcessTemplateWithSQL($strSQL, $strTemplateText);
	//GenericDBLookup($strDB, $strTable, $strIDFieldName, $strThisID, $strResultFieldName, $bwlDebug=false, $bwlWorkUntilFound=true)
	$nameofcourse=GenericDBLookup(our_db, "mdl_course", "id",$course_id, "fullname");
	//die( $email);
	//$email="gus@asecular.com";
	$mcertmail=GenericDBLookup(our_db, "mdl_config", "name", "supportemail", "value");
	//die($email . "  " . $mcertmail);
	//die($course_id . " " . $textofemail);
	//
	$subject="MCERTIFIED: Welcome to " . $nameofcourse;
	//mail($email,$subject ,$textofemail, "From: MCERTIFIED <" . $mcertmail . ">\r\n");
	//emailHtml($mcertmail, $subject, $body, $email);
	
	
	
	
    require_once('htmlMimeMail5.php');
    $mail = new htmlMimeMail5();
    $mail->setFrom('From: MCERTIFIED <' . $mcertmail . '>');
    $mail->setSubject($subject);
    $mail->setPriority('high');
    $mail->setText($body);
    //$mail->setHTML('<b>Sample HTML</b> <img src="background.gif">');
    //$mail->addEmbeddedImage(new fileEmbeddedImage('background.gif'));
    //$mail->addAttachment(new fileAttachment('example.zip'));
    $address = $email;
	//$address="GUs@asecuLar.com";
    $result  = $mail->send(array($address), "smtp");
	
	//die("---" . $result);
	
}

//ProcessTemplateWithSQL($strSQL, $strTemplateText)
//email enroll course
?>
 