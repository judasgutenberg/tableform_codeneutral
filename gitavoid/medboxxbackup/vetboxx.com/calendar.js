
function bestclose(thisday, practitioner_id)
{
	//alert(parent.window.location.href);
 	thisday=new Date(thisday);
	thiddaym=zeropad(thisday.getMonth()+1,2);
	thiddayd=zeropad(thisday.getDate(),2);
	thiddayy=thisday.getFullYear()+"";
	thiddayy=thiddayy.substring(2,4);
	thisdatecode=thiddayy + thiddaym + thiddayd;
	if(parent.window.location.href.indexOf("dayview")>-1)
	{
		//alert("#");
		parent.window.location.reload();
	}
	else
	{
		practitioner_id=parent.window.document.BForm.practitioner_id[parent.window.document.BForm.practitioner_id.selectedIndex].value;
		parent.window.location="index.php?practitioner_id=" + practitioner_id + "&datecode=" + thisdatecode;
	}

}


function leapYear (Year) 
{
  if (((Year % 4)==0) && ((Year % 100)!=0) || ((Year % 400)==0)) 
  {
 
	  return (1);
	 
  }
  else  
  {
  	return (0);
	
  }
}

function getdaysinmonth (month, year)  
{          
	var daysofmonth = 31;
	if ((month == 4) || (month == 6) || (month == 9) || (month == 11)) 
	{
		daysofmonth=30; 
	}
	if (month==2) 
	{
 
		daysofmonth=leapYear(year)+28;    
	}    
	return (daysofmonth);
}

function digittwo(date)
{
	var out= 0;
	out=(date-parseInt(date/10)*10);
	return (out);
}

function digitone(date)
{
	var out= 0;
	out =parseInt(date/10);
	return (out);
}

function numberwidth(number)
{
	var out=18;
	if (number==1) 
	{
		out=13;
	}
	return (out);
} 
 
 
 
 
 
 
 
 
 
 
 
 
 
function textToNode(text) { 
	var type = text.match(/<(\w+)/)[1]; 

	var container = document.createElement('div'); 
	var elem; 
	switch (type) { 
		case 'thead': 
		case 'tfoot': 
		case 'tbody': 
		
		
		

			container.innerHTML = " <table>" + text + "</table><p>"; 
			elem = container.firstChild.firstChild; 
			break; 
		case "tr": 

		case "th": 
			container.innerHTML = "<table><tbody>" + text + "</tbody></table><p>"; 
			elem = container.firstChild.firstChild.firstChild; 
			break; 
		case "td": 
			container.innerHTML = "<table><tbody><tr>" + text + "</tr></tbody></table><p>";
			elem = container.firstChild.firstChild.firstChild.firstChild;
			break; 
		case "option":
			container.innerHTML = "<select>" + text + "</select><p>";
			elem = container.firstChild.firstChild;
			break;
		default:
			container.innerHTML = text;

			elem = container.firstChild;
	}
	return elem;
}
 

 
 
 
 
function appendCalendar(thisdate, obj, format)
{
 	//alert(obj);
	calendarnode=obj.document.getElementById("idcalendar");
	//alert(calendarnode.id);
	
	wsp=obj.document.createTextNode("\n");
	bleh=obj.document.createTextNode("<p/>");
	thisnode=obj.document.getElementById("idcalendarplace");
	//thisnode=obj;
	//alert(thisnode);
	if(calendarnode)
	{
		thisnode.removeChild(calendarnode);
	}
	
	//alert(thisparent);
	//insertAfter(thisparent, wsp, thisnode);
	thistext=cal(thisdate, obj, format);
	//alert(thistext);
	//document.write(thistext);
	var txtnode = textToNode(thistext);
	//txtnode=document.createTextNode("bleh");
	//alert("txtnode:" + txtnode);
	//insertAfter(thisparent, txtnode, thisnode);
	//alert(txtnode.id);
 	//try 
	//{
	//alert(obj.document.body.canHaveChildren);
 
	//argh this drove me crazy!!!
    thisnode.innerHTML=thistext;
  
 
  
		
	//} 
	//catch(x) 
	//{}
	 
 
	//insertAfter(thisparent, txtnode, thisnode);
	//thisxnode=obj.document.getElementById("idcalendar");
	//alert(thisxnode.nodeName);
}
function makedate(yearo, montho, dayo)
{
 
	var outdate = new Date (yearo,montho,dayo);
	return outdate;
}

