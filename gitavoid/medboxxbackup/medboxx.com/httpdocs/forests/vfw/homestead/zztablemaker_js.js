//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function TRaction(thisaction)
{
	var i;
	tagarray=document.getElementsByTagName("tr");
	for(i=0; i<tagarray.length; i++)
	{
		if(document.getElementById("id" + "swapfieldd-" + i) )
		{
			if(document.getElementById("id" + "swapfieldd-" + i).checked==true)
			{
				basisid=i;
				if (thisaction=="up")
				{
					swapfield("swapfieldd-" + basisid, "swapfieldd-" + parseInt(parseInt(basisid)-1));
					return;
				}
				else if (thisaction=="down")
				{
					swapfield("swapfieldd-" + basisid, "swapfieldd-" + parseInt(parseInt(basisid)+1));
					return;
				}
				else if (thisaction=="delete")
				{
					deletefield("swapfieldd-" + basisid);
					return;
				}
			}
		}
	}
}
function pksingle(obj)
{
//decide when to provide an autoincrement checkbox 
	thisid=obj.id;
	thisNumber=parseInt(thisid.substring(11));
	var bwlIschecked=document.getElementById(thisid).checked;
	var i;
	//return false;  //i disable this because now i want to support composite PKs
	tagarray=document.getElementsByTagName("tr");

	for(i=0; i<tagarray.length; i++)
	{
		if(document.getElementById("id"  + qpre +  "prikey-" + i))
		{
			//document.getElementById("id" + qpre +  "prikey-" + i).checked=false;
			if(!document.getElementById("id" + qpre +  "autoinc-" + i).checked)
			{
			//document.getElementById("id" + qpre +  "autoinc-" + i).checked=false;
			
 				document.getElementById("id" + qpre +  "autoinc-" + i).style.display='none'; 
			}
			else
			{
			
		
			}
		}
	}

	//alert(thisNumber);
 	//document.getElementById(thisid).checked=true;
	
	var thistypeselect=document.getElementById("id"  + qpre +  "type-" + thisNumber)
	if (thistypeselect.selectedIndex)
	{
		var typeofthiscolumn=thistypeselect[thistypeselect.selectedIndex].text;
	
	}

	if(typeofthiscolumn.indexOf('int')>-1  || typeofthiscolumn==undefined || typeofthiscolumn=="")
	{
		if(bwlIschecked)
		{
			document.getElementById("id" + qpre +  "autoinc-" + thisNumber).style.display='';
			document.getElementById("id" + qpre +  "nullable-" + thisNumber).checked=false;
		}
		else
		{
			document.getElementById("id" + qpre +  "autoinc-" + thisNumber).checked=false;
			document.getElementById("id" + qpre +  "autoinc-" + thisNumber).style.display='none';
			
		}
		
	}
	
 
}

function autoincsingle(obj)
{
//decide when to provide an autoincrement checkbox 
	var i;
	//return false;  //i disable this because now i want to support composite PKs
	tagarray=document.getElementsByTagName("tr");
	thisid=obj.id;
	var bwlIschecked=document.getElementById(thisid).checked;

	for(i=0; i<tagarray.length; i++)
	{
		if(document.getElementById("id"  + qpre +  "autoinc-" + i))
		{
			document.getElementById("id" + qpre +  "autoinc-" + i).checked=false;
 			document.getElementById("id" + qpre +  "autoinc-" + i).style.display='none'; 
	
		}
	}
	
	thisNumber=parseInt(thisid.substring(12));
	//alert(thisNumber);

	
	var thistypeselect=document.getElementById("id"  + qpre +  "type-" + thisNumber)
	var typeofthiscolumn=thistypeselect[thistypeselect.selectedIndex].text;

	if(typeofthiscolumn.indexOf('int')>-1)
	{
		if(bwlIschecked)
		{
			document.getElementById(thisid).checked=true;
		
		}
		else
		{
			document.getElementById(thisid).checked=false;
		
		}
		document.getElementById(thisid).style.display='';
		document.getElementById("id" + qpre +  "nullable-" + thisNumber).checked=false;
	}
	
}


