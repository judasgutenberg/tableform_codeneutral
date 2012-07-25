
<?include("functions.php")?> 
 <?echo casheader("home");?>


 
	 	
        <div align="left" class="pageheader">

 Volunteer Application
     </div>
		 <? if ($thanks!="thanks")
		{?>
        <div align="left"> 
       


Thank you for your interest in volunteering at Catskill Animal Sanctuary, a haven for abused 
horses and farm animals.  Your help is truly invaluable, and we hope you will find CAS a warm 
and welcoming place for humans as well as animals! We ask that you complete this application thoroughly; we will contact you prior to our next volunteer orientation. 
           </p>
          <form name="FormName" action="volunteermailer.php" method="post" enctype="x-www-form-urlencoded">
	
            <table border="0" cellpadding="6" cellspacing="0" width="95%">
              <tr   > 
                <td width="35%"> 
                  <div align="right" class="normal"><strong>Name</strong></div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Name" size="46">
                </td>
              </tr>
              <tr bgcolor=cccc99> 
                <td width="35%"> 
                 <div align="right" class="normal"><strong>Address</strong></div>
                </td>
                <td width="65%"> 
                  <textarea type="Address" name="WhyVolunteer" cols="36" rows=2></textarea>
                </td>
              </tr>
              <tr  > 
                <td colspan=2> 
                 <div  class="normal"><strong>Contact Numbers</strong></div>
                </td>
              </tr>
              <tr> 
                <td colspan=2 align=right> 
      			Day:<input type="text" name="PhoneDay" size="14"> Evening:<input type="text" name="PhoneEvening" size="14"> Cell:<input type="text" name="PhoneCell" size="14">
                </td>
              </tr>
              <tr  bgcolor=cccc99> 
                <td width="35%"> 
                 <div align="right" class="normal"><strong>E-mail</strong></div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Email" size="36">
                </td>
              </tr>
              <tr> 
                <td width="35%"> 
                 <div align="right" class="normal"><strong>Date of Birth (if under 18)</strong></div>
                </td>
                <td width="65%"> 
                  <input type="text" name="Birth" size="19">
                </td>
              </tr>
	             <tr  bgcolor=cccc99> 
                <td width="35%"> 
                 <div align="right" class="normal"><strong>Emergency Contact Phone</strong></div>
                </td>
                <td width="65%"> 
                  <input type="text" name="EmergencyPhone" size="14">
                </td>
              </tr>
              </tr>
	             <tr> 
                <td width="35%"> 
                 <div align="right" class="normal"><strong>Days Available</strong></div>
                </td>
                <td width="65%"> 
                 <input type="checkbox" name="Weekday" size="12" value="Monday">Monday
				  <input type="checkbox" name="Weekday" size="12" value="Tuesday">Tuesday
				  <input type="checkbox" name="Weekday" size="12" value="Wednesday">Wednesday
				  <input type="checkbox" name="Weekday" size="12" value="Thursday">Thursday
				  <input type="checkbox" name="Weekday" size="12" value="Friday">Friday 
				  <input type="checkbox" name="Weekday" size="12" value="Saturday">Saturday
				  <input type="checkbox" name="Weekday" size="12" value="Sunday">Sunday
                </td>
              </tr>
			  <tr bgcolor=cccc99>
                <td width="35%" valign=top> 
                 <div align="right" class="normal"><strong>In these shifts:</strong></div>
                </td>
                <td width="65%"> 
                 <input type="checkbox" name="WorkShift" size="12" value="Morning">Morning (8-noon)
				   <input type="checkbox" name="WorkShift" size="12" value="Afternoon">Afternoon
				  <input type="checkbox" name="WorkShift" size="12" value="AllDay">All Day<br>
				  Other (explain)<input type="text" name="WorkShift" size="19" value="">
				  <p>
				  			<font size=-1>   (Note: In order for us to maintain important animal and administrative routines, we strongly prefer that animal care and administrative volunteers commit to a regular half-day shift on the same day of each week. Exceptions will be made as our needs allow.  Thanks for your understanding.) </fpnt>
              </tr>
             	             <tr  > 
                <td width="35%" valign=top> 
                 <div align="right" class="normal"><strong>I would like to offer the following kinds of assistance:</strong></div>
                </td>
                <td width="65%"> 
<input type="checkbox" name="HelpType" size="12" value="FarmMaintenance">Farm Maintenance (fence repair, grass cutting, etc.)<br>
<input type="checkbox" name="HelpType" size="12" value="GrantWriting">Grant Writing<br>
<input type="checkbox" name="HelpType" size="12" value="AnimalCare">Animal Care (feeding, cleaning stalls, watering, grooming, etc.) <br>
<input type="checkbox" name="HelpType" size="12" value="EventPlanning">Events Planning	<br>
<input type="checkbox" name="HelpType" size="12" value="AdminAssist">Administrative Assistance<br>
<input type="checkbox" name="HelpType" size="12" value="Construction">Construction <br>
<input type="checkbox" name="HelpType" size="12" value="WebsiteMangling">Website Management<br>
<input type="checkbox" name="HelpType" size="12" value="TourGuide">Tour guide (Saturdays only)
                </td>
              </tr>
               <tr  bgcolor=cccc99> 
                <td colspan=2> 
                 <div  class="normal"><strong>Why do you want to volunteer at Catskill Animal Sanctuary? </strong></div>
                </td>
              </tr>
              <tr   bgcolor=cccc99> 
                <td colspan=2 align=right> 
      			<textarea type="text" name="WhyVolunteer" cols="53" rows=2></textarea>
                </td>
              </tr>
                <tr> 
                <td colspan=2> 
                 <div  class="normal"><strong>What experiences qualify you to assist in the areas you’ve selected?</strong></div>
                </td>
              </tr>
              <tr> 
                <td colspan=2 align=right> 
      			<textarea type="text" name="Experiences" cols="53" rows=2></textarea>
                </td>
              </tr>
                 <tr  bgcolor=cccc99> 
                <td colspan=2> 
                 <div  class="normal"><strong>Do you have any health concerns of which we should be aware?</strong></div>
                </td>
              </tr>
              <tr   bgcolor=cccc99> 
                <td colspan=2 align=right> 
      			<textarea type="text" name="HealthConcerns" cols="53" rows=2></textarea>
                </td>
              </tr>
			   <tr> 
                <td colspan=2> 
                 <div  class="normal"><strong>
Is there anything else you’d like us to know?</strong></div>
                </td>
              </tr>
              <tr> 
                <td colspan=2 align=right> 
      			<textarea type="text" name="AnythingElse" cols="53" rows=2></textarea>
                </td>
              </tr>

 
            </table>

            <p align="right">  
              <input type="submit" name="submitButtonName" value="Volunteer!">

 
               </p>

          </form>
		        </div>
		<?}
		  else
		  {
		  ?>
		  <center>
		  <?echo  randompicture("sanctuarymuch", 400, 0)?>
		   </center>
		   <p>
		   On behalf of the animals, thanks for your interest, and we look forward to working with you. 
		  <?
		  }
		  ?>


        </div>


 

<? echo casfooter()?>
 