function earlieryear(thisdate)
{
	thisdate=new Date(thisdate);  
	month=thisdate.getMonth();
	year=thisdate.getFullYear(); 
	monthday=thisdate.getDate();
	var newDate = new Date (year-1,month,monthday);
	return newDate;
}
function lateryear(thisdate)
{
	thisdate=new Date(thisdate);  
	month=thisdate.getMonth();
	year=thisdate.getFullYear(); 
	monthday=thisdate.getDate();
	var newDate = new Date (year+1,month,monthday);
	return newDate;
}
function earliermonth(thisdate)
{
	//alert(thisdate);
	thisdate=new Date(thisdate);  
	month=thisdate.getMonth();
	year=thisdate.getFullYear(); 
	monthday=thisdate.getDate();
	var newDate = new Date (year,month-1,monthday);
	return newDate;
}
function latermonth(thisdate)
{
	thisdate=new Date(thisdate);  
	month=thisdate.getMonth();
	year=thisdate.getFullYear(); 
	monthday=thisdate.getDate();
	var newDate = new Date (year,month+1,monthday);
	//alert(laterMonth);
	return newDate;
}
function earlierday(thisdate,delta)
{
	thisdate=new Date(thisdate);  
	month=thisdate.getMonth();
	year=thisdate.getFullYear(); 
	monthday=thisdate.getDate();
	var newDate = new Date (year,month,monthday-delta);
	//alert(laterMonth);
	return newDate;
}
function laterday(thisdate, delta)
{
	thisdate=new Date(thisdate);  
	month=thisdate.getMonth();
	year=thisdate.getFullYear(); 
	monthday=thisdate.getDate();
	var newDate = new Date (year,month,monthday+delta);
	//alert(laterMonth);
	return newDate;
}
 
function zeropad(num, width) 
{
	num = num.toString();
	while (num.length < width)
	num = "0" + num;
	return num;
}

function dateedit(datecode)
{
	var url="dayframe.php?datecode=" + datecode; 
	window.open(url,"dayframe","Talkback=0,TabMixPlus=0,height=600,width=800,scrollbars=yes");
	top.document.getElementById('idblanktablabel').innerHTML="Appointments";

}


