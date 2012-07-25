//JS functions to draw relationships between tables in a web-based database map
//Judas Gutenberg 2007-2010

var startrelationcolor="ff9999";
var ambiverelationcolor="ff99ff";
var endrelationcolor="9999ff";
var linecolors="666699 990099 000000 0000ff 77aa77 ff0000"; 

//lots of globals to keep track of info during drags, etc.
var globalx=0;
var globaly=0;
var globalsavedx=0;
var globalsavedy=0;
var globalBwlMakingRelation=false;
var globalidstart="";
var globallineanimationframecount=0;
var globalprevbg;
var globaloverwidth=0;
var globalidhovering='';
var globaltimeintodrag=0;
var globalpopupmode="";
var globalidforpopup="";
var relationshipsexist=false;

function removeArrayItem(arrIn, thingToKill) 
{
	var i= 0;
	while (i < arrIn.length)
	{
		if (arrIn[i] == thingToKill) 
		{
			arrIn.splice(i, 1);
		} 
		else 
		{ 
			i++; 
		}
	}
	return arrIn;
}

function CountIncomingRelations(relationshipdata, thistable)
{
	var arrRdata=relationshipdata.split("|");
	var i;
	var counter=0;
	for(i=0; i< arrRdata.length; i++)
	{
		if(arrRdata[i])
		{
			var arrthis=arrRdata[i].split(" ");
			if(thistable==arrthis[2])
			{
				counter++;
			}
		}
	}
	return counter;
}

function drawrelationships(relationshipdata, specialreference)
{
	//if(!linecolors)
	{
		//var linecolors="666699 990099 000000 0000ff 77aa77 ff0000"; 
	}
	var arrlinecolor=linecolors.split(" ");
	var intlinecolorcursor=0;
	var arrRdata=relationshipdata.split("|");
 	var mapname="idmap";
	var tablelist=Array();//keyed to table names, contains ordinal numbers
	var ftablelist=Array(); //keyed to ftable names, contains ordinal numbers
	var overallordinal=Array(); //keyed to ftable + table names, contains ordinal numbers
	var intRouteNumber=0;
	var i;

	//i'd like to make downoffset change for really crowded PKs
	//ok that wasn't too hard (see thisfktableincomingrelationcount)
	var downoffsetdefault=-2;
	var downoffset=downoffsetdefault;
	var vdispfactordefault=2;
	var vdispfactor=vdispfactordefault;
	relationshipsexist=true;
	ClearRelations(mapname);
	if(arrRdata.length<32)//find best route only for small collections of tables
	{	
		intRouteNumber=-1;
	}
	for(i=0; i<arrRdata.length; i++)
	{
		if(arrRdata[i])
		{
			var arrthis=arrRdata[i].split(" ");
			var thistable=arrthis[0];
			var thiscolumn=arrthis[1];
			var thisfktable=arrthis[2];
			var thisfkcolumn=arrthis[3];
			var thisfktableincomingrelationcount=CountIncomingRelations(relationshipdata, thisfktable);
			var bwlNoDraw=false;
			downoffset=downoffsetdefault-thisfktableincomingrelationcount;
			vdispfactor=vdispfactordefault /( thisfktableincomingrelationcount/15);
			if(vdispfactor>3)
			{
				vdispfactor=3;
			}
			//alert(thistable + " " + thisfktable + " " + thisfktableincomingrelationcount  + " " + vdispfactor);
			var idendnonfk= "idfield-" + thistable + "-" + thiscolumn;
			var idendfk= "idfield-" + thisfktable + "-" + thisfkcolumn;
			if(isNaN(ftablelist[thisfktable]))
			{
				ftablelist[thisfktable]=0;
			}
			else
			{
				ftablelist[thisfktable]++;
			}
			if(isNaN(tablelist[thistable]))
			{
				tablelist[thistable]=0;
			}
			else
			{
				tablelist[thistable]++;
			}
			if(isNaN(overallordinal[thistable+thisfktable]))
			{
				overallordinal[thistable+thisfktable]=0;
			}
			else
			{
				overallordinal[thistable+thisfktable]++;
			}
			//alert(idendnonfk + " " + idendfk);
			var endnonfk=document.getElementById(idendnonfk);
			var endfk=document.getElementById(idendfk);
			
			if(endnonfk)
			{
				if(endnonfk.style.backgroundColor!=startrelationcolor)
				{
					endnonfk.style.backgroundColor=startrelationcolor;
				}
				else
				{
					endnonfk.style.backgroundColor=ambiverelationcolor;
				}
			}
			else
			{
				bwlNoDraw=true; //catch cases where the fields in the relation table don't actually exist
			}
			if(endfk)
			{
				if(endfk.style.backgroundColor!=endrelationcolor)
				{
					endfk.style.backgroundColor=endrelationcolor;
				}
				else
				{
					endfk.style.backgroundColor=ambiverelationcolor;
				}
			}
			else
			{
				bwlNoDraw=true;  //catch cases where the fields in the relation table don't actually exist
			}
			if(endnonfk)
			{
				var x1= AbsoluteOffset(endnonfk, "");
				var y1= AbsoluteOffset(endnonfk, "top");
				var nwidth=endnonfk.offsetWidth;
			}
			if(endfk)
			{
				var x2= AbsoluteOffset(endfk, "");
				var y2= AbsoluteOffset(endfk, "top");
				var fwidth=endfk.offsetWidth;
			}
			if(x1>0  && y1>0  && x2>0  && y2>0 && !bwlNoDraw)
			{
				linecolor=arrlinecolor[intlinecolorcursor];
				//rander=2;//parseInt(Math.random()*1000);
		 		 
				DrawRelationship(parseInt(x1),parseInt( y1),parseInt(x2) , parseInt(y2), "idrelationship " + arrRdata[i], mapname, nwidth, fwidth, tablelist[thistable], ftablelist[thisfktable], linecolor, intRouteNumber, downoffset, vdispfactor, 13);
		 
				intlinecolorcursor++;
				if(intlinecolorcursor==arrlinecolor.length)
				{
					intlinecolorcursor=0;
				}
			}
		}
	}
}

