function profile(u) 
	{
		remote = window.open("http://www.vodkatea.com/b/profile.asp?alias="+ escape(Establish(u))  ,"profile","height=340,width=500,scrollbars=yes");
	}

function ShowProfile(u, i) 
	{
		remote = window.open("http://www.vodkatea.com/b/profile.asp?action=" + Establish(i) + "&userid=" + Establish(u) ,u,"height=340,width=500,scrollbars=yes");
	}

function definition(term, u)
	{
		remote = window.open("http://www.vodkatea.com/g/definition.asp?bgcolor=ffffff&text=000000&alias=" + escape(Establish(u)) + "&term=" + Establish(term) ,"definition","menubar=no,height=350,width=450,scrollbars=yes");
		    if (remote.opener == null) remote.opener = window;
		remote.focus()
	}
	

function Establish(strIn)
	{
		if (typeof(strIn)=="undefined")
		{
			return ""
		}
		else
		{
			return strIn
		}
	}


function vote(pid, size)
{	
			var strAccumulate =0
			for (intParse=0; intParse<document.BForm.answerid.length; intParse++)
			{
				if (document.BForm.answerid[intParse].checked==true) 
				{
				strAccumulate = document.BForm.answerid[intParse].value 
				}
			}
			remote = window.open("http://www.vodkatea.com/p/pollvote.asp?answerid=" + strAccumulate + "&pollid=" + pid + "&x=","moderate","menubar=no,height=" + (size * 60 + 50) + ",width=400,scrollbars=yes");
		 if (remote.opener == null) remote.opener = window;
		remote.focus()
}


	
// color functions ported to Javascript from 
// similar ASP functions
// both versions by Gus Mueller
// March-May 1999


function convertnums(decNum,hexNum) 
{      
	
	if ((decNum != "") && (hexNum == "")) { 
	strOut = dec2hex(decNum);
	} else { 
	strOut = parseInt(hexNum,16);
	}
	return(strOut)
}

function fixHex(theDec) 
{ 
	var hNum = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
	var retHex = hNum[theDec];
	return retHex;
}

function dec2hex(theDec) 
{
	var leftNum;
	var rightNum;
	var leftNumS;
	var rightNumS;
	var retNum;
	
	if (theDec > 255) {
			theDec=255;
	} else {
	leftNum = Math.floor(theDec / 16);
	leftNumS = fixHex(leftNum);
	rightNum = theDec%16;
	rightNumS = fixHex(rightNum);
	retNum = leftNumS + rightNumS;
	}
	return retNum;
}

function colorindex(strIn)
	{
	return(parseInt(strIn,16))
	
	}

function indextocolor(intIn)
	{
	return(dec2hex(intIn))
	}

function colorparse(strIn, intColor)
	{
		if (intColor==0)
		{return(strIn.substring(0,2))}
		if (intColor==1)
		{return(strIn.substring(2,4))}
		if (intColor==2)
		{return(strIn.substring(4,6))}
	}
	
function lighterhue(strIn, colIn, intValue)
	{
	strAccumulate=""
	for (intParse=0; intParse<3; intParse++)
	{
		if (intParse==colIn) 
			{
			colPotential=colorindex(colorparse(strIn, colIn))+intValue
			if (colPotential>255) 
				{
				colPotential=255
				}
			if (colPotential<0)
				{
				colPotential=0
				}
			strAccumulate=strAccumulate + indextocolor(colPotential)
			}
		else
			{
			strAccumulate=strAccumulate + colorparse(strIn, intParse)
			}
	}
	return(strAccumulate)
	}


function funtable()
	{
		var strOut
		start="000000"
		strOut = "<table cellpadding=0 border=0 cellspacing=0>";
		for (r=0; r<655; r=r+5)
		{	
			strOut = strOut + "<tr>";
				for (t=0; t<255; t=t+10)
				{
					newcolor=lighterhue(start, 2, 128+parseInt(128 * Math.sin(r/50)));
					newcolor=lighterhue(newcolor, 0, 128+parseInt(128 * Math.cos(t/100)));
					newcolor=lighterhue(newcolor, 1, 128+parseInt(128 * Math.cos((t+r)/44)));
					strOut = strOut + "<td bgcolor=" + newcolor + ">";
					strOut = strOut + "<img src=graphix/spacer.gif width=12 height=3 border=0></td>";
				}
			strOut = strOut + "</tr>";
		}
		strOut = strOut + "</table>";
		return(strOut)
	}

	
	
	
function colortable()
	{
		var strOut
		start="000000"
		strOut = "<table cellpadding=0 border=0 cellspacing=0>";
		for (r=0; r<255; r=r+20)
		{	
			strOut = strOut + "<tr>"
			for (g=0; g<255; g=g+20)
			{
				for (b=0; b<255; b=b+20)
				{
					newcolor=lighterhue(start, 2, b);
					newcolor=lighterhue(newcolor, 1, g);
					newcolor=lighterhue(newcolor, 0, r);
					strOut = strOut + "<td bgcolor=" + newcolor + ">";
					strOut = strOut + "<img src=graphix/spacer.gif width=3 height=12 border=0></td>";
				}
			}
			strOut = strOut + "</tr>";
		}
		strOut = strOut + "</table>";
		return(strOut)
	}

function colorpop() 
		{
			remote = window.open("../colorpicker.htm","colorpop","height=200,width=580,scrollbars=yes");
		}	
	
function reply(intPostID, intBoardID, action)
	{
		remote = window.open("http://www.vodkatea.com/b/editpost.asp?action=" +  Establish(action) + "&i=" + Establish(intBoardID) + "&p=" + Establish(intPostID) + "&x=" + sanerand(),"editpost","height=300,width=550,scrollbars=yes");
		if (remote.opener == null) remote.opener = window;
		remote.focus();
	}	
	
function sanerand() //returns a random integer between 0 and 1000//
	{
		return parseInt(Math.random()*1000)
	}	
		
		

function GetParent(thisnode)
{
	var thisparent;
	if(thisnode)
	{
		if (thisnode.parentNode)
		{
			thisparent=thisnode.parentNode
		}
		else
		{
			thisparent=thisnode.parentElement
		}
	
		return (thisparent);
	}
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
	return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
	return this.replace(/\s+$/,"");
}


function inList(list, val)
{
	var arrList=list.split(" ");
	var i;
	for(i=0; i<list.length; i++)
	{
		var thisitem=arrList[i];
		if(thisitem==val)
		{
			return true;
		}
	}
	return false;

}

function genericdata(strIn,intTypeIn, intTypeOut, strTranslate, rowdelimiter, fielddelimiter)
	//form of 'data' that allows you to pass in your own delimiters
	//if bwlRow=true than return the whole row as an array
	{
		var i;
		arrTranslate=strTranslate.split(rowdelimiter);
		strOut="";
		bwlDone=0;
		for (i=0;  i <  arrTranslate.length && bwlDone==0; i++)
			{
				arrThis=arrTranslate[i].split(fielddelimiter);
				if (intTypeIn< arrThis.length && intTypeOut< arrThis.length)
					{
						if (intTypeIn==-1) 
							{
								if (strIn==i )
								{
									if (bwlRow)
									{
										strOut=arrThis;
									}
									else
									{
										strOut=arrThis[intTypeOut];
									}
									bwlDone=1;
								}
							}
						else
							{
								if (arrThis[intTypeIn]==strIn)
									{
										strOut=arrThis[intTypeOut];
										bwlDone=1;
									}
							}
					}
			}
		return(strOut);
	}
	