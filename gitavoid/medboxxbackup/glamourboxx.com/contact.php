<?php


//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
include("header.php");
$title=sitename ." : Home";
 // echo "-" . $intOurLoginID . "-" ;
 
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 //echo phpinfo();

//echo $intOurLoginID . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $intOurLoginID, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
 
 
 
$page_key=$_REQUEST["page_key"];





include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
?>
 
   			<div id="infoheader"> </div>
            <div id="infocontent"> 
			
	
			<div class="info">
 
 	<?
	if($_REQUEST["message"]=="thanks")
	{
	?>
	Thanks for your feedback!
	<?
	}
	else
	{
	
	?>
          <p>We are interested in your feedback!
           </p>
          <form name="FormName" action="feedbackmailer.php" method="post" enctype="x-www-form-urlencoded">
	
            <table border="0" cellpadding="2" cellspacing="2" width="550">
              <tr> 
                <td width="35%"> 
                  <div align="right" style="font-size:9">Name</div>

                </td>
                <td width="65%"> 
                  <input type="text" name="Name" size="56" value="">
                </td>
              </tr>


              <tr> 
                <td width="35%"> 
                 <div align="right"" style="font-size:9">Email</div>
                </td>

				
				 <input type="hidden" name="prefix" size="56" value="6740828">
                <td width="65%"> 
                  <input type="text" name="Email" size="56" value="">
                </td>
              </tr>
              <tr> 
                <td width="35%"> 
                  <div align="right"" style="font-size:9">Subject</div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Subject" size="56" value="">

                </td>
              </tr>
             
		    
                <td colspan="2"> 
           
                    <textarea name="Body" cols="90" rows="18"></textarea>
              
                </td>
              </tr>
             <tr>
			 <td colspan="2">
			  <input type="submit" name="submitButtonName" value="Send">

			  <p>
 
			 </td>
			 </tr>
            </table>

            <p align="right">  
             

 
               </p>
          </form>
		     

	
	<?
	}
	?>		</div>
 	</div>
	
            <div id="infofooter"> </div>  
			
 
	
	
	
	
	 <br/><br/>

 

 
 
<?pagebottom();  ?>
 
 
 