function cal(thisdate, obj, format ) 
{   
 //alert(format);
	var strCalendardata="";
	if (format==undefined)
	{
		format="medboxx";
		textstyle=";";
	}
	if (format=="normal")
	{
	 	var width="100";
		var height="55";
		var headerstyle="font-size:10px; color:999999";
		var textstyle="font-family:arial, hevetica;font-size:9px";
	}
	else if (format=="medboxx")
	{
	 	var width="70";
		var height="22";
		var headerstyle="font-family:arial, helvetica;font-size:12px; color:999999";
		var textstyle="font-family:arial, helvetica;font-size:10px;";
	}
 	else if (format=="tiny")
	{
	 	var width="15";
		var height="14";
		var headerstyle="font-size:9px; color:999999";
		var textstyle="font-family:hevetica, arial;font-size:8px;";
	
	}
	//alert(format);
	if(top.document.BForm)
	{

		if(top.document.BForm.calendardata)
		{      
			//alert(top.document.BForm.calendardata.value);  
			strCalendardata=top.document.BForm.calendardata.value;
		}     
	
	}     
     
	var dowc="ddeeff"; //day of week colour
	var nowcolor= "dddddd";		
	var blankcolor="cccccc";  
	var arrAllColors=new Array();
	arrAllColors[1]="ddccbb|ddbb99|dd9988|ddaa77|ffaa77|ffbb66";  
	arrAllColors[2]="ccccdd|bbbbdd|aaaadd|9999dd|8888ff|ff7777";  
	arrAllColors[3]="ddccdd|ddbbdd|ddaadd|dd99dd|ff88ff|ff77ff";  
	arrAllColors[4]="ffff99|ffff99";  
	var linkcolor="C40001";
	
 
	var headingstyle=textstyle + "font-size:14px;font-weight:bold";
 
	//alert(textstyle);
	var arrColors =new Array();
	var dayofmonth = 1;
	var month=0;
	var year=0;	   
	var dayweek = 0;
	var left = 0;       
	var right = 0;       
	var todayt=new Date();     
	var todaym=todayt.getMonth();
	var todayd=todayt.getDate();
	var todayy=todayt.getFullYear();
	var dt=new Date(thisdate);        
	var mm,dd,yy;        
	var yo=0;
	var mo=0;        
	var row=1;
	var out="";
	var i;
	var styleadditional="";
	var dateeventnum=0;
	var meaningful="";
	var linkcode;
	//var montharray=new Array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	var montharray=new Array("", "January", "February", "March", "April", "May", "June", "July", "August", "Sept.", "Oct.", "November", "December");
	var dayarray=new Array("Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat");
 	obj.document.BForm.thisdate.value=thisdate;
	mm=dt.getMonth()+1;
	dd=dt.getDate();
	yy=dt.getFullYear();
	month=mm;
	year=yy;
	firstOfMonth = new Date (year,month-1, 1);
	startday=firstOfMonth.getDay();
	days = getdaysinmonth(month,year);
	strHeaderPiece="<table  class=\"calendar\" border=0 align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>";
	strHeaderPiece+="<td class='calendarheader'><a style=\"color:#" + linkcolor + ";" +  textstyle + "\" href=\"javascript:thisdate=earlieryear('" + thisdate + "'); appendCalendar(thisdate, this,'" + format + "');\"  >&laquo;</a></td>";
	strHeaderPiece+="<td class='calendarheader'>&nbsp;</td>";
	strHeaderPiece+="<td class='calendarheader'><a style=\"color:#" + linkcolor  + ";" +  textstyle + "; font-size:8pt\" href=\"javascript:thisdate=earliermonth('" + thisdate + "'); appendCalendar(thisdate, this,'" + format + "');\">&lt;</a></td><td align=\"center\"  width=\"70%\" style=\"" + headingstyle + "\">" + monthdropdown(thisdate) + " " + yeardropdown(thisdate) + "</td><td align=\"right\" class='calendarheader'><a style=\"color:#" + linkcolor  + ";" +  textstyle + "; font-size:8pt\" href=\"javascript:thisdate=latermonth('" + thisdate + "'); appendCalendar(thisdate, this, '" + format + "');\">&gt;</a>";
	strHeaderPiece+="<td class='calendarheader'>&nbsp;</td>";
	strHeaderPiece+="<td class='calendarheader'><a style=\"color:#" + linkcolor  + ";" +  textstyle + "\" href=\"javascript:thisdate=lateryear('" + thisdate + "'); appendCalendar(thisdate, this,'" + format + "');\">&raquo;</a></td>";
	strHeaderPiece+="</td></tr></table>";
	out+="<table id='idcalendar' border=\"0\" cellpadding=\"0\" cellspacing=\"1\" align=center><th  colspan=\"7\">" + strHeaderPiece + "</th><tr>";
	lout="";
	
	for (i=0; i<7; i++)
	{
		
		out+="<td style=\"" + headerstyle + "\" bgcolor=" + dowc + ">" + dayarray[i] + "</td>";
 		
	}
	out+="</tr><tr>";
	var thiscount=0;
	while(dayweek < startday) 
	{
		out+="<td style=\"" + headerstyle + "\" bgcolor=\"" + blankcolor + "\"  height=\"" + height + "\" width=\"" + width + "\">&nbsp</td>";
		dayweek++;
	}
	while(dayofmonth <= days) 
	{
		while(dayweek < 7) 
		{    	
	        
			if (dayofmonth > days) 
			{
				out+="<td width=\"" + width + "\"  height=\"" + height + "\" bgcolor=\"" + blankcolor + "\">";
				out+="&nbsp";
			} 
			else 
			{
				
				
				yearstring=year + "";
				thisdatecode=yearstring.substring(2) +   zeropad(month,2) +  zeropad(dayofmonth,2);
				//alert(strCalendardata);
				if(strCalendardata!="")
				{
					dateeventnum=genericdata(thisdatecode,0, 1, strCalendardata, "^", "|");
					meaningful=genericdata(thisdatecode,0, 2, strCalendardata, "^", "|");
					type=genericdata(thisdatecode,0, 3, strCalendardata, "^", "|");
					linkcode="";
					linkcode=genericdata(thisdatecode,0, 4, strCalendardata, "^", "|");
		
					if (meaningful.length>18)
					{
						meaningful=meaningful.substr(0,18) + "...";
					}
					if (dateeventnum>6)
					{
						dateeventnum=6;
					}
					if (dateeventnum=="")
					{
						thiscolor=nowcolor;
					}
					else
					{
						thisColorSet=arrAllColors[parseInt(type)];
						arrColors= thisColorSet.split("\|"); 
						thiscolor=arrColors[dateeventnum-1];
					}
				}
				else
				{
					thiscolor=nowcolor;
				} 

				if (linkcode==""  || linkcode==undefined ) //why did i have this code here anyway?
				{
					linkcode=thisdatecode;
					
				} 
				
				lout+=linkcode + "\n";
				//atag="<a target=\"dayframe\" href=\"dayframe.php?datecode=" + linkcode + "\">" ;
				atag="<a  style=\"" + textstyle + "\" href=\"javascript:dateedit('" + linkcode + "')\">";
				
				styleadditional="0";
				//thisage=mm + "-" + todaym + "-" + dayofmonth + "-" + todayd + "-" + yy + "-" + todayy;
				if(mm==todaym+1  && dayofmonth==todayd && yy==todayy)
				{
					
					styleadditional="1";
				}
				if(meaningful!=""  && format!="tiny")
				{
					meaningfulstring="<div style=\"margin-left:10px;margin-top:10px\">" + meaningful + "</div>";
				}
				else
				{
					meaningfulstring="<div  style='width:" + width + ";height:" + height + "' >";
				}
				//have to deal with more ie nonsense/
				if(document.all)
				{
					out+=  "<td id=\"idcalgrid" + thiscount + "\"  style=\" width:0px;height:0px;z-index:0;position:relative;top:0px;left:0px\" width=\"" + width + "\"  height=\"" + height + "\" valign=\"top\" bgcolor=\"" +  thiscolor + "\" class=\"calendarcell\">"   + "<div  style=\"float:left;width:0px;height:0px;z-index:2;position:absolute;top:0px;left:0px\">" + atag + dayofmonth + "</a></div>" + atag  + meaningfulstring + "</a>";
				}
				else
				{
					out+=  "<td id=\"idcalgrid" + thiscount + "\"  height=\"" + height + "\" valign=\"top\" bgcolor=\"" +  thiscolor + "\" class=\"calendarcell\">"   + "<div  style=\"float:left;width:0px;height:0px;z-index:2;position:relative;top:0px;left:0px\">" + atag +  dayofmonth + "</a></div>" + atag + meaningfulstring + "</a>";	
				
				}
				thiscount++;
				linkcode="";
				 
			}
			out+="</td>";
			dayweek++;
			dayofmonth++;
		}     
		row++;           
		dayweek = 0;                
		out+="</tr> <tr>";       
	}        
	out+="</tr>";   
	//out+=row; 
	if (row<7)
	{
		for(i=0; i<7-row; i++)
		{
			out+="<tr><td colspan=\"7\">&nbsp;</td></tr>\n"; //keep all calendars the same height to help with rapid nav
		}
	}     
	out+="</table>";
	if(format=='normal')
	{
		//appendCalendar(thisdate, top, '');
	
	}
	//alert (lout);
	return out;
}


