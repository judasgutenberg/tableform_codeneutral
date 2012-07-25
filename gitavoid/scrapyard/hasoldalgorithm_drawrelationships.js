

function getOffsetTop (el)
{
	var ot = el.offsetTop;
	while ( ( el = el.offsetParent ) != null )
	{
		ot += el.offsetTop;
	}
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

function AbsoluteOffset(obj, offsettype)
{
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

//var cnv = document.getElementById("idmap");
//var jg = new jsGraphics(cnv);
 
function drawrelationships(relationshipdata, specialreference)
{
	var out="\n";
	var linecolors="666699 990099 000000 0000ff 77aa77 ff0000"; 
	var arrlinecolor=linecolors.split(" ");
	var intlinecolorcursor=0;
	//alert(relationshipdata);
	var arrRdata=relationshipdata.split("|");
	//alert(relationshipdata);
 	var mapname="idmap";
	//alert(arrRdata.length);
	//for(i=0; i<arrRdata.length; i++)
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
			else
			{
				//alert(endnonfk);
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
				out+= x1  + "\n" + y1 + "\n" + x2 + "\n" + y2 + "\n" +arrRdata[i]+ "\n\n\n";
				DrawRelationship(parseInt(x1),parseInt( y1),parseInt(x2) , parseInt(y2), "idrelationship " + arrRdata[i], mapname, specialreference, nwidth, fwidth, tablelist[thistable], ftablelist[thisfktable], linecolor);
				intlinecolorcursor++;
				if(intlinecolorcursor==arrlinecolor.length)
				{
					intlinecolorcursor=0;
				}
			}
	
	 
		}
		
	}
	//DrawRelationship(540,272,579 , 440, "idrelationship xx", mapname);
 
	
 
	//alert(out);
}

var xcount;

function ClearRelations(location)
{

	//alert(location);
	var container = document.getElementById(location);
	container.innerHTML="";
	return;

}