function trselect(thisid)
{
	var i, arrID, intID;
	var selectcolor;
	selectcolor='ffff66';
	tagarray=document.getElementsByTagName("tr");
	//alert(thisid);
	arrID=thisid.split("-");
	intID=arrID[arrID.length-1];
	for(i=0; i<tagarray.length; i++)
	{
		//alert("swapfieldd-" + i +  " " + thisid );
		//alert(iswapfieldd-);
		if(document.getElementById("id" + "swapfieldd-" + i))
		{
			document.getElementById("id" + "swapfieldd-" + i).checked=false;
		}
		
	}
	for(i=0; i<tagarray.length; i++)
	{
		//alert(tagarray[i].style.backgroundColor);
		if (tagarray[i].style.backgroundColor!="")
		{
	 
			tagarray[i].style.backgroundColor='';
		
		}
		moreline=document.getElementById("idmorerow-" + i);
		if(moreline)
		{
			if(moreline.style.backgroundColor!='')
			{
				moreline.style.backgroundColor='';
			}
		}
	}
	Thisparenttr=ClimbTreeToTR(thisid);
	document.getElementById(thisid).checked=true;
	Thisparenttr.style.backgroundColor=selectcolor;
	
	moreline=document.getElementById("idmorerow-" + intID);
	moreline.style.backgroundColor=selectcolor;


}

function deletefield(thisid)
{
	var parenttr;
	parenttr=ClimbTreeToTR("id" + thisid);
	//alert(thisid);
	thisNumber=parseInt(thisid.substring(11));
	//alert(thisNumber);
	thisatagid="id" + qpre + "field-" +  thisNumber;
	//alert(thisatagid);
	fieldvalue=document.getElementById( thisatagid).value;
	if (fieldvalue=="")
	{
		confirmstring="Are you certain you want to delete this unnamed field?";
	
	}
	else
	{
	
		confirmstring="Are you certain you want to delete the field named " + fieldvalue + "?";
	}
	if (confirm(confirmstring))
	{
		//alert(thisatagid);
		//thisatagelement=document.getElementByID(thisatagid);
		//alert(qpre + "field-" + thisNumber);
		killfield=document.getElementById("id" + qpre + "field-" + thisNumber).value
		document.BForm[qpre + "delete"].value=document.BForm[qpre + "delete"].value + "|" + killfield;
		MasterParent=GetParent(parenttr);
		MasterParent.removeChild(parenttr);
	}
	TBRenumberHenceforth("idaddfield-" + parseInt(parseInt(thisNumber)+1), "delete");
 
}

function swapfield(thisid, thatid)
{
	var ThisNumber, ThatNumber, Thisparenttr, Thatparenttr, thischildren, thatchildren, j, k, parentofTRs;
	var afterfieldvalue;
	var thisfieldvalue="";
	var afterfieldvalue="";
	var m=0;
	//ThisNumber=parseInt(thisid.substring(11));
	//ThatNumber=parseInt(thatid.substring(11));
	arrThis=thisid.split("-");
	arrThat=thatid.split("-");
	//ThisNumber=parseInt(thisid.substring(11));
	//ThatNumber=parseInt(thatid.substring(11));
	ThisNumber=arrThis[arrThis.length-1];
	ThatNumber=arrThat[arrThat.length-1];
	//alert (ThisNumber +  " " +  ThatNumber);
	//alert (thisid +  " " +  thatid);
	Thisparenttr=ClimbTreeToTR("id" + thisid);
	Thatparenttr=ClimbTreeToTR("id" + thatid);
	Thismore=document.getElementById("idmorerow-" + ThisNumber);
	Thatmore=document.getElementById("idmorerow-" + ThatNumber);
	
	//dont want to do this if we're at the end of the range
 	if (Thisparenttr && Thatparenttr  && ThatNumber>0)
	{
		//ThisChecked=document.getElementById("swapfieldd-" + ThisNumber).checked;
		//ThatChecked=document.getElementById("swapfieldd-" + ThatNumber).checked;
		
		ThisClass=Thisparenttr.className;
		ThatClass=Thatparenttr.className;
		Thisparenttr.className=ThatClass;
		Thatparenttr.className=ThisClass;
		
		thischildren=Thisparenttr.childNodes;
		thatchildren=Thatparenttr.childNodes;
		//i use a while loop here to go through both the main row and the "more" row (the one with the helptext)
		while(m<2)
		{
			if (m==1)
			{
				thischildren=Thismore.childNodes;
			}
			for(j=0; j<thischildren.length; j++)
			{
				if (thischildren[j].nodeName=="TD")
				{
					these2children=thischildren[j].childNodes;
					if (thischildren[j].style)
					{
						//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
						thischildren[j].style.display='';
					}
					//a hack to make things line up at the beginning of the editor
					if (thischildren[j].id=="killmeonexpand")
					{
						//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
						thischildren[j].style.display='none';
					}
					for(k=0; k<these2children.length; k++)
					{
					
						if(these2children[k].nodeName=="A")
						{
							if (these2children[k].href.indexOf("addfield-")>0)
							{
								these2children[k].href="javascript: addfield('addfield-" + ThatNumber + "')";
								these2children[k].id="id" + "addfield-"  + ThatNumber;
							}
							else if (these2children[k].name.indexOf("-")>0 )//&& !(these2children[k].name.indexOf("old-")>0)
							{
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0] + "-" + ThatNumber ;
								these2children[k].id="id" + arrName[0] + "-" + ThatNumber ;
							}
						}
						if(these2children[k].nodeName=="INPUT"  || these2children[k].nodeName=="TEXTAREA"  || these2children[k].nodeName=="SELECT")
						{
							if (these2children[k].name.indexOf("-")>0 ) 
							{
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0] + "-" + ThatNumber ;
								these2children[k].id="id" + arrName[0] + "-" + ThatNumber ;
							}
							
						}
	
					}
				}
		 
			}
			m++;
		}
		
		m=0;
		//i use a while loop here to go through both the main row and the "more" row (the one with the helptext)
		while(m<2)
		{
			if (m==1)
			{
				thischildren=Thatmore.childNodes;
			}
			for(j=0; j<thatchildren.length; j++)
			{
				if (thatchildren[j].nodeName=="TD")
				{
					these2children=thatchildren[j].childNodes;
					if (thatchildren[j].style)
					{
						//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
						thatchildren[j].style.display='';
					}
					//a hack to make things line up at the beginning of the editor
					if (thatchildren[j].id=="killmeonexpand")
					{
						//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
						thatchildren[j].style.display='none';
					}
					for(k=0; k<these2children.length; k++)
					{
						//alert(these2children[k].nodeName);
					
						if(these2children[k].nodeName=="A")
						{
							
							if (these2children[k].href.indexOf("addfield-")>0)
							{
								these2children[k].href="javascript: addfield('addfield-" + ThisNumber + "')";
								these2children[k].id="id" + "addfield-"  + ThisNumber;
							}
	 						else if (these2children[k].name.indexOf("-")>0)
							{
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0] + "-" + ThisNumber ;
								these2children[k].id="id" + arrName[0] + "-" + ThisNumber ;
							
							}
				
							
						}
						if(these2children[k].nodeName=="INPUT"  || these2children[k].nodeName=="TEXTAREA" || these2children[k].nodeName=="SELECT")
						{
							
							//these2children[k].value="";
							if (these2children[k].name.indexOf("-")>0)
							{
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0] + "-" + ThisNumber ;
								these2children[k].id="id" + arrName[0] + "-" + ThisNumber ;
							
							}
							
			
						}
						 
					}
				}
		 
			}
			m++;
		}
		
		Thismore.id="idmorerow-" + ThatNumber;
		Thismore.name="morerow-" + ThatNumber;
		Thatmore.id="idmorerow-" + ThisNumber;
		Thatmore.name="morerow-" + ThisNumber;
		
		Thatparenttr.swapNode(Thisparenttr);
		
		Thismore.swapNode(Thatmore);
		
		document.getElementById("idswapfieldd-" + ThisNumber).checked=false;
		document.getElementById("idswapfieldd-" + ThatNumber).checked=true;
		
		

	

	
	
		//keep a running account of what things have been moved to where so we can deal with them when we alter the table
		if (parseInt(ThatNumber)>1)
		{
			//alert("%" + qpre + "field-" + parseInt(parseInt(ThisNumber)-1));
			if (document.getElementById("id" + qpre + "field-" +  parseInt(parseInt(ThatNumber)-1)))
			{
				afterfieldvalue=document.getElementById("id" + qpre + "field-" +  parseInt(parseInt(ThatNumber)-1)).value;
			}
			//alert("$" + afterfieldvalue);
		}
		else
		{
			afterfieldvalue="*";
		}
		//alert("&");
		
		if (document.getElementById("id" + qpre + "field-" + parseInt(ThatNumber)))
		{
			thisfieldvalue=document.getElementById("id" + qpre + "field-" + parseInt(ThatNumber)).value;
		}
		
		document.BForm[qpre + "repositions"].value=document.BForm[qpre + "repositions"].value + " " + thisfieldvalue + "|" + afterfieldvalue;
		//document.BForm[qpre + "repositions"].value.replace(/^\s+|\s+$/g,""); //ltrim
	}
}