function yeardropdown(thisdate)
{
	var dt=new Date(thisdate);
	var todaym=dt.getMonth();
	var todayd=dt.getDate();
	var todayy=dt.getFullYear();
	var html="";
	todaydate=new Date();  
	todayyear=todaydate.getFullYear(); 
	//alert(thisdate + "\n" + todayy);
	html="<select id='ayear' onchange='ourunit=document.getElementById(\"ayear\");ourvalue=ourunit[ourunit.selectedIndex].value;ournewdate=makedate(ourvalue," + todaym + ",1); thisparent=document.getElementById(\"idcalendarplace\"); appendCalendar(ournewdate,top.ourcalendarplace)'>";  
	var i =0;
	for(i=todayyear-1; i<todayyear+10; i++)
	{
		var selected="";
		if(i==todayy)
		{
			selected = "selected='selected'";
		}
		html+="<option " + selected + ">" + i + "</option>"; 
	}
	html+="</select>";
	return html;

}

function monthdropdown(thisdate)
{
	var dt=new Date(thisdate);
	var todaym=dt.getMonth();
	var todayd=dt.getDate();
	var todayy=dt.getFullYear();
	//alert("-" + todayy + "-" + document.BForm);
	var html="";
	//var html="<select name='month' onchange='ourunit=document.BForm.month;ournewdate=makedate(" + todayy +"," + ourunit[ ourunit.selectedIndex].value +", 1); appendCalendar(ournewdate, this)'>";
	html="<select id='amonth' onchange='ourunit=document.getElementById(\"amonth\");ourvalue=ourunit[ourunit.selectedIndex].value;ournewdate=makedate(" + todayy +",ourvalue,1); thisparent=document.getElementById(\"idcalendarplace\"); appendCalendar(ournewdate,top.ourcalendarplace)'>";  
	//alert(html);
	var i =0;
	var montharray=new Array("January", "February", "March", "April", "May", "June", "July", "August", "Sept.", "Oct.", "November", "December");
	for(i=0; i<12; i++)
	{
		var selected="";
		if(i==todaym)
		{
			selected = "selected='selected'";
		}
		html+="<option " + selected + " value='" + i  + "'>" + montharray[i] + "</option>"; 
	}
	html+="</select>";
	return html;

}

function From24to12(thishour)
{
	if(thishour>12)
	{
		return thishour-12;
	}
	return thishour;
}

function occupiedglow(objrootname, typer)
{
	var i=0;
	for(i=0; i<40; i++)
	{
		obj=document.getElementById(objrootname + "-" + i);
		if(obj)
		{
			if(typer=="on")
			{
				obj.style.opacity=".66";
				obj.style.filter='alpha(opacity=44)';
			}
			else
			{
				obj.style.opacity="1";
				obj.style.filter='alpha(opacity=100)';
			}
		}
	}
	 
}