function xDrawRelationship(x1, y1, x2, y2, relname, location, specialreference, nwidth, fwidth, ndisp, fdisp, linecolor)
{
	//this was my original algorithm - messier and harder to read but perhaps a bit more concise;

	var leftoffset=10;
	var downoffset=12;
	var avoidanceconstant=150;
	var out="";
	var oldx1=x1;
	var oldx2=x2;
	//alert(nondisp + " " + fkdisp);
	noffset=leftoffset+ 1 * ndisp;
	foffset=leftoffset + 1 * fdisp;
	nvoffset=-downoffset + leftoffset+ ndisp;
	fvoffset=-downoffset  + leftoffset +  fdisp;
	nwidth=nwidth+noffset;
	fwidth=fwidth+foffset;
	x1=x1-noffset;
	x2=x2-foffset;
	y1=y1-nvoffset;
	y2=y2-fvoffset;
	var zindex=1;
	var w=parseInt(Math.abs(x1-x2));
	var h=parseInt(Math.abs(y1-y2));
	var tx=x1;
	var ox=x2;
	var bwlxSwap=false;
	var bwlySwap=true;
	if(x1>x2 )
	{
		tx=x2;
		ox=x1
		bwlxSwap=true;
	}
	var ty=y1;
	var oy=y2;
	if(y1>y2)
	{
		ty=y2;
		oy=y1;
		bwlySwap=false;
	}
	var strokewidth=1;
	var container = document.getElementById(location);
	var tyfory=ty;
	if(bwlxSwap)
	{
		ty=oy;
	}
	var txfory="";
	bwlSkipExtra1=false;
	bwlSkipExtra2=false;
 	if(x2==tx  && y2==ty )
	{
		tx=tx+fwidth;
		w=w-fwidth;
		bwlSkipExtra2=true;
	}
	if(x1==tx  && y1==ty )
	{
		tx=tx+nwidth;
		w=w-nwidth;
		bwlSkipExtra1=true;
	}
	//don't even ask what these numbers stand for
	//it all grew cowboy style out of trial and error
	yspecialfactor=0;
	xspecialfactor=0;
	if(w<1   )
	{
		var specialwidth=nwidth;
		var diftodeal=0;
		if(fwidth>nwidth)
		{
			specialwidth=fwidth;
			diftodeal=fwidth-nwidth;
		}
		specialwidth=specialwidth+foffset;
		var inw=w;
		xavoidsize=specialwidth+w-foffset;
		if(Math.abs(y1-y2)>avoidanceconstant)
		{
			yavoidsize=avoidanceconstant;//Math.abs(y1-y2);
		}
		else
		{
			yavoidsize=Math.abs(y1-y2);
			yspecialfactor=yavoidsize;
			
			
		}
		w=xavoidsize;
		tx=ox-xavoidsize;
		h=h-yavoidsize;
		
		DrawDivLine(tyfory+h, tx , zindex, yavoidsize, strokewidth, linecolor, container, relname + " yavoid");
		//tx=tx-200;
		//x2=x2-200;
		//x1=x1-200;
		if(x1>x2)
		{
			yspecialfactor=0;
			//xspecialfactor=x2-x1;
		}
		else
		{
			xspecialfactor=x1-x2 + foffset;
		}
		if(ty<tyfory+h)
		{
			DrawDivLine(tyfory, tx, zindex, strokewidth, w-(Math.abs(x1-x2)), linecolor, container, relname + " xavoid");//line at the top when a table is under another in a relationship
			ty=tyfory+h+yavoidsize;
			//drawdivlineextra=100;
			txfory=tx;
			bwlSkipExtra1=false;
		}
		else
		{
			DrawDivLine(tyfory+h, tx, zindex, strokewidth, xavoidsize+xspecialfactor, linecolor, container, relname + " xavoid");
			w=foffset + x2- tx;
		}
		//w=xavoidsize+inw;
	}
		
	DrawDivLine(ty + yspecialfactor, tx, zindex, strokewidth, w, linecolor, container, relname + " x");//horizontal conventional line
	if(bwlySwap)
	{
	
		tx=ox;
	}
	if(txfory!="")
	{
		tx=txfory;
	}
	DrawDivLine(tyfory, tx, zindex, h, strokewidth, linecolor, container, relname + " y");//vertical conventional line
 
	if(!bwlSkipExtra1)
	{
 		DrawDivLine(y1, x1, zindex, strokewidth, noffset, linecolor, container, relname + " xx");
	}

	if(!bwlSkipExtra2)
	{
		DrawDivLine(y2, x2, zindex, strokewidth, foffset, linecolor, container, relname + " xy");
	}
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

function DrawRelationship(x1, y1, x2, y2, relname, location, specialreference, width1, width2, disp1, disp2, linecolor)
{
	//alert(relname);
	var leftoffset=10;
	var downoffset=-12;
	var out="";
	offset1=leftoffset+ 1 * disp1;
	offset2=leftoffset + 1 * disp2;
	voffset1=downoffset+ 1 * disp1;
	voffset2=downoffset+ 1 * disp2;
	var zindex=1;
	var w=parseInt(Math.abs(x1-x2));
	var strokewidth=1;
	var container = document.getElementById(location);
	var zindex=12;
	var bwlSkipExtra1=false;
	var bwlSkipExtra2=false;
	var bwlSkipExtra1e=false;
	var bwlSkipExtra2e=false;
	var absxdif=Math.abs(x1-x2)  + disp1 + disp2;
	var largeroffset=ReturnLarger(offset1, offset2);
	var offsetsum=offset1 + offset2;
	y1=y1-voffset1;
	y2=y2-voffset2;
	var h=parseInt(Math.abs(y1-y2));
	if(y1<y2  && (absxdif< (width1 + offsetsum)|| absxdif< (width2 + offsetsum)))
	{
		//type1="north";
		//type2="south";
		x1=x1-offset1;
		x2=x2-offset2;
		
		x=ReturnSmaller(x1, x2);
		yx=y2;
		if(x==x2)
		{
			yx=y1;
		}
		bwlSkipExtra2e=true;
		bwlSkipExtra1e=true;
		DrawDivLine(yx, x, zindex, strokewidth, absxdif, linecolor, container, relname + " x");
		DrawDivLine(y1, x, zindex, h, strokewidth, linecolor, container, relname + " y");
		//no width!
	}
	else if(y2<y1 && (absxdif< (width1+ offsetsum) || absxdif< (width2+ offsetsum)))
	{
		//type1="south";
		//type2="north";
		x1=x1-offset1;
		x2=x2-offset2;
		x=ReturnSmaller(x1, x2);
		yx=y2;
		if(x==x2)
		{
			yx=y1;
		}
		bwlSkipExtra2e=true;
		bwlSkipExtra1e=true;
		DrawDivLine(yx, x, zindex, strokewidth, absxdif, linecolor, container, relname + " x");
		DrawDivLine(y2, x, zindex, h, strokewidth, linecolor, container, relname + " y");
		//no width!
	}
	else if (x1<x2  && y1<y2)
	{
		//type1="northwest";
		//type2="southeast";
		x2=x2-offset2;
		x1=x1+(width1+offset1);
		bwlSkipExtra1=true;
 		bwlSkipExtra2e=true;
		w=w-(width1+offset1+offset2);
		DrawDivLine(y1, x1, zindex, h, strokewidth, linecolor, container, relname + " y");
		DrawDivLine(y2, x1, zindex, strokewidth, w, linecolor, container, relname + " x");
	}
	else if (x2<x1  && y1<y2)
	{
		//type1="northeast";
		//type2="southwest";
		x1=x1-offset1;
		x2=x2+(width2+offset2);
		bwlSkipExtra2=true;
		bwlSkipExtra1e=true;
		w=w-(width2+offset1+offset2);
		DrawDivLine(y1, x1, zindex, h, strokewidth, linecolor, container, relname + " y");
		DrawDivLine(y2, x2, zindex, strokewidth, w, linecolor, container, relname + " x");
	}
	else if (x2<x1  && y2<y1)
	{
		//type1="southeast";
		//type2="northwest";
		x1=x1-offset1;
		x2=x2+(width2+offset2);
		bwlSkipExtra2=true;
		bwlSkipExtra1e=true;
		w=w-(width2+offset1+offset2);
		DrawDivLine(y2, x2, zindex, h, strokewidth, linecolor, container, relname + " y");
		DrawDivLine(y1, x2, zindex, strokewidth, w, linecolor, container, relname + " x");
	}
	else if (x1<x2  && y2<y1)
	{
		//type1="southwest";
		//type2="northeast";
		x2=x2-offset2;
		x1=x1+(width1+offset1);
		bwlSkipExtra1=true;
		bwlSkipExtra2e=true;
		w=w-(width1+offset1+offset2);
		DrawDivLine(y2, x1, zindex, h, strokewidth, linecolor, container, relname + " y");
		DrawDivLine(y2, x1, zindex, strokewidth, w, linecolor, container, relname + " x");
	}
	else if(x1<x2)
	{
		//type1="west";
		//type2="east";
		x2=x2-offset2;
		bwlSkipExtra1=true;
		bwlSkipExtra2e=true;
		x1=x1+(width1+offset1);
		w=w-(width1+offset1+offset2);
		DrawDivLine(y1, x1, zindex, strokewidth, w, linecolor, container, relname + " x");
		//no height!
	}
	else if(x2<x1)
	{
		//type1="east";
		//type2="west";
		x1=x1-offset1;
		bwlSkipExtra2=true;
		bwlSkipExtra1e=true;
		x2=x2+(width2+offset2);
		w=w-(width2+offset1+offset2);
		DrawDivLine(y1, x2, zindex, strokewidth, w, linecolor, container, relname + " x");
		//no height!
	}
	else
	{
		//type1="same";
		//type2="same";
		x1=x1-offset1;
		x2=x2-offset2;
		bwlSkipExtra1=true;
		bwlSkipExtra2=true;
		bwlSkipExtra2e=true;
		bwlSkipExtra1e=true;
		//no height/no width
		//no line needed!
	}
	if(!bwlSkipExtra1)
	{
 		DrawDivLine(y1, x1, zindex, strokewidth, offset1, linecolor, container, relname + " x1");
	}
	if(!bwlSkipExtra2)
	{
		DrawDivLine(y2, x2, zindex, strokewidth, offset2, linecolor, container, relname + " x2");
	}
	if(!bwlSkipExtra1e)
	{
 		DrawDivLine(y1, x1-offset1, zindex, strokewidth, offset1, linecolor, container, relname + " x1");
	}
	if(!bwlSkipExtra2e)
	{
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
	//id=\"iddiv-" .  $strTable . "\"
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
	//alert(document.BForm[qpre + "positions"].value);
	//return false;
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