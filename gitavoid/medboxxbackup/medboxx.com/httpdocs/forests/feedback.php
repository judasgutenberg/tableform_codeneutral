<?include("functions.php")?> 
<html>
<head>
<title>Feedback</title>
<meta name="description" content="?">
<meta http-equiv="Expires" content="25 November 1794">
<script src="../ran.js"></script>
</head>
<body bgcolor=ffffff text=000000 link=cc0000 vlink=0000cc alink=006600>

<font face=arial color=000000 size=-1>
<p align=right>

 <p align=right>
<strong> Feedback</strong>
 </p>
  <?
  $thanks=$_REQUEST["thanks"];
if(!isset($thanks))
{ 	
$thanks="";
}
if(!isset($subject))
{ 	
$subject="";
}

		 if ($thanks!="thanks")
		{?>
        <div align="left"> 
          <p>Please use this form to send us any feedback you may have.
           </p>
          <form name="FormName" action="feedbackmailer.php" method="post" enctype="x-www-form-urlencoded">
	
            <table border="0" cellpadding="2" cellspacing="2" width="95%">
              <tr> 
                <td width="35%"> 
                  <div align="right" class="normal">Name</div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Name" size="36">
                </td>
              </tr>


              <tr> 
                <td width="35%"> 
                 <div align="right" class="normal">E-mail</div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Email" size="36">
                </td>
              </tr>
              <tr> 
                <td width="35%"> 
                  <div align="right" class="normal">Subject</div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Subject" size="36" value="<?=$subject?>">
                </td>
              </tr>
             
		    
                <td colspan="2"> 
           
                    <textarea name="Body" cols="60" rows="18"></textarea>
              
                </td>
              </tr>
             <tr>
			 <td colspan="2">
			  <input type="submit" name="submitButtonName" value="send...">
			 </td>
			 </tr>
            </table>

            <p align="right">  
             

 
               </p>
          </form>
		        </div>
		<?}
		  else
		  {
		  ?>
		  <center>
		<em> <h1>Thanks!</h1> I will see your message soon. </em>
		   </center>
		  <?
		  }
		  ?>


        </div>
</p>
</font>

</body></html>



 