var xcount;

function ClearRelations(location)
{

	//alert(location);
	var container = document.getElementById(location);
	container.innerHTML="";
	return;
}

function ReturnSmaller(x, y)
{
	if(x<y)
	{
		return x;
	}
	return y;
}

function ReturnLarger(x, y)
{
	if(x>y)
	{
		return x;
	}
	return y;
}

function DrawRelationship(x1in, y1in, x2in, y2in, relname, location, width1, width2, disp1, disp2, linecolor, intThisRouteNumber, downoffset, vdispfactor, zindex)
{
	var arrRelName=relname.split(" ");
	var table1=arrRelName[1];
	var table2=arrRelName[3];
	//var zindex=22;
	var strokewidth=1.1; //seems to fix a subtle firefox bug preventing drawing of some horizontal lines
	//var downoffset=-11;
	var bwlFindBest=false;
	var intRouteNumber=0;
	var intTopRoute=intRouteNumber+2;
	var hdispfactor=2;
	var leftoffset=10+hdispfactor * (disp1 + disp2);
	var CollisionCounts=new Array();
	var rootvoffset=14;
  	if(intThisRouteNumber==-1)
	{
		intRouteNumber=0;
		intTopRoute=2;
		bwlFindBest=true;
	}
 
	//if(document.all)
	{
		// downoffset=downoffset; //god i hate internet explorer!
	}
	//var dispfactor=2;
	var x, y, yx;
	
	//I had been breaking the disps up but now I'm trying it without that.
	//disp1=disp2+disp1;
	//disp2=disp1;
	//alert(intRouteNumber +  " " + intTopRoute);
	while(intRouteNumber<intTopRoute)
	{
		var overlaps= new Array();
		overlaps.length=0;
		var collisioncount=0;
		if(intRouteNumber==1)
		{
			offset1=leftoffset+ hdispfactor * disp1;
			offset2=leftoffset + hdispfactor * disp1;
			voffset1= -rootvoffset+ vdispfactor * disp2;//i had been adding the offset here but since this on the FK side, it was just screwing up placement
			voffset2=downoffset+ vdispfactor * disp1;
		}
		else
		{
			offset1=leftoffset+ hdispfactor * disp2;
			offset2=leftoffset + hdispfactor * disp2;
			voffset1= -rootvoffset +vdispfactor * disp1; //i had been adding the offset here but since this on the FK side, it was just screwing up placement
			voffset2=downoffset+ vdispfactor * disp2;
		}
 
		var w=parseInt(Math.abs(x1in-x2in));
		var container = document.getElementById(location);
		var bwlSkipExtra1=false;
		var bwlSkipExtra2=false;
		var bwlSkipExtra1e=false;
		var bwlSkipExtra2e=false;
		
		var offsetsum=offset1 + offset2;
		y1=y1in-voffset1;
		y2=y2in-voffset2;
		var x1=x1in;
		var x2=x2in;
		var widthofeasternmost=width1;
		var offseteasternmost=offset1;
		if(x2<x1)
		{
			widthofeasternmost=width2; //allows me to make an ideal transition from north/south to east/west mode
			offseteasternmost=offset2;
		}
		var absxdif=Math.abs(x1-x2)  + offseteasternmost;
		var h=parseInt(Math.abs(y1-y2))+1;
	
		if(intRouteNumber==1)
		{
			if( absxdif-offseteasternmost < (widthofeasternmost + offsetsum)) //subject and foreign tables have a north/south or south/north relationship
			{
				x1=x1-offset1;
				x2=x2-offset2;
				x=ReturnSmaller(x1, x2);
				y=ReturnSmaller(y1, y2);
				yx=y2;
				if(x==x2)
				{
					yx=y1;
				}
				overlaps=overlaps.concat(DrawDivLine(yx, x, zindex, strokewidth, absxdif, linecolor, container, relname + " x-rn:" + intRouteNumber, bwlFindBest));
				bwlSkipExtra2e=true;
				bwlSkipExtra1e=true;
			}
			else if (x2<x1) //subject table is west of foreign table
			{
				x1=x1-offset1;
				x2=x2+(width2+offset2);
				//bwlSkipExtra2=true;
				//bwlSkipExtra1e=true;
				
				bwlSkipExtra1=true;
				bwlSkipExtra2e=true;
				w=w-(width2+offset1+offset2);
				yx= ReturnSmaller(y2, y1);
				y=y1;
				x=x2;
				if(y2==yx)
				{
					x=x1;
					y=y2;
				}
				overlaps=overlaps.concat(DrawDivLine(y, x2, zindex, strokewidth, w, linecolor, container, relname + " x-rn:" + intRouteNumber, bwlFindBest));
			}
			else if (x1<x2) //subject table is east of foreign table
			{
				x2=x2-offset2;
				x1=x1+(width1+offset1);
				bwlSkipExtra2=true;
				bwlSkipExtra1e=true;
				//bwlSkipExtra1=true;
				//bwlSkipExtra2e=true;
				
				w=w-(width1+offset1+offset2);
				y=ReturnSmaller(y2, y1);
				x=x2;
				overlaps=overlaps.concat(DrawDivLine(y1, x1, zindex, strokewidth, w, linecolor, container, relname + " x-rn:" + intRouteNumber, bwlFindBest));
			}
		 
			if(h!=0)//draw the vertical component of the relationship
			{
				overlaps=overlaps.concat(DrawDivLine(y, x, zindex, h, strokewidth, linecolor, container, relname + " y-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra1) 
			{//the short horizontal line coming to subject table from the west
		 		overlaps=overlaps.concat(DrawDivLine(y2, x2, zindex, strokewidth, offset1, linecolor, container, relname + " x1-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra2)
			{ //the short horizontal line coming to foreign table from the west
				overlaps=overlaps.concat(DrawDivLine(y1, x1, zindex, strokewidth, offset2, linecolor, container, relname + " x2-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra1e) 
			{//the short horizontal line coming to subject table from the east
		 		overlaps=overlaps.concat(DrawDivLine(y2, x2-offset1, zindex, strokewidth, offset1, linecolor, container, relname + " x1-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra2e) 
			{//the short horizontal line coming to foreign table from the east
				overlaps=overlaps.concat(DrawDivLine(y1, x1-offset2, zindex, strokewidth, offset2, linecolor, container, relname + " x2-rn:" + intRouteNumber, bwlFindBest));
			}
		
		}
		else
		{
			if( absxdif-offseteasternmost < (widthofeasternmost + offsetsum)) //subject and foreign tables have a north/south or south/north relationship
			{
				x1=x1-offset1;
				x2=x2-offset2;
				x=ReturnSmaller(x1, x2);
				y=ReturnSmaller(y1, y2);
				yx=y2;
				if(x==x2)
				{
					yx=y1;
				}
				overlaps=overlaps.concat(DrawDivLine(yx, x, zindex, strokewidth, absxdif, linecolor, container, relname + " x-rn:" + intRouteNumber, bwlFindBest));
				bwlSkipExtra2e=true;
				bwlSkipExtra1e=true;
			}
			else if (x2<x1) //subject table is west of foreign table
			{
				x1=x1-offset1;
				x2=x2+(width2+offset2);
				bwlSkipExtra2=true;
				bwlSkipExtra1e=true;
				w=w-(width2+offset1+offset2);
				yx= ReturnLarger(y2, y1);
				y=y2;
				x=x2;
				if(y2==yx)
				{
					x=x1;
					y=y1;
				}
				overlaps=overlaps.concat(DrawDivLine(yx, x2, zindex, strokewidth, w, linecolor, container, relname + " x-rn:" + intRouteNumber, bwlFindBest));
			}
			else if (x1<x2) //subject table is east of foreign table
			{
				x2=x2-offset2;
				x1=x1+(width1+offset1);
				bwlSkipExtra1=true;
				bwlSkipExtra2e=true;
				w=w-(width1+offset1+offset2);
				y=ReturnSmaller(y2, y1);
				x=x1;
				overlaps=overlaps.concat(DrawDivLine(y2, x1, zindex, strokewidth, w, linecolor, container, relname + " x-rn:" + intRouteNumber, bwlFindBest));
			}
		 
			if(h!=0)//draw the vertical component of the relationship
			{
				overlaps=overlaps.concat(DrawDivLine(y, x, zindex, h, strokewidth, linecolor, container, relname + " y-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra1) 
			{//the short horizontal line coming to subject table from the west
		 		overlaps=overlaps.concat(DrawDivLine(y1, x1, zindex, strokewidth, offset1, linecolor, container, relname + " x1-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra2)
			{ //the short horizontal line coming to foreign table from the west
				overlaps=overlaps.concat(DrawDivLine(y2, x2, zindex, strokewidth, offset2, linecolor, container, relname + " x2-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra1e) 
			{//the short horizontal line coming to subject table from the east
		 		overlaps=overlaps.concat(DrawDivLine(y1, x1-offset1, zindex, strokewidth, offset1, linecolor, container, relname + " x1-rn:" + intRouteNumber, bwlFindBest));
			}
			if(!bwlSkipExtra2e) 
			{//the short horizontal line coming to foreign table from the east
				overlaps=overlaps.concat(DrawDivLine(y2, x2-offset2, zindex, strokewidth, offset2, linecolor, container, relname + " x2-rn:" + intRouteNumber, bwlFindBest));
				//alert(relname + " x2-rn:" + intRouteNumber);
			}
		}
	
		overlaps=removeArrayItem(overlaps, "");
		overlaps=removeArrayItem(overlaps, "iddiv-" + table1);
		overlaps=removeArrayItem(overlaps, "iddiv-" + table2);
		CollisionCounts[intRouteNumber]=overlaps.length;
		//alert(oldoverlaps + "\n\n" + overlaps + "\n\n" + "iddiv-" + table1 + "\n\n" + "iddiv-" + table2);
		intRouteNumber++;
	}
	//if(bwlFindBest)
	{
		if(bwlFindBest  && (CollisionCounts[0]>CollisionCounts[1]))
		{
			//delete  Route 0
			var killitem=document.getElementById(relname + " x2-rn:0");
			killitem.style.display='none';
			killitem=document.getElementById(relname + " x1-rn:0");
			killitem.style.display='none';
			killitem=document.getElementById(relname + " x-rn:0");
			killitem.style.display='none';
			killitem=document.getElementById(relname + " y-rn:0");
			killitem.style.display='none';
		}
		else
		{
			//delete  Route 1
			var killitem=document.getElementById(relname + " x2-rn:1");
			killitem.style.display='none';
			killitem=document.getElementById(relname + " x1-rn:1");
			killitem.style.display='none';
			killitem=document.getElementById(relname + " x-rn:1");
			killitem.style.display='none';
			killitem=document.getElementById(relname + " y-rn:1");
			if(killitem)
			{
				killitem.style.display='none';
			}
			
		}
	}
	if(CollisionCounts[0]>0 || CollisionCounts[1]>0)
	{
		//alert(CollisionCounts[0] +  " " + CollisionCounts[1] + "\n" + overlaps);
	}
}

function DrawDivLine(toppos, leftpos, zindex, height, width, color, container, name, bwlFindBest)
{
	var div=document.createElement('div');
	var MaxtoScan=7;//don't bother looking for overlaps on short segments
	div.style.fontSize="0px";
	div.style.padding="0px";
	div.style.margin="0px";
	div.style.border="0px";
	div.style.position="absolute";
	div.style.overflow="hidden";
	div.setAttribute("class", "rel");
	div.id=name;
	div.style.backgroundColor=color;
	//either ty/tx/ty/tx or oy/tx/ty/ox
	bwlMoveVertical=false;
	div.style.top=toppos;
	div.style.left=leftpos;
	//alert(width);
	if(width>0  )
	{
		div.style.width=width;
	}
	else if (width<1)
	{
		div.style.width=0;
	}
	div.style.height=height;
	div.style.zIndex=zindex;
	container.appendChild(div);
	if(bwlFindBest && height+width>MaxtoScan)
	{
		var overlaps=ScanExistingTablePlacementsAndReturnOverlaps(div);
		//alert(overlaps);
		return overlaps;
	}
 
	return;
	//var boundingrect=div.getBoundingClientRect(); 
	//alert(boundingrect.left);
}

function ScanExistingTablePlacementsAndReturnOverlaps(comparisonobject)
{
	var arrDivs=document.getElementsByTagName('div');
	//var ourboundingrect=comparisonobject.getBoundingClientRect(); 
	var collisioncount=0;
	var i;
	var out="";
	var arrOut=new Array();
	for(i=0; i<arrDivs.length; i++)
	{
		var thisdiv=arrDivs[i];
		var thisid=thisdiv.id;
		if (thisid.indexOf("iddiv")>-1)
		{
			//var alienboundingrect=thisdiv.getBoundingClientRect(); 
			if(DoesObj1CrossObj2(comparisonobject, thisdiv))
			{
				arrOut[collisioncount]=thisid;
				collisioncount++;
	 			
				
			}
		}
	}
 	//sweet debugging:
	//for(var j=0; j<arrOut.length; j++)
	//{
		//out+= arrOut[j] + "+\n";
	//}
	//alert(out + "\n" + collisioncount);
	return arrOut;
}

function DoesObj1CrossObj2(obj1, obj2)
{
	var out;
	var obj1width=parseInt(obj1.style.width);
	var obj2width=parseInt(obj2.offsetWidth);
	var obj1height=parseInt(obj1.style.height);
	var obj2height=parseInt(obj2.offsetHeight);
	var obj1top=AbsoluteOffset(obj1, "top");
	var obj2top=AbsoluteOffset(obj2, "top");
	var obj1left=AbsoluteOffset(obj1, "left");
	var obj2left=AbsoluteOffset(obj2, "left");
	var obj1right=obj1left + obj1width;
	var obj2right=obj2left + obj2width;
	var obj1bottom=obj1top + obj1height;
	var obj2bottom=obj2top + obj2height;
	//alert(obj1top + "\n" + obj2top + "\n" + obj1bottom + "\n" + obj2bottom + "\n" + obj1left + "\n" + obj2left + "\n\n" + obj1right + "\n" + obj2right +  "\n\n" + obj1width + "\n" + obj2width + "\n" + obj1height + "\n" + obj2height + "\nobj2:" + obj2.id + "\nobj1:" + obj1.id);
	//simple rectangle collision algorithm:
	if(obj1bottom<obj2top)
	{
		out= false;
	}
	else if(obj1top>obj2bottom)
	{
		out=  false;
	}
	else if(obj1right<obj2left)
	{
		out=  false;
	}
	else if(obj1left>obj2right)
	{
		out=  false;
	}
	else
	{
		out=  true;
	}
	return out;
}

function RedrawATableRelations(id)
{
	var arrID=id.split("-");
	var thistable=arrID[1];
	var arrData=relationshipdata.split("|");
	var relationsubdata="";
	for(i=0; i<arrData.length; i++)
	{
		arrThis=arrData[i].split(" ");
		rtable=arrThis[0];
		fktable=arrThis[2];
		if(fktable==thistable  || rtable==thistable)
		{
			relationsubdata+=arrData[i] + "|";
		}
	}
}

function MapSave()
{
	var arrDivs=document.getElementsByTagName('div');
	var out="";
	for(i=0; i<arrDivs.length; i++)
	{
		var thisdiv=arrDivs[i];
		var thisid=thisdiv.id;
		if (thisid.indexOf("iddiv")>-1)
		{
			var arrthis=thisid.split("-");
			var tablename=arrthis[1];
			var top=AbsoluteOffset(thisdiv, "top");
			var left=AbsoluteOffset(thisdiv, "left");
			out+=tablename + " " + top + " " + left + "|";
		}
	}
	document.BForm[qpre + "relationshipdata"].value=relationshipdata; //put any new realtions in the form to be added by the backend
	document.BForm[qpre + "positions"].value=out;
	
	//alert(document.BForm[qpre + "positions"].value);
}

function RemoveTable(tablename)
{
	var deletes=document.BForm[qpre + "tabledeletes"].value;
	if(!genericInList(deletes, tablename, " "))
	{
		deletes+=tablename + " ";
		var divname="iddiv-" + tablename;
		var thisdiv=document.getElementById(divname);
		//alert(thisdiv);
		var thisParent=GetParent(thisdiv);
		thisParent.removeChild(thisdiv);
		document.BForm[qpre + "tabledeletes"].value=deletes;
		//alert(document.BForm[qpre + "tabledeletes"]);
	}
}

function RemoveUnrelatedTables()
{
	var arrDivs=document.getElementsByTagName('div');
	var out="";
	var arrData=relationshipdata.split("|");
	var bwlLinked=false;
	var divcount;
	var j;
	var delcount=0;
	var todelete=new Array();
	var deletes="";
	for(divcount=0; divcount<arrDivs.length; divcount++)
	{
		var thisdiv=arrDivs[divcount];
		var thisid=thisdiv.id;
		bwlLinked=false;
		var tablename="";
		if (thisid.indexOf("iddiv")>-1)
		{
			var arrthis=thisid.split("-");
			tablename=arrthis[1];
			for(j=0; j<arrData.length; j++)
			{
				arrThis=arrData[j].split(" ");
				rtable=arrThis[0];
				fktable=arrThis[2];
				if(fktable==tablename  || rtable==tablename)
				{
					bwlLinked=true;
				}
			}
			if(!bwlLinked)
			{
				//alert(tablename);
				//thisdiv.style.display='none';
				todelete[delcount]= thisdiv;
				delcount++;
				deletes+=tablename + " ";
			}
		}
		
	}
	//i have to get a list of items to delete and then delete them later
	//otherwise it seems the DOM collapses down with each deletion
	//and i only delete every other table i want to delete
	for(j=0; j<todelete.length; j++)
	{
		thisdiv=todelete[j];
		//alert(thisdiv.id);
		var thisParental= GetParent(thisdiv);
		if(thisParental)
		{
			thisParental.removeChild(thisdiv);
		}
	}
	document.BForm[qpre + "tabledeletes"].value=deletes;
	 
}

//dont use actually
function RemoveTableFromPositionData(tablein)
{
	var arrDivs=positiondata.split("|");
	var out="";
	for(i=0; i<arrDivs.length; i++)
	{
		
		var thisinfo=arrDivs[i].split(" ");
		var tablename=thisinfo[0];
		
		if(tablein!=tablename)
		{
			out+=arrDivs[i] + "|";
		}
	}
	positiondata=out;
}

function mouseMove(ev)
{ 
	ev = ev || window.event; 
	var mousePos = mouseCoords(ev); 
} 

//tracks mouse position to provide animation of the new relation line as one is dragging
function mouseCoords(ev)
{ 
	if(ev.pageX || ev.pageY)
	{ 
		var thisx=ev.pageX;
		var thisy=ev.pageY;
	}
	else
	{
		var thisx=ev.clientX + document.body.scrollLeft;
		var thisy= ev.clientY + document.body.scrollTop;
	
	}
	globalx=thisx;
	globaly=thisy;
	var i;
	var mapname="idmap";
	var relname="workle";
	var xtouse=globalx;
	if(globalidstart!="")
	{
		var sourceobj=document.getElementById(globalidstart);
		var nwidth=sourceobj.offsetWidth;
		var ysource=getOffsetTop(sourceobj);
		var xsource=getOffsetLeft(sourceobj);
		var killrelname=relname + (globallineanimationframecount-1);
		for(i=0; i<3; i++)
		{
			var killitem=document.getElementById(killrelname + " x2-rn:" + i + "");
			if(killitem)
			{
				killitem.style.display='none';
				killitem=document.getElementById(killrelname + " x1-rn:" + i + "");
				killitem.style.display='none';
				killitem=document.getElementById(killrelname + " x-rn:" + i + "");
				killitem.style.display='none';
				killitem=document.getElementById(killrelname + " y-rn:" + i + "");
				killitem.style.display='none';
			}
		}
		if(globalidhovering!='')
		{
			var thisitem=document.getElementById(globalidhovering);
			xtouse=AbsoluteOffset(thisitem, "left");
		}
		//DrawRelationship(x1in, y1in, x2in, y2in, relname, location, width1, width2, disp1, disp2, linecolor, intThisRouteNumber, downoffset, vdispfactor)
		DrawRelationship(xsource, ysource, xtouse, globaly, relname + globallineanimationframecount, mapname, nwidth, globaloverwidth,0, 0, "000000", -1, 0, 0, -1);
		globallineanimationframecount++;
	}

	return;
} 

//handles relationship creation at the start of a mouse drag
function mrstart(id)
{ 
 
	document.body.style.cursor='pointer';
	document.onselectstart = new Function ("return false");

	var thisitem=document.getElementById(id);
	globalprevbg=thisitem.style.background;
	thisitem.style.background='#' + ColorSaturate(startrelationcolor, "ff");
	globalidstart=id;
	globalBwlMakingRelation=true;
	globalidhovering='';
	globalsavedx=globalx;
	globalsavedy=globaly;
	//alert("#" + globalidstart);
	setTimeout('popupcolumndialog("' + id + '");',700); 
}



//handles relationship creation at the end of a mouse drag
function mrdone(id)
{ 
	var container=document.body;
	//alert(globalpopupmode + "*" + id);
	var thisitem=document.getElementById("idmapdialog");
	if(!id && globalpopupmode=="")
	{
		if(thisitem)
		{
			container.removeChild(thisitem);
			globalpopupmode="";
		}
	}
	if(globalpopupmode=="delete"  && !id)
	{
		//var container=document.getElementById("idmap");
		//alert("F");
		if(thisitem)
		{
			container.removeChild(thisitem);
			globalpopupmode="";
		}
		return deleterelation(globalidforpopup);
	}
	else if(globalpopupmode=="edit"  && !id)
	{
		//var container=document.getElementById("idmap");
		if(thisitem)
		{
			container.removeChild(thisitem);
			globalpopupmode="";
		}
		return editrelation(globalidforpopup);
	}
	if(id  && id!=globalidstart)
	{
		
		var thisitem=document.getElementById(globalidstart);
		//thisitem.style.background='#ffff00';
		var arrStart=globalidstart.split("-");
		var arrEnd=id.split("-");
		var strToAddToRelationshipData=arrStart[1] + " " + arrStart[2]  + " " + arrEnd[1] + " " + arrEnd[2];
		if(!genericInList(relationshipdata, strToAddToRelationshipData, "|")) //don't allow the creation of duplicate relations
		{
			relationshipdata=AddToConfigStringIfNotThere(relationshipdata, strToAddToRelationshipData, "|");
		}
	}
	else
	{	
		var thisitem=document.getElementById(globalidstart);
		if(thisitem)
		{
			thisitem.style.background='';
		}
	}
	globalidhovering='';
	if(globalidstart!="")
	{
		globalidforpopup=globalidstart;
	}
	globalidstart="";
	globalBwlMakingRelation=false;
	drawrelationships(relationshipdata);
	//document.bgColor='';
	globallineanimationframecount=0;
}

//handles relationship creation while a drag is in process across a linkable column name
function mrdrag(id)
{ 
	document.body.style.cursor='pointer';
	if(globalBwlMakingRelation  && id!=globalidstart)
	{
		var thisitem=document.getElementById(id);
		globalprevbg=thisitem.style.backgroundColor;
		globaloverwidth=thisitem.offsetWidth;
		//alert(thisitem.style.background);
		thisitem.style.backgroundColor='#' + ColorSaturate(endrelationcolor, "ff");
		globalidhovering=id;
		//alert("-" + globalprevbg);
		//alert(thisitem.style.background);
	}


}

//handles relationship creation when a drag goes off of a linkable column name
function mrdragno(id)
{ 

	if(globalBwlMakingRelation  && id!=globalidstart)
	{
		var thisitem=document.getElementById(id);
		globaloverwidth=0;
		globalidhovering='';
		//alert(globalprevbg);
		//alert("+" + globalprevbg);
		thisitem.style.backgroundColor=globalprevbg;
	}
}

function popuptabledialog(id)
{
	
	var arrAnchortext= new Array('edit definition', 'view data', 'remove table from map', 'change color');
	var arrLink= new Array
		(
		'javascript:edittable("' + id + '","schema")',
		'javascript:edittable("' + id + '","data")',
		'javascript:edittable("' + id + '","remove")',
		'javascript:edittable("' + id + '","changecolor")'
		)
	PopupMenuAtMousePosition(arrAnchortext, arrLink, "idmapdialog", "onmouseup");
}

function popupcolumndialog(id)
{
	//alert(id);
	if(globalsavedx==globalx  && globalsavedy==globaly)
	{ 
		var arrThisEnd=id.split("-");
		var arrMatch=new Array(arrThisEnd[1], arrThisEnd[2]);
		var arrFound=ScanConfigForMatchOnMultipleItems(arrMatch, relationshipdata,"|", " ");
		var arrAnchortext= new Array('delete relation', 'relation info');
		if(arrFound)
		{
			var arrLink= new Array('javascript:globalpopupmode="delete"', 'javascript:globalpopupmode="edit"')
			PopupMenuAtMousePosition(arrAnchortext, arrLink, "idmapdialog");
		}
		
	}
}

function PopupMenuAtMousePosition(arrAnchortext, arrLink, id, actiontype)
{
	//alert(id);
	//alert(document.onmousemove + "\n\n" + document.onmousdedown);
	PopupMenuAtPosition(arrAnchortext, arrLink, id, globalx, globaly, 120,  "cccccc", actiontype)
}

function deleterelation(id)
{
	//alert(id);
	var delimiter="|";
	var arrEndOfRelation=id.split("-");
	arrMatch=Array(arrEndOfRelation[1], arrEndOfRelation[2]);
	var thisMatch=ScanConfigForMatchOnMultipleItems(arrMatch, relationshipdata,delimiter , " ");
	if(thisMatch)
	{
		if(confirm("Are you certain you want to delete this relation?"))
		{
	
				var strToRemoveFromRelationshipData=thisMatch[0] + " " + thisMatch[1]  + " " + thisMatch[2] + " " + thisMatch[3];
				relationshipdata=DeleteFromConfigString(relationshipdata, strToRemoveFromRelationshipData, delimiter);
				var relationdeletes=	document.BForm[qpre + "relationdeletes"].value;
				relationdeletes=AddToConfigStringIfNotThere(relationdeletes, strToRemoveFromRelationshipData, delimiter);
				document.BForm[qpre + "relationdeletes"].value=relationdeletes; //put any new realtions in the form to be added by the backend
				var thisitem=document.getElementById(id);
				thisitem.style.backgroundColor='';
				drawrelationships(relationshipdata);//redraw map
		}
	}
}

function editrelation(id)
{
	//relationshipiddata
	//alert(id);
	var arrID=id.split("-");
	var thistable=arrID[1];
	var thiscolumn=arrID[2];
	var rowdelimiter="|";
	//alert(relationshipiddata);
	var thisrid=genericdata(thistable + "~" + thiscolumn,0, 1, relationshipiddata, rowdelimiter, " ")
	globalidforpopup="";
	if(thisrid=="")
	{
		arrMatch=Array(arrID[1], arrID[2]);
		var thisMatch=ScanConfigForMatchOnMultipleItems(arrMatch, relationshipdata,rowdelimiter , " ");
		if(thisMatch)
		{
			editselected("", "tf.php?" + qpre + "mode=edit&" + qpre + "table=" + tfpre + "relation&" +qpre + "idfield=relation_id&table_name=" + thisMatch[0] + "&column_name=" + thisMatch[1] + "&f_table_name=" + thisMatch[2] + "&f_column_name=" + thisMatch[3] + "&relation_type_id=0&" + qpre + "db=" + database);
		}
	}
	else
	{
	
	editselected("", "tf.php?" + qpre + "mode=edit&" + qpre + "table=" + tfpre + "relation&" +qpre + "idfield=relation_id&relation_id=" + thisrid + "&" + qpre + "db=" + database);
	}
}

function edittable(id, thistype)
{
	globalidforpopup="";
	var arrTable=id.split("-")
	var thistable=arrTable[1];
	//alert(database);
	if(!database)
	{
		database="";
	}
	if(thistype=="data")
	{
		editselected("", "tf.php?" + qpre + "mode=view&" + qpre + "table=" + thistable + "&" + qpre + "db=" + database)
	}
	else if(thistype=="remove")
	{
		//alert(id);
		var tablename=id.split("-")[1];
		//alert(tablename);
		RemoveTable(tablename);
	}
	else if(thistype=="changecolor")
	{
		//alert(id);
		var tablename=id.split("-")[1];
		//alert(tablename);
		//ChangeTableColor(tablename, "ffff00");
		ColorPicker('ChangeTableColor(opener,"' + tablename + '"');
	}
	else
	{
		editselected("", "tf_table_maker.php?" + qpre + "table=" + thistable + "&" + qpre + "db=" + database)
	}
	//alert("Not yet implemented." + id);
}

document.onmousemove = mouseMove; 

//set positions from saved data
if(typeof(positiondata)!= "undefined")
{
	//alert( positiondata);
	var arrDivs=positiondata.split("|");
	for(i=0; i<arrDivs.length; i++)
	{
		
		var thisinfo=arrDivs[i].split(" ");
		var tablename=thisinfo[0];
		var top=thisinfo[1];
		var left=thisinfo[2];
		if(tablename!="")
		{
			//alert("iddiv-" + tablename + "-") ;
			var thisdiver=document.getElementById("iddiv" + "-" +  tablename);
			if(thisdiver)
			{
				//alert('ssssss iddiv-' + tablename);
				if(!isNaN(left)  && left>-1)
				{
					thisdiver.style.left=left;
				}
				else
				{
					thisdiver.style.left=0;
				}
				thisdiver.style.top=top;
				
			}
		}
	}
	drawrelationships(relationshipdata);
}

function ChangeTableColor(winobj, tablename, newcolorbasis)
{
	var i, j, k;
	var divname="iddiv-" + tablename;
	var thisdiv=winobj.document.getElementById(divname);
	thischildren=thisdiv.childNodes;
	//thisdiv.class='';
	var firstcolorbasis=newcolorbasis;
	var secondcolorbasis=ColorSaturate(newcolorbasis, "11");
	var thiscolorbasis=firstcolorbasis;
	for(i=0; i<thischildren.length; i++)
	{
		var thistag=thischildren[i];
		if(thistag.nodeName=="TABLE")
		{
			thisinnerchildren=thistag.childNodes;
			for(j=0; j<thisinnerchildren.length; j++)
			{
				 
				var thisinnertag=thisinnerchildren[j];
				//alert(thisinnertag.nodeName);
				if(thisinnertag.nodeName=="TBODY")
				{
				
					thisinnerinnerchildren=thisinnertag.childNodes;
					for(k=0; k<thisinnerinnerchildren.length; k++)
					{
						var thisinnerinnertag=thisinnerinnerchildren[k];
						if(thisinnerinnertag.nodeName=="TR")
						{
							//alert("@");
							//thisinnerinnertag.class='';
							if(thiscolorbasis==firstcolorbasis)
							{
								thiscolorbasis=secondcolorbasis;
								
							}
							else
							{
								thiscolorbasis=firstcolorbasis;
							}
							thisinnerinnertag.style.backgroundColor='#' +  thiscolorbasis;
						}
					}
				}
			}
		}
	}
	//thisdiv.style.outlineColor='#' + newcolorbasis;
	
}

function recolorfound()
{
	var i;
	var tagarray=opener.document.getElementsByTagName("TABLE");
	var searchterm=document.BForm.search.value;
	//var newcolor=document.BForm.search.style.backgroundColor;
	var newcolor=g_localcolor;
	if(newcolor.indexOf("#")>-1)
	{
		newcolor=newcolor.substr(1);
	}
	//alert(newcolor);
	for(i=0; i<tagarray.length; i++)
	{
		var thistag=tagarray[i];
		var thisid=thistag.id;
		if(thisid.indexOf("idtable")>-1)
		{
			thistablename=thisid.substr(7);
			if(thistablename.indexOf(searchterm)>-1)
			{
				ChangeTableColor(opener, thistablename, newcolor)
			}
		
		}
	}
	//alert("recolorfound!");
}

//initial drawing of relationships (all relations are drawn by javascript;  php just creates the div info telling them where to attach).
if(relationshipdata!='') //i had to put this on a delay for certain cases cropping up with internet explorer
{
	setTimeout('drawrelationships(\"" + relationshipdata + "\");',200);
	
}

document.onmouseup=  new Function ("return mrdone()"); 