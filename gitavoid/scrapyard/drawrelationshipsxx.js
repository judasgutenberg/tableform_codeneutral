

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
 
function drawrelationships(relationshipdata)
{
	var out="\n";
	//alert(relationshipdata);
	var arrRdata=relationshipdata.split("|");
	//alert(relationshipdata);
 	var mapname="idmap";
	//alert(arrRdata.length);
	//for(i=0; i<arrRdata.length; i++)
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
			var endnonfk=document.getElementById(idendnonfk);
			var endfk=document.getElementById(idendfk);
			
			if(endnonfk)
			{
				endnonfk.style.backgroundColor="ffff99";
			}
			else
			{
				//alert(endnonfk);
			}
			
			if(endfk)
			{
				endfk.style.backgroundColor="ff9999";
			
			}
			var x1= AbsoluteOffset(endnonfk, "");
			var y1= AbsoluteOffset(endnonfk, "top");
			var x2= AbsoluteOffset(endfk, "");
			var y2= AbsoluteOffset(endfk, "top");
			//alert(x1 + " " + y1 + " " + x2 + " " + y2);
			
		 
			if(x1>0  && y1>0  && x2>0  && y2>0)
			{
			
				out+= x1  + "\n" + y1 + "\n" + x2 + "\n" + y2 + "\n" +arrRdata[i]+ "\n\n\n";
				DrawRelationship(parseInt(x1),parseInt( y1),parseInt(x2) , parseInt(y2), "idrelationship " + arrRdata[i], mapname);
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
	//bleh that was easy!
	//var arrDivs=document.getElementsByClassName('rel');
	var out="";
	
	var arrDivs=container.childNodes;
	for(i=0; i<arrDivs.length; i++)
	{
	
		var thisdiv=arrDivs[i];
		var thisid=thisdiv.id;
		
		//alert(thisid + " " + thisid.indexOf("relationship"));
		if(thisdiv.nodeName.toLowerCase() =="div" && thisid.indexOf("relationship")>-1)
		{
			out+=thisid + "\n";
			//alert("xxx" + thisid);
			//thisdiv.style.display="none";
			//thisparent=GetParent(thisdiv);
			container.removeChild(thisdiv);
		
		}
	}
	//alert(out);
}

function DrawRelationship(x1, y1, x2, y2, relname, location)
{
	//alert(relname);
	var w=parseInt(Math.abs(x1-x2));
	var h=parseInt(Math.abs(y1-y2));
	var tx=x1;
	var ox=x2;
	var bwlxSwap=false;
	var bwlySwap=true;
	if(x1>x2)
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
	//alert(w + "\n" + relname);
	
	
	var strokewidth=1;
	var container = document.getElementById(location);
	xdiv=document.createElement('div');
	xdiv.style.fontSize="0px";
	xdiv.style.padding="0px";
	xdiv.style.margin="0px";
	xdiv.style.border="0px";
	xdiv.style.position="absolute";
	xdiv.style.overflow="hidden";
	xdiv.style.height=strokewidth;
	//xdiv.setAttribute("style","overflow:hidden;position:absolute;");
	xdiv.setAttribute("class", "rel");
	xdiv.id=relname + " x";
	
	xdiv.style.height=strokewidth;
	xdiv.style.backgroundColor='#669966';
	//either ty/tx/ty/tx or oy/tx/ty/ox
	bwlMoveVertical=false;
	if(bwlxSwap)
	{
		xdiv.style.top=oy;
		xdiv.style.left=tx;
		//w=+140;
		
	}
	else
	{
		xdiv.style.top=ty;
		xdiv.style.left=tx;
		//w-=140;
		bwlMoveVertical=true;
	}
	xdiv.style.width=w;
	xdiv.style.zIndex=xcount;
	container.appendChild(xdiv);
	xcount--;
	
	ydiv=document.createElement('div');
	
	
	ydiv.style.fontSize="0px";
	ydiv.style.padding="0px";
	ydiv.style.margin="0px";
	ydiv.style.border="0px";
	ydiv.style.position="absolute";
	ydiv.style.overflow="hidden";
	//ydiv.setAttribute("style","overflow:hidden;position:absolute;");
	ydiv.setAttribute("class", "rel");
	ydiv.id=relname+ " y";
	ydiv.style.width=strokewidth;
	
	ydiv.style.backgroundColor='#669966';
 	if(bwlySwap)
	{
		ydiv.style.top=ty;
	 
		ydiv.style.left=ox;
		
		 
	}
	else
	{
		ydiv.style.top=ty;
		ydiv.style.left=tx;
	
	}
 	ydiv.style.height=h;
	ydiv.style.zIndex=xcount;
	container.appendChild(ydiv);
	xcount--;
	
	
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
	//drawrelationships( relationsubdata);
	

}