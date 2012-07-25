 </table>
  <?php
  echo NavBar(2);
  
   ?>

 </div>
 

 
 

 

<script>

nav2div=document.getElementById('nav2');
contentdivdiv=document.getElementById('contentdiv');
// alert(contentdivdiv.offsetHeight);

<?php
$extraheight=0;
if(contains($strLocation, "partners")) //for some reason a page full of graphics fails the bottom nav positioning code
{
	$extraheight=180;
}
if(contains(strtolower($_SERVER['HTTP_USER_AGENT']), "safari")) //safari  handles this badly!
{



?>

nav2div.style.top=contentdivdiv.offsetHeight<?php echo "+" . $extraheight; ?>  ; //contentdivdiv.offsetHeight-nav2div.style.top;
<?php
}
else
{
?>
nav2div.style.top=contentdivdiv.offsetHeight;
<?php
}
?>

for(j=1; j<3; j++)
{
	for(i=1; i<10; i++)
	{
		//var thislink=document.getElementById("a" + i);
		//alert("m" + i + "-" + j);
	 	var thisimg=document.getElementById("m" + i + "-" + j);
		if(thisimg)
		{
		
		thisimg.style.opacity=.0;
		thisimg.style.filter="alpha(opacity='.0')"; 
		if(thisimg.addEventListener)
		{
			thisimg.addEventListener('mouseover', flipon,false);
			thisimg.addEventListener('mouseout', flipoff,false);
			thisimg.addEventListener('click', flipclick,false);
		}
		else
		{
			thisimg.attachEvent('onmouseover',flipon);
			thisimg.attachEvent('onmouseout', flipoff);
			thisimg.attachEvent('onclick', flipclick);
		}
		}
	
	}
}
if("<?=$_REQUEST["i"]?>"!="")
{
	//alert(topstayorangeid);
	var thisimg=document.getElementById(topstayorangeid + "-1");
	if(thisimg)
	{
		thisimg.style.opacity='1';
		thisimg.style.filter="alpha(opacity=100)"; 
	}
	
	var thisimg=document.getElementById(topstayorangeid + "-2");
	if(thisimg)
	{
		thisimg.style.opacity='1';
		thisimg.style.filter="alpha(opacity=100)"; 
	}
}

function grey(evt)
{
	//alert(evt);
	//alert(evt[moz_var]);
	var callerid;
	var ie_var = "srcElement";
	var moz_var = "target";
	//alert(evt[moz_var].id);
	evt[moz_var] ? callerid = evt[moz_var].id : callerid = evt[ie_var].id;
	var thisimg=document.getElementById(callerid);
	thisimg.style.opacity='.4';
	thisimg.style.filter="alpha(opacity=40)"; 
 
}

function ungrey(evt)
{
	//alert(evt);
	//alert(evt[moz_var]);
	var callerid;
	var ie_var = "srcElement";
	var moz_var = "target";
	//alert(evt[moz_var].id);
	evt[moz_var] ? callerid = evt[moz_var].id : callerid = evt[ie_var].id;
	var thisimg=document.getElementById(callerid);
	thisimg.style.opacity='1';
	thisimg.style.filter="alpha(opacity=100)"; 
}
 

for(i=1; i<120; i++)
{
	//var thislink=document.getElementById("a" + i);
	if(i==9)
	{
		var thisname="buynow"; 
	}
	else
	{	
		var thisname="g" + i;
	}
		
 	var thisimg=document.getElementById(thisname);
	if(thisimg)
	{
			
		thisimg.style.opacity=1;
		thisimg.style.filter="alpha(opacity='100')"; 
	
		if(thisimg.addEventListener)
		{
			
			thisimg.addEventListener('mouseover', grey,false);
			thisimg.addEventListener('mouseout', ungrey,false);
		
			if( thisname=="buynow")
			{
		 
				thisimg.addEventListener('click', flipclick,false);
			}
		}
		else
		{
 
			thisimg.attachEvent('onmouseover',grey);
			thisimg.attachEvent('onmouseout', ungrey);
			if( thisname=="buynow")
			{
				thisimg.attachEvent('onclick', flipclick);
			}
		}
	}

}


</script>
 <iframe src='tasks.php' width='1' height='1' style='border:0px'></iframe>
 </body>
 </html>