if (!document.all)
{

	
	//clean whitespace method by Alex Vincent
	var notspace = /\S/;
	
	function cleanWhitespace(node)
	{
		for (var x=0; x<node.childNodes.length; x++)
		{
			var child = node.childNodes[x];
			//if it's a whitespace text node
			if ((child.nodeType == 3) && (!notspace.test(child.nodeValue)))
			{
				node.removeChild(node.childNodes[x]);
				x--;
			}
			//elements can have text child nodes of their own
			if(child.nodeType == 1)
			{
				cleanWhitespace(child);
			}
		}
		return node;
	}
	
	Node.prototype.swapNode = function(n)
	{
	   var p = n.parentNode;
	   var s = n.nextSibling;
	   this.parentNode.replaceChild(n,this);
 		if (!p.insertBefore(this,s))
		{
	 		p.appendChild(s);
		}
 		
	   return this;
	}
}

function more(obj)
{
	var TRnode, TRchildren;
	arrID=obj.id.split("-");
	intID=arrID[arrID.length-1];
	TRtoExpand=document.getElementById("idmorerow-" + intID);
	if (TRtoExpand.style.display=="none")
	{
		TRtoExpand.style.display="";
	}
	else
	{
		TRtoExpand.style.display="none";
	}
}


function addfield(thisid)
{
	var OurNewNumber, OldNumber, parenttr, moreline;
	var j, k, p;
	var m=0;
	
 	thishref=document.getElementById("id" + thisid);
	arrOldNumber= thisid.split("-");
	OldNumber=parseInt(arrOldNumber[arrOldNumber.length-1]);
	OurNewNumber=parseInt(OldNumber)+1;
	parenttr=ClimbTreeToTR("id" + thisid);
	newTR=document.createElement('tr');
	TBRenumberHenceforth("id" + thisid, "");
	parentofTRs= GetParent(parenttr);
	moreline=document.getElementById("idmorerow-" + OldNumber);
	clone=parenttr.cloneNode(true);
	moreclone=moreline.cloneNode(true);
	clone.style.backgroundColor='';
	thesechildren=clone.childNodes;
	
	moreclone.id="idmorerow-" + OurNewNumber;
	moreclone.name="morerow-" + OurNewNumber;
	//i use a while loop here to go through both the main row and the "more" row (the one with the helptext)
	while(m<2)
	{
		if (m==1)
		{
			thesechildren=moreclone.childNodes;
		}
	 
		for(j=0; j<thesechildren.length; j++)
		{
	 
			if (thesechildren[j].nodeName.toLowerCase()=="td")
			{
				these2children=thesechildren[j].childNodes;
				if (thesechildren[j].style)
				{
					//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
					thesechildren[j].style.display='';
				}
				//a hack to make things line up at the beginning of the editor
				if (thesechildren[j].id=="killmeonexpand")
				{
					//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
					thesechildren[j].style.display='none';
				}
				for(k=0; k<these2children.length; k++)
				{
					if(these2children[k].nodeName.toLowerCase()=="a")
					{
				
						if (these2children[k].href.indexOf(": addfield")>0  || these2children[k].href.indexOf(":%20addfield")>0) //had to add the second part of the test due to a slight Firefox 3.0 DOM change
						{
							these2children[k].href="javascript: addfield('addfield-" + OurNewNumber + "')";
							these2children[k].id="id" + "addfield-"  + OurNewNumber;
							
						}
						else if (these2children[k].name.indexOf("-")>0)
						{
							arrName=these2children[k].name.split("-");
							these2children[k].name=arrName[0] + "-" + OurNewNumber ;
							these2children[k].id="id" + arrName[0] + "-" + OurNewNumber ;
						}		
					}
					
					if(these2children[k].nodeName.toLowerCase()=="input"   || these2children[k].nodeName.toLowerCase()=="textarea" )
					{
						//alert(these2children[k].nodeName.toLowerCase() + " " + these2children[k].name);
						
						
						
						
						
						if( !(these2children[k].name.indexOf("invisible")>0  || these2children[k].name.indexOf("fileupload")>0 || these2children[k].name.indexOf("password")>0))
						{
							these2children[k].value="";
						}
						if (these2children[k].name.indexOf("-")>0)
						{
							arrName=these2children[k].name.split("-");
							these2children[k].name=arrName[0] + "-" + OurNewNumber ;
							//alert(these2children[k].name);
							these2children[k].id="id" + arrName[0] + "-" + OurNewNumber ;
						}		
						
						if (these2children[k].name.indexOf("nullable")>0)
						{
							these2children[k].value=1;
							these2children[k].checked=true;
						}
						
						else if (these2children[k].name.indexOf("prikey")>0)
						{
							these2children[k].value=1;
							these2children[k].checked=false;
						}
						else if (these2children[k].name.indexOf("autoinc")>0)
						{
							these2children[k].value=1;
							these2children[k].checked=false;
							these2children[k].style.display='none';
						}
						else if (these2children[k].name.indexOf("invisible")>0  || these2children[k].name.indexOf("fileupload")>0 || these2children[k].name.indexOf("password")>0)
						{
							if(these2children[k].value==1)
							{
								these2children[k].checked=false;
							}
							if(these2children[k].value==0)
							{
								these2children[k].checked=false;
							}
						}
						else if (these2children[k].name.indexOf("old-")>0)
						{
							//do not set a value for old here!!
							these2children[k].value="";
						}
					}
					if(these2children[k].nodeName.toLowerCase()=="select")
					{
						these2children[k].name=qpre + "type-" + OurNewNumber ;
						these2children[k].id="id" + qpre + "type-" + OurNewNumber ;
						these2children[k].selectedIndex=-1;
						if(document.BForm[qpre + "fieldcount"].value==0)//we're making the first field, so let's set type to int
						{
							for(p=0; p<these2children[k].childNodes.length; p++)
							{
								if(these2children[k].childNodes[p].value=="int")
								{
									these2children[k].childNodes[p].selected=true;
								
								}
							
							}
						
						}
					}
					 
				}
			}
	 
		}
		m++;
	}
 
	//for some reason in firefox we run into trouble if i don't put some white space around the newly-inserted TRs.  wsp is the whitespace that fixes this
	ThisClass=clone.className;
	if (ThisClass=="" || ThisClass==undefined || ThisClass=="hideallbutlast")
	{
		clone.className="bgclassfirst";
	}

	wsp=document.createTextNode("\n");
	
	insertAfter(parentofTRs, wsp, moreline);
	insertAfter(parentofTRs, moreclone, moreline);
	insertAfter(parentofTRs, wsp, moreline);
	insertAfter(parentofTRs, wsp, moreline);
	insertAfter(parentofTRs, clone, moreline);
	insertAfter(parentofTRs, wsp, moreline);
}


function TBRenumberHenceforth(thisid, mode)
{
	//first get the number we're at
	var OurNumber, thisatagid;
	var thishref;
	var ourTR;
	var MasterParent;
	var i;
	var tagarray;
	var topLimit;
	var intNew=0;
	OurNumber=thisid.substring(11);
	thishref=document.getElementById(thisid);
	ourTR= ClimbTreeToTR(thisid);
	MasterParent=GetParent(ourTR);
	if(MasterParent)
	{
		tagarray=MasterParent.getElementsByTagName("tr");
		message="";
		if (mode=="delete")
		{
			topLimit=parseInt(parseInt(OurNumber)-1);
		}
		else
		{
			topLimit=parseInt(OurNumber);
		
		}
		if (mode=="delete")
		{
			//for deletes we have to go from zero to the top
		
			for(i=OurNumber; i<tagarray.length; i++)
			{
				//now we have to renumber all the a hrefs inside the trs to keep it all dynamic
				RenumberRow(mode, i);
			}
		}
		else
		{
			for(i=tagarray.length; topLimit<i; i--)
			{
				//now we have to renumber all the a hrefs inside the trs to keep it all dynamic
				RenumberRow(mode, i); 
			}
		}
	}
	if (mode=="delete")
	{
		document.BForm[qpre + "fieldcount"].value= parseInt(document.BForm[qpre + "fieldcount"].value) - 1;
	}
	else
	{
		document.BForm[qpre + "fieldcount"].value= parseInt(document.BForm[qpre + "fieldcount"].value) + 1;
	
	}
}


function RenumberRow(mode, intIn)
{
	var intNew, thisatagid;
	var j=0;
	thisatagid="id" + "addfield-" + intIn;
	
	thisatagelement=document.getElementById(thisatagid);
	//alert(thisatagid);
				//rename!!
	if(thisatagelement)
	{
		
		if (mode=="delete")
		{
			//alert("!");
			intNew=parseInt(intIn -1);
		}
		else
		{
			intNew=parseInt(intIn +1);
 
		}
		thisatagelement.name= "addfield-" + intNew;
		thisatagelement.id="id" + "addfield-" + intNew;
		thisatagelement.href="javascript: addfield('addfield-" +  intNew + "')";
		thisatagid="id" + qpre + "type-" +  intIn;
		thisatagelement=document.getElementById(thisatagid);
		if(thisatagelement)
		{
			strTargets="type|prikey|default|nullable|autoinc|length|old|field|swapfieldd|moreadd|friendly|helptext|invisible|morerow|validationtypeid|validationpatternid|fileupload|password|width|height";
			arrTargets=strTargets.split("|");
			for(j=0; j<arrTargets.length; j++)
			{
				thisatagid="id" + qpre + arrTargets[j] + "-" +  intIn;
				thisatagelement=document.getElementById(thisatagid);
				if(thisatagelement)
				{
					thisatagelement.name=qpre + arrTargets[j] + "-" + intNew;
					thisatagelement.id="id" + thisatagelement.name;
				}
				else 
				{
					thisatagid="id"  + arrTargets[j] + "-" +  intIn;
					thisatagelement=document.getElementById(thisatagid);
					if(thisatagelement)
					{
						thisatagelement.name= arrTargets[j] + "-" + intNew;
						thisatagelement.id="id" + arrTargets[j] + "-" + intNew;
					}
				}	
				
			}
		}					 
	}
}