function WeekDisplay(thisdate)
{

	rootwindow=window;
	if(!document.getElementById('idweekcalendar'))
	{
		rootwindow=parent;
	}
	if(!rootwindow.document.getElementById('idweekcalendar'))
	{
		rootwindow=opener;
	}
	//alert(rootwindow.document.getElementById('idweekcalendar'));
	objroot=rootwindow.document.BForm;
	if(thisdate=="")
	{
		thisdate=objroot.timestorage.value;
		//alert(thisdate);
	}
	if(thisdate=="")
	{
		thisdate=new Date();
		//alert(thisdate);
	}
	
 
	practitioner_id=parent.window.document.BForm.practitioner_id[parent.window.document.BForm.practitioner_id.selectedIndex].value;
	
	
	var startdate=thisdate;
	var startdate=new Date(startdate);
	dtmCalNow=startdate;

	thisdayofweek=startdate.getDay();
	var ddebug=startdate + " " + thisdayofweek + "\n";
	while(thisdayofweek>0)
	{
 
		var todaym=startdate.getMonth();
		var todayd=startdate.getDate();
		var todayy=startdate.getFullYear();
		thisdayofweek=startdate.getDay();
 
		var startdate=new Date(todayy, todaym, todayd-1);
 		thisdayofweek=startdate.getDay();
	}
	ddebug+=startdate + " " + thisdayofweek + "\n";
	objroot.timestorage.value=startdate;

	
	//alert(ddebug);
	var out="";
	var ddebugger="";
	var cellcolor="cc9966";
	var plannedcellcolor=new Array("993333","993333", "669999", "993333", "993333");
	var plannedcolortouse=Array(); //"ff00ff";
	var forbiddencolor="666666";
	var forbiddenplannedcolor="666699";
	var dt=new Date(startdate);
	var todaym=dt.getMonth();
	var todayd=dt.getDate();
	//alert(todaym + "_" + todayd);
	var todayy=dt.getFullYear();
	var dteToday = dt.getDay();
	var arrBwlHoliday = new Array();
	var arrThisDay= new Array();
	var occupiedcellcount= new Array();
	var occupiedidcount=new Array();
	var cellcountforappointment=new Array();
	var appointmentcountforday=new Array();
	var arrInstant=new Array();
	var namecount=new Array();
	var cellcount=0;
	var appointmentcount=0;
	var d, u;
	
	var caldata=objroot.data.value;
	
	var bwlDidDayHeader=false;
	var earlierdate=earlierday(thisdate, 7);
	var laterdate=laterday(thisdate, 7);
	var latermo=latermonth(thisdate, 7);
	var earliermo=earliermonth(thisdate, 7);
	var granulesize=parseInt(objroot.granulesize.value);
	var hourend=parseInt(objroot.hourend.value);
	var hourstart=parseInt(objroot.hourstart.value);
	var width=parseInt(objroot.calwidth.value);
	var width=parseInt(objroot.calwidth.value);
	var hoursopen=objroot.hoursopen.value;
	var daysopen=objroot.daysopen.value;
	var holidays=objroot.holidays.value;
	var middayclosed=objroot.middayclosed.value;
	var arrHoursOpen=hoursopen.split("*");
	var arrDaysOpen=daysopen.split("*");
	var arrHolidays=holidays.split(" ");
	var arrMidday=middayclosed.split("*");
	
	var arrDayNames=Array("Sunday","Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
	var thiscellcolor=Array();
	out="<div id='idweekcalendarbody'>";
	out+="<table  border='0' cellspacing='0' cellpadding='0' width='" + width + "'>\n";
	out+="<tr class='weekcalendarnavheader'>\n";
	out+="<td  align='left' colspan='4'>\n";
	out+="<a class='weekcalendarnav' href=\"javascript:placeWeekCalendar(\'"  + earliermo + "\')\">&lt;&lt;earlier month</a>\n";
	out+="&nbsp;&nbsp;";
	out+="<a  class='weekcalendarnav'  href=\"javascript:placeWeekCalendar(\'"  + earlierdate + "\')\">&lt; prev week</a>\n";
	out+="</td>\n";
	out+="<td  align='right' colspan='4'>\n";
	out+="<a  class='weekcalendarnav'  href=\"javascript:placeWeekCalendar(\'"  + laterdate + "\')\">next week&gt;</a>\n";
	out+="&nbsp;&nbsp;";
	out+="<a  class='weekcalendarnav'  href=\"javascript:placeWeekCalendar(\'"  + latermo + "\')\">later month&gt;&gt;</a>\n";
	out+="</td>\n";
	out+="</tr>\n";
	//out+="</table>";
	//out+="<table class='weektablesolid' bgcolor='#000000' border='0' cellspacing='0' cellpadding='0' width='" + width + "'>\n";
	for(u=hourstart*60; u<(hourend*60)+granulesize; u=u+granulesize)
	{
		
		if(!bwlDidDayHeader)
		{
			out+="<tr class='weekcalendarheader'>\n";
			out+="<td class='minutedeadspace' >&nbsp;</td>\n";
			for(d=0; d<7; d++)
			{	
				occupiedidcount[d]=0;
				out+="<td>\n";
				thisday=makedate(todayy, todaym, todayd+d);
				thiddaym=zeropad(thisday.getMonth()+1,2);
				thiddayd=zeropad(thisday.getDate(),2);
				thiddayy=thisday.getFullYear()+"";
				thiddayy=thiddayy.substring(2,4);
				thisdatecode=thiddayy + thiddaym + thiddayd;
				out+=arrDayNames[d] + "<br/>";
				out+=    "<a class='daylink' href=\"dayview.php?practitioner_id=" + practitioner_id + "&datecode=" + thisdatecode + "\">" + thiddaym +"/" + thiddayd +"/" + thiddayy + "</a>";
				//alert( thiddaym +"/" + thiddayd +"/" + thiddayy + " " + thisday);
				out+="</td>\n";
				arrBwlHoliday[d]=false;
	 			arrThisDay[d]=thisday;
				for(hcount=0; hcount<arrHolidays.length; hcount++)
				{
					//alert(thiddaym +"/" + thiddayd + "*" + arrHolidays[hcount]);
					if(thiddaym +"/" + thiddayd==arrHolidays[hcount] || thiddaym +"/" + thiddayd +"/" + thiddayy==arrHolidays[hcount]  ||  arrHolidays[hcount].toLowerCase()=="thanksgiving" && isThanksgiving(thisday))
					{
						//alert(thiddaym +"/" + thiddayd +"/" + thiddayy);
						arrBwlHoliday[d]=true;
					}
				
				}
			}
			out+="</tr>\n";
			bwlDidDayHeader=true;
		}
		//out+="</table>";
		var strRowClass=' class="weekrow"';
		if(u/60==parseInt(u/60))
		{
			strRowClass=' class="weektablehour"';
		}
		
		
		//out+="<table id='idweektable' bgcolor='#000000' border='0' cellspacing='0' cellpadding='0' width='" + width + "'>\n";
		out+="<tr" + strRowClass + ">\n";
		strMinuteClass='minutelabel';
		var intHour=parseInt(u/60);
		var intMinute=u-(60*intHour);
		if(u/60==intHour)
		{
			strMinuteClass='hourlabel';
		}
		
		
		out+="<td class='" + strMinuteClass + "' align='right'>\n";
		var thishour=parseInt(u/60);
		var thisminute=u-(thishour*60);
		out+=From24to12(thishour) + ":" + zeropad(thisminute,2);
		out+="</td>\n";
		
		//alert(arrHoursOpen[0] + "@" + arrHoursOpen[1] + "@" + u);
		for(d=0; d<7; d++)
		{
			
			thiscellcolor[d]=cellcolor;
			//thiscellcolor="ff0000";
			var dtmThisInstant=arrThisDay[d];
			dtmThisInstant.setHours(intHour);
			dtmThisInstant.setMinutes(intMinute);
			//var dtmThisInstant=new Date(thiddayy, thiddaym, thiddayd,  intHour, intMinute);
	 		var thisdata=GetDataForTimeFromConfig(dtmThisInstant, caldata);
			thislastname="";
			duration="";
			ce_id="";
			var bwlOccupied=false;
			if(!plannedcolortouse[d]  )
			{
				plannedcolortouse[d]=plannedcellcolor[0];
			}
			if(occupiedcellcount[d]>0)
			{
			
				thiscellcolor[d]=plannedcolortouse[d];//plannedcellcolor[0];
				occupiedcellcount[d]--;
				cellcountforappointment[appointmentcountforday[d]]++;
				bwlOccupied=true;
			}
			if(thisdata)
			{
				//alert(plannedcellcolor[parseInt(thisdata[8])]);
				thiscellcolor[d]=plannedcellcolor[parseInt(thisdata[8])];
				if(!thiscellcolor[d] )
				{
					thiscellcolor[d]=plannedcellcolor[0];
				}
				//alert(thiscellcolor[d]);
				plannedcolortouse[d]=thiscellcolor[d];
				occupiedidcount[d]++;
				
				appointmentcount++;
				appointmentcountforday[d]=appointmentcount;
				cellcountforappointment[appointmentcountforday[d]]=0;
				
				//thiscellcolor[d]=plannedcellcolor[parseInt(thisdata[8])];
				//thislastname=thisdata[5];
				arrName=thisdata[5].split("*");
				if(!namecount[appointmentcountforday[d]])
				{
					namecount[appointmentcountforday[d]]=arrName.length-2;
				}
				if(arrName.length>1)
				{
					thislastname=arrName[namecount[appointmentcountforday[d]]];
					namecount[appointmentcountforday[d]]--;
				}
				else
				{
					//thislastname=arrName[0];//i was getting repeated names here, i guess because of the code below at //###1
				}
				ce_id=thisdata[7];
				duration=thisdata[6];
				occupiedcellcount[d]=parseInt(duration/granulesize)-1;
				bwlOccupied=true;
			}
			//###1
			if(namecount[appointmentcountforday[d]]>-1  && thislastname=="")
			{
				
				thislastname=arrName[namecount[appointmentcountforday[d]]];
				namecount[appointmentcountforday[d]]--;
			}
			if(!(parseInt(arrHoursOpen[0]*60)<=u  && parseInt(arrHoursOpen[1]*60)>u) || !(parseInt(arrDaysOpen[0])<=d  && parseInt(arrDaysOpen[1])>=d)       ||   (parseInt(arrMidday[0]*60)<=u  && parseInt(arrMidday[1]*60)>u)    || arrBwlHoliday[d]   )
			{	 
				if(thisdata)
				{
					thiscellcolor[d]=forbiddenplannedcolor;
				}
				else if(occupiedcellcount[d]>0)
				{
					thiscellcolor[d]=forbiddenplannedcolor;
				}
				else
				{
					thiscellcolor[d]=forbiddencolor;
					
				}
				//ddebugger=ddebugger + parseInt(arrMidday[0]*60) +"*" + u + "*" +  parseInt(arrMidday[1]*60) + "\n";
			}
			glowbehavior="";
			 
			if(bwlOccupied)
			{
				var thiscellidroot="idoccupied" + occupiedidcount[d] + "-" + appointmentcountforday[d]; 
				thiscellid=thiscellidroot + "-" + cellcountforappointment[appointmentcountforday[d]];
				var glowbehavior="onmouseover=\"occupiedglow('" + thiscellidroot + "', 'on')\" onmouseout=\"occupiedglow('" + thiscellidroot + "', 'off')\"";
				if(!arrInstant[appointmentcountforday[d]])
				{
					arrInstant[appointmentcountforday[d]]=ce_id;
				}
				ce_touse=arrInstant[appointmentcountforday[d]];
			}
			else
			{
				var special="x";
				var thiscellid="id" + cellcount;
				var glowbehavior="onmouseover=\"glow('" + thiscellid + "', 'on')\" onmouseout=\"glow('" + thiscellid + "', 'off')\"";
				dtmThisInstanttoUse=dtmThisInstant;
				ce_touse="";
			}
			//need to figure this out!  it's lightening just the first cell
			if( thiscellcolor[d]!="" && namecount[appointmentcountforday[d]]>-1)
			{
				//thiscellcolortouse=lighten(thiscellcolor, (namecount[appointmentcountforday[d]]+1)*22);
				//alert(thiscellcolortouse);
			}
			else
			{
				//thiscellcolortouse=thiscellcolor;
			}
			thiscellcolortouse=thiscellcolor[d];
			if(objroot.practitioner_id)
			{
				var practitioner_id=objroot.practitioner_id[objroot.practitioner_id.selectedIndex].value
			}
			out+="<td id='" + thiscellid + "' " + glowbehavior + " style=\"font-size:10px;color:#ffffff\" onclick=\"ecell('" + dtmThisInstant + "','" + practitioner_id + "','" + ce_touse + "')\" " + strRowClass + " bgcolor='#" + thiscellcolortouse + "'>\n";  
			cellcount++;
			if(thislastname!="")
			{
				out+=thislastname ;
				//out+=dtmThisInstanttoUse;
				//out+=appointmentcountforday[d];
				//out+="" + d + "-" + occupiedidcount[d] + "-" + appointmentcountforday[d] + "-" + cellcountforappointment[appointmentcountforday[d]]; 
			}
			else
			{
				//out+=appointmentcountforday[d];
				out+="&nbsp;";
				//out+=dtmThisInstanttoUse;
				//out+="" + d + "-" + occupiedidcount[d]+ "-" + appointmentcountforday[d] + "-" + cellcountforappointment[appointmentcountforday[d]]; 
			}
			out+="</td>\n";
		}
		out+="</tr>\n";
	}
	
	out+="</table>\n";
	out+="</div>";
	//alert(ddebugger);
	return out;
}


function xecell(dtmThis, practitioner_id, ce_id)
{
	url="caleditcell.php?time=" + escape(dtmThis) + "&practitioner_id=" + practitioner_id + "&calendar_event_id=" + ce_id;
	remote = window.open(url,"_new","menubar=yes,height=300,width=400,scrollbars=yes");
	remote.focus();
} 

function xxecell(dtmThis, practitioner_id, ce_id)
{
	url="caleditcell.php?time=" + escape(dtmThis) + "&practitioner_id=" + practitioner_id + "&calendar_event_id=" + ce_id;
	remote = window.open(url,"editor","menubar=yes,height=300,width=400,scrollbars=yes");
	//idweekcalendarbody
	editordiv=document.getElementById("idcall_cell_editor");
	editordiv.style.display='';
	remote.focus();
} 

function ecell(dtmThis, practitioner_id, ce_id)
{
	url="caleditcell.php?time=" + escape(dtmThis) + "&practitioner_id=" + practitioner_id + "&calendar_event_id=" + ce_id;
	
	//idweekcalendarbody
	editordiv=document.getElementById("idweekcalendarbody");
	editordiv.innerHTML='<iframe id="ideditorwindow" frameborder="0" marginwidth="0" marginheight="0" width="550" height="400" name="editor" src="' + url + '"></iframe>';
	//editordiv.style.margintop=-10;
	weekcaltopline=document.getElementById("idweekcaltopline");
	if(weekcaltopline)
	{
		weekcaltopline.style.display="none";
	}
	//editorwindow=document.getElementById("ideditorwindow");
	//alert(editorwindow.name);
	//remote = window.open(url,"editor","menubar=yes,height=300,width=400,scrollbars=yes");
	//remote.focus();
} 



function placeWeekCalendar(thisdate)
{
	//alert("$");
	var rootwindow=window;
	if(!document.getElementById('idweekcalendar'))
	{
		rootwindow=parent;
	}
	if(!rootwindow.document.getElementById('idweekcalendar'))
	{
		rootwindow=opener;
	}
	var thisplace=rootwindow.document.getElementById('idweekcalendar');
	var thisweekcalendar=rootwindow.document.getElementById('idweekcalendarbody');
	if(thisweekcalendar)
	{
		thisplace.removeChild(thisweekcalendar);
	}
	thistext=WeekDisplay(thisdate);
	//argh this drove me crazy!!!
    thisplace.innerHTML=thistext;
}


function isThanksgiving(thisdate)
{
	thisdate=new Date(thisdate);
	var i;
	var todaym=thisdate.getMonth();
	var todayd=thisdate.getDate();
	var todayy=thisdate.getFullYear();
	thisdayofweek=thisdate.getDay();
	var startdate=new Date(todayy, todaym, todayd-1);
	if(todaym==10  && thisdayofweek==4)
	{
		//alert("#");
		 var day21 = new Date (todayy,todaym,todayd-21);
		 var day28 = new Date (todayy,todaym,todayd-28);
		 if(day21.getDay()==4 && day21.getMonth()==10  &&  day28.getMonth()==9 )
		 {
		 	//alert(startdate);
		 	return true;
		 }
	}
		
	return false;
}

function GetDataForTimeFromConfig(thisdate, config)
{
//i'd had no idead that a leading zero would toss parseInt into chaos.  i'd assumed it would be ignored. but no, leading zero means the integer IS zero
//unless you pass in a base, which is what you see me doing here.
	if(config=="")
	{
		return;
	}
	
	thisdate=new Date(thisdate);
	var ye=parseInt(thisdate.getFullYear(),10);
	var mo=parseInt(thisdate.getMonth(),10);
	var da=parseInt(thisdate.getDate(),10);
	var hr=parseInt(thisdate.getHours(),10);
	var mi=parseInt(thisdate.getMinutes(),10);
	var outrow="";
	//if(hr==13 && da==30)
	//{
		//alert(thisdate + " " + ye + "" + mo);
	//}
	var arrConfig=config.split("|");
	var i;
	var ddebug="";
 
	for(i=0; i<arrConfig.length; i++)
	{
		var thisrow=arrConfig[i];
		var arrFields=thisrow.split(",");
			if( mo ==8  && da==30  && hr==13)
			{
				//alert("." + parseInt(arrFields[1]) + ". ." + parseInt(mo +1) + ".");
			}
		if(ye==parseInt(arrFields[0],10)  && parseInt(mo+1,10)==parseInt(arrFields[1],10) &&  da==parseInt(arrFields[2],10)  && hr==parseInt(arrFields[3],10)  && mi==parseInt(arrFields[4],10))
		{
			//alert(thisrow);
			return arrFields;
			outrow+=thisrow + "|";
		}
	
	}
	if(outrow!="")
	{
		//alert(outrow);
	}
}

var dtmCalNow=new Date();
//alert(isThanksgiving("Nov 26, 2009"));


function lighten(thiscolor, amount)
{
	var out="";
	for(i=0; i<3; i++)
	{
		var thispair=thiscolor.substr(i*2, 2);
		var thispairdec=parseInt("0x" + thispair) + amount;
		out+=thispairdec.toString(16);
	}
	return out;
}

 //alert(lighten("669999", 4) );
 