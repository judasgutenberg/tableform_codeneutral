
function getxxOffsetTop(element)
{/* Calculate the offsetTop sum of all
offsetParents.
The result is element.style.top
*/
	if(!element) return 0;
	return element.offsetTop + getOffsetTop(element.offsetParent);
}

function getxxOffsetLeft(element)
{/* Calculate the offsetLeft sum of all offsetParents.
The result is element.style.left
*/
	if(!element) return 0;
	return element.offsetLeft + getOffsetLeft(element.offsetParent);
}

function getOffsetTop (el)
{
	var ot = el.offsetTop;
	while ( ( el = el.offsetParent ) != null )
	{
		//alert(el.id);
		
		ot += el.offsetTop;
		
	}
	//alert(ot );
	return ot;
}


function getOffsetLeft (el)
{
	
	var ot = el.offsetLeft;
 
	while ( ( el = el.offsetParent ) != null )
	{
		ot += el.offsetLeft;
	}
	return ot;
}
//-170, -20
function AbsoluteOffset(obj, offsettype)
{
	//if(obj)
	//{
	//if(obj.offsetParent )
	//{
		//thisparent= obj.offsetParent ;
		//thisparent= thisparent.offsetParent ;
		//thisparent= thisparent.offsetParent ;
		//alert( getOffsetTop(thisparent) + " " +  getOffsetLeft(thisparent));
	//}
	//}
	if(obj)
	{
		if(offsettype=="top")
		{
			 
			var out=getOffsetTop(obj);
		}
		else
		{
			var out=getOffsetLeft(obj);
		}
	
		return parseInt(out);
	}
} 

function drawrelationships(relationshipdata, specialreference)
{
	var linecolors="666699 990099 000000 0000ff 77aa77 ff0000"; 
	var arrlinecolor=linecolors.split(" ");
	var intlinecolorcursor=0;
	var arrRdata=relationshipdata.split("|");
 	var mapname="idmap";
	var tablelist=Array();
	var ftablelist=Array();
	ClearRelations(mapname);
	for(i=0; i<arrRdata.length; i++)
	{
		if(arrRdata[i])
		{
			var arrthis=arrRdata[i].split(" ");
			var thistable=arrthis[0];
			var thiscolumn=arrthis[1];
			var thisfktable=arrthis[2];
			var thisfkcolumn=arrthis[3];
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
			var endnonfk=document.getElementById(idendnonfk);
			var endfk=document.getElementById(idendfk);
			
			if(endnonfk)
			{
				if(endnonfk.style.backgroundColor!="ff9999")
				{
					endnonfk.style.backgroundColor="ff9999";
				}
				else
				{
					endnonfk.style.backgroundColor="ff99ff";
				}
			}
			if(endfk)
			{
				if(endfk.style.backgroundColor!="9999ff")
				{
					endfk.style.backgroundColor="9999ff";
				}
				else
				{
					endfk.style.backgroundColor="ff99ff";
				}
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
			if(x1>0  && y1>0  && x2>0  && y2>0)
			{
				linecolor=arrlinecolor[intlinecolorcursor];
				DrawRelationship(parseInt(x1),parseInt( y1),parseInt(x2) , parseInt(y2), "idrelationship " + arrRdata[i], mapname, nwidth, fwidth, tablelist[thistable], ftablelist[thisfktable], linecolor);
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

function DrawRelationship(x1, y1, x2, y2, relname, location, width1, width2, disp1, disp2, linecolor)
{
	var zindex=12;
	var strokewidth=1;
	var leftoffset=10;
	var downoffset=-1;
 
	if(document.all)
	{
		var downoffset=18; //god i hate internet explorer!
	}
	var dispfactor=2;
	var x, y, yx;
	//I had been breaking the disps up but now I'm trying it without that.
	//disp1=disp2+disp1;
	//disp2=disp1;
	offset1=leftoffset+ dispfactor * disp1;
	offset2=leftoffset + dispfactor * disp2;
	voffset1=downoffset+ dispfactor * disp1;
	voffset2=downoffset+ dispfactor * disp2;
	var w=parseInt(Math.abs(x1-x2));
	var container = document.getElementById(location);
	var bwlSkipExtra1=false;
	var bwlSkipExtra2=false;
	var bwlSkipExtra1e=false;
	var bwlSkipExtra2e=false;
	
	var offsetsum=offset1 + offset2;
	y1=y1-voffset1;
	y2=y2-voffset2;
	var widthofeasternmost=width1;
	var offseteasternmost=offset1;
	if(x2<x1)
	{
		widthofeasternmost=width2; //allows me to make an ideal transition from north/south to east/west mode
		offseteasternmost=offset2;
	}
	var absxdif=Math.abs(x1-x2)  + offseteasternmost;
	var h=parseInt(Math.abs(y1-y2));
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
		DrawDivLine(yx, x, zindex, strokewidth, absxdif, linecolor, container, relname + " x");
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
		DrawDivLine(yx, x2, zindex, strokewidth, w, linecolor, container, relname + " x");
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
		DrawDivLine(y2, x1, zindex, strokewidth, w, linecolor, container, relname + " x");
	}
 
	if(h!=0)//draw the vertical component of the relationship
	{
		DrawDivLine(y, x, zindex, h, strokewidth, linecolor, container, relname + " y");
	}
	if(!bwlSkipExtra1) 
	{//the short horizontal line coming to subject table from the west
 		DrawDivLine(y1, x1, zindex, strokewidth, offset1, linecolor, container, relname + " x1");
	}
	if(!bwlSkipExtra2)
	{ //the short horizontal line coming to foreign table from the west
		DrawDivLine(y2, x2, zindex, strokewidth, offset2, linecolor, container, relname + " x2");
	}
	if(!bwlSkipExtra1e) 
	{//the short horizontal line coming to subject table from the east
 		DrawDivLine(y1, x1-offset1, zindex, strokewidth, offset1, linecolor, container, relname + " x1");
	}
	if(!bwlSkipExtra2e) 
	{//the short horizontal line coming to foreign table from the east
		DrawDivLine(y2, x2-offset2, zindex, strokewidth, offset2, linecolor, container, relname + " x2");
	}
}



function DrawDivLine(toppos, leftpos, zindex, height, width, color, container, name)
{
	var div=document.createElement('div');
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
}

drawrelationships(relationshipdata);

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
	document.BForm[qpre + "positions"].value=out;
}



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