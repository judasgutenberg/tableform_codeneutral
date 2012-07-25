<div class="wrapper">
 <div style="width:100%; height:74px;margin:0px;
  background-image:url(images/redband.png);background-repeat:repeat-x;">

<div style="width:1000px;
margin:0px auto; height:74px "><a href=.><img src="images/logo_high.png" border=0></a>
  <div class="loginpiece">
  <?
  
  //echo "-" . $intOurLoginID . "-" ;
 //loginpiece($dest="",  $login_id="", $error="", $type="large",  $mode="client", $displaymode="horizontal", $intOfficeID="")
  ?>
	<?=loginpiece("",  $intOurLoginID, $error, "small",  $mode, "horizontal", $intOurOfficeID)?>
  
</div>

</div>
</div> 
<div style="width:1000px;
margin:0px auto;  ">
<img src="images/logo_low.png" style="margin-left:0px"> 
</div>


 
 
<?//tabnav()?>