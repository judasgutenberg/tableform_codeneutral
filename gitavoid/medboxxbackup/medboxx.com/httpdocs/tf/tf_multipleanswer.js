//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
overinsertprevent="";

function colorbg(thiscolor)
{
	document.body.style.backgroundColor= thiscolor;
	return;

} 


function MATRaction(thisaction, thisset)
{
	var i;
	var inthisset="";
	if(thisset!=""  && thisset!=undefined)
	{
		inthisset=thisset;
		thisset= thisset + "-";
	}
	tagarray=document.getElementsByTagName("tr");
	for(i=0; i<tagarray.length; i++)
	{
		if(document.getElementById("id" + "swapfieldd-" + thisset + i) )
		{
			if(document.getElementById("id" + "swapfieldd-" + thisset + i).checked==true)
			{
				basisid=i;
				//alert(basisid);
				if (thisaction=="up")
				{
					swapQrow("swapfieldd-" + thisset + basisid, "swapfieldd-" + thisset + parseInt(parseInt(basisid)-1), inthisset);
					return;
				}
				else if (thisaction=="down")
				{
					swapQrow("swapfieldd-" + thisset + basisid, "swapfieldd-" + thisset + parseInt(parseInt(basisid)+1), inthisset);
					return;
				}
				else if (thisaction=="delete")
				{
					MAdeletefield("swapfieldd-" + thisset + basisid);
					return;
				}
			}
		}
	}
}
function SortSave(thisset, db, table, pkid, sortfield)
{
	var i
	var valuelist="";

	tagarray=document.getElementsByTagName("tr");
 
	for(i=0; i<tagarray.length; i++)
	{
		 
		if(document.getElementById("id" + "swapfieldd-"  + thisset + "-" + i))
		{
			
			valuelist+="+" + document.getElementById("id" + "swapfieldd-"  + thisset + "-" + i).value;
		}
		
	}
	//alert(valuelist + " " + table + " " + pkid);
	top.secondarytool.location.href="tf_sort_save.php?" + qpre  + "db=" + db + "&" + qpre  + "table=" + table + "&" + qpre +   "idfield=" + pkid + "&" + qpre + "idlist=" + valuelist + "&" + qpre + "sortfield=" + sortfield;
}


function FocusFirstFormItem(thisid, thisset)
{

	var MasterParent, j,k, thatchildren, these2children,  firstinput;
	var focused=false;
	var skipfocus=false;
 	ThisParent=ClimbTreeToTR(thisid);
	//MasterParent=GetParent(ThisParent);
	//alert(MasterParent);
	thatchildren=ThisParent.childNodes;
	for(j=0; j<thatchildren.length; j++)
	{
		if (thatchildren[j].nodeName=="TD")
		{
			these2children=thatchildren[j].childNodes;
			//alert(these2children.length);
			for(k=0; k<these2children.length; k++)
			{
				if(these2children[k].nodeName=="INPUT"  && these2children[k].name.substr(0,5)!="group" && these2children[k].name.substr(0,5)!="swapf")
				{
					//alert(these2children[k].id);
					if(firstinput==undefined)
					{
						firstinput=these2children[k];
					
					}
					//if (these2children[k].isFocused )
					{
					//	alert(these2children[k].name);
					//	skipfocus=true;
					}
			
					focused=false;
				
					 
				}
			}
		}
	}
	if (!focused   && !skipfocus)
	{
		//alert(firstinput.name);
		if(firstinput)
		{
			firstinput.focus();
		}
	}
}


function MAtrselect(thisid, thisset)
{
	var i, arrID, intID;
	var selectcolor;
	var oldchecked="";
	//var xdebugger="";
	//var ydebugger="";
	if(thisset!="" && thisset!=undefined)
	{
		thisset= thisset + "-";
	}
	selectcolor='ffcc99';
	tagarray=document.getElementsByTagName("tr");
	//alert(thisid);
	arrID=thisid.split("-");
	intID=arrID[arrID.length-1];
	// xdebugger = tagarray.length + " = len \n";
	 if(thisset==undefined)
	 {
	 	thisset="";
	 }
	for(i=0; i<tagarray.length; i++)
	{
		//alert("swapfieldd-" + i +  " " + thisid );
		//alert(iswapfieldd-);
		//alert("id" + "swapfieldd-"  + thisset + i);
		//alert(  thisset  );
		if(document.getElementById("id" + "swapfieldd-"  + thisset + i))
		{
			if(document.getElementById("id" + "swapfieldd-"  + thisset + i).checked)
			{
				oldchecked="id" + "swapfieldd-"  + thisset + i;
			}
			document.getElementById("id" + "swapfieldd-"  + thisset + i).checked=false;
			//xdebugger=xdebugger + "id" + "swapfieldd-"  + thisset + i   + "\n";
		}
		//ydebugger=ydebugger + "id" + "swapfieldd-"  + thisset + i   + "\n";
		
	}
	for(i=0; i<tagarray.length; i++)
	{
		//alert(tagarray[i].style.backgroundColor);
		if (tagarray[i].style.backgroundColor!="")
		{
			tagarray[i].style.backgroundColor='';
		}
		 
	}
	Thisparenttr=ClimbTreeToTR(thisid);
	
	document.getElementById(thisid).checked=true;
	//alert(ydebugger + "\n" + xdebugger + thisid + " ---- " + document.getElementById(thisid).checked); 
	Thisparenttr.style.backgroundColor=selectcolor;
	//alert(oldchecked + " " + thisid);
	if (oldchecked!=thisid)  //ensure that we don't overwrite the focus on a line we're editing
	{
		FocusFirstFormItem(thisid, thisset);
	}
	 
	//FocusFirstFormItem(thisid, thisset);
	
}

function MAtrselectfromline(obj, thisset)
{
	var MasterParent, j,k, thatchildren, these2children;
 	
	MasterParent=ClimbTreeToTRFromObj(obj);
	//alert(MasterParent);
	thatchildren=MasterParent.childNodes;
	for(j=0; j<thatchildren.length; j++)
	{
	
		if (thatchildren[j].nodeName=="TD")
		{
			these2children=thatchildren[j].childNodes;
	
			for(k=0; k<these2children.length; k++)
			{
				if(these2children[k].id)
				{
					//alert(these2children[k].id);
					if (these2children[k].id.indexOf("swapfieldd-" + thisset)>0)
					{
						//alert(these2children[k].id);
						MAtrselect(these2children[k].id, thisset);
						return;
						
					}
				}
			}
		}
		
	}

}


function MAdeletefield(thisid)
{
	var parenttr, MasterParent;
	parenttr=ClimbTreeToTR("id" + thisid);
	//alert(thisid);
	thisNumber=parseInt(thisid.substring(11));
	//alert(thisNumber);
 
 
	confirmstring="Are you certain you want to delete this row?";
	

	if (confirm(confirmstring))
	{
		//alert(thisatagid);
		//thisatagelement=document.getElementByID(thisatagid);
		//alert(qpre + "field-" + thisNumber);
		killfield=thisNumber;
		document.BForm[qpre + "delete"].value=document.BForm[qpre + "delete"].value + " " + killfield;
		document.BForm[qpre + "fieldcount"].value=parseInt(document.BForm[qpre + "fieldcount"].value)-1;
		MasterParent=GetParent(parenttr);
		MasterParent.removeChild(parenttr);
		MARenumberHenceforth("idaddfield-" + parseInt(parseInt(thisNumber)+1), "delete");
	}
	
 
}

function swapQrow(thisid, thatid, thisset)
{
	var ThisNumber, ThatNumber, Thisparenttr, Thatparenttr, thischildren, thatchildren, j, k, parentofTRs;
	var afterfieldvalue;
	var thisfieldvalue="";
	var afterfieldvalue="";
 	if(thisset!=""  && thisset!=undefined)
	{
		thisset= thisset + "-";
	}
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


	//dont want to do this if we're at the end of the range
 	if (Thisparenttr && Thatparenttr  && ThatNumber>0)
	{
		ThisClass=Thisparenttr.className;
		ThatClass=Thatparenttr.className;
		Thisparenttr.className=ThatClass;
		Thatparenttr.className=ThisClass;
		//ThisChecked=document.getElementById("swapfieldd-" + ThisNumber).checked;
		//ThatChecked=document.getElementById("swapfieldd-" + ThatNumber).checked;
		thischildren=Thisparenttr.childNodes;
		thatchildren=Thatparenttr.childNodes;
 
	 
	 
			for(j=0; j<thischildren.length; j++)
			{
				if (thischildren[j].nodeName=="TD")
				{
					these2children=thischildren[j].childNodes;
					if (thischildren[j].style && !these2children[0].nodeName.toLowerCase()=="span")
					{
						//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
						thischildren[j].style.display='';
					}

	
					for(k=0; k<these2children.length; k++)
					{
					
						if(these2children[k].nodeName=="A")
						{
							if (these2children[k].href.indexOf("addQrow")>0)
							{
								these2children[k].href="javascript: addQrow('addfield-" + ThatNumber + "')";
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
							if (these2children[k].id.indexOf("swapfieldd")>0)
							{
								these2children[k].name=  "swapfieldd-"  + thisset + ThatNumber;
								these2children[k].id="id" + "swapfieldd-"  +  thisset + ThatNumber;
								
							
							}
					
							else if (these2children[k].name.indexOf("-")>0 ) 
							{
							
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0] + "-" + arrName[1] + "-" + ThatNumber;
								these2children[k].id="id" + arrName[0] + "-" + arrName[1] + "-" + ThatNumber;
			
							}
							
						}
	
					}
				}
		 
			}
	 
 
 
 
			for(j=0; j<thatchildren.length; j++)
			{
				if (thatchildren[j].nodeName=="TD")
				{
					these2children=thatchildren[j].childNodes;
					if (thatchildren[j].style && !these2children[0].nodeName.toLowerCase()=="span")
					{
						//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
						thatchildren[j].style.display='';
					}
 
 
					for(k=0; k<these2children.length; k++)
					{
						//alert(these2children[k].nodeName);
					
						if(these2children[k].nodeName=="A")
						{
							
							if (these2children[k].href.indexOf("addQrow")>0)
							{
								these2children[k].href="javascript: addQrow('addfield-" + ThisNumber + "')";
								these2children[k].id="id" + "addfield-"  + ThisNumber;
							}
	 						else if (these2children[k].name.indexOf("-")>0)
							{
				
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0]  + "-" + ThisNumber;
								these2children[k].id="id" + arrName[0]  + "-" + ThisNumber;
							
							}
				
							
						}
						if(these2children[k].nodeName=="INPUT"  || these2children[k].nodeName=="TEXTAREA" || these2children[k].nodeName=="SELECT")
						{
							
							//these2children[k].value="";
							if (these2children[k].id.indexOf("swapfieldd")>0)
							{
								these2children[k].name=  "swapfieldd-"  + thisset + ThisNumber;
								these2children[k].id="id" + "swapfieldd-"  + thisset + ThisNumber;
								
							
							}
					
							else if (these2children[k].name.indexOf("-")>0)
							{
								arrName=these2children[k].name.split("-");
								these2children[k].name=arrName[0] + "-" + arrName[1] + "-" + ThisNumber;
								these2children[k].id="id" + arrName[0] + "-" + arrName[1] + "-" + ThisNumber;
							
							
							}
							
			
						}
						 
					}
				}
		 
			}
		 
 
		Thatparenttr.swapNode(Thisparenttr);
 
		document.getElementById("idswapfieldd-" + thisset + ThisNumber).checked=false;
		document.getElementById("idswapfieldd-" + thisset + ThatNumber).checked=true;
		
	
		
		if (document.getElementById("id" + qpre + "field-" + parseInt(ThatNumber)))
		{
			thisfieldvalue=document.getElementById("id" + qpre + "field-" + parseInt(ThatNumber)).value;
		}
		
 
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

function deleteQrowSelectedOrAtEnd(thisid)
{
	if (thisid=='')
	{
		topRowNum=document.BForm[qpre + "fieldcount"].value-1;
		if(!document.getElementById("id" + "addfield-" + topRowNum))
		{
			topRowNum--;
		}
		thisid="addfield-" + topRowNum;
	}
	//alert(thisid);
	MAdeletefield(thisid);
}

function addQrowAtEnd(thisset)
{
	topRowNum=document.BForm[qpre + "fieldcount"].value-1;
	//alert(topRowNum + "-");
	//alert(document.getElementById("id" + "addfield-" + topRowNum));
	if(!document.getElementById("id" + "addfield-" + topRowNum))
	{
		topRowNum--;
	}
	addQrow("addfield-" + topRowNum, thisset);
}


function addQrow(thisid, thisset)
{
	var OurNewNumber, OldNumber, parenttr;
	var j, k, p;
 	var firstrow="firstrow";
	var secondrow="secondrow";
	  
	if(overinsertprevent!=thisid)
	{
	 	thishref=document.getElementById("id" + thisid);
		arrOldNumber= thisid.split("-");
		OldNumber=parseInt(arrOldNumber[arrOldNumber.length-1]);
		
		OurNewNumber=parseInt(OldNumber)+1;
		//alert(OldNumber + " " + OurNewNumber);
		parenttr=ClimbTreeToTR("id" + thisid);
		//alert("id" + thisid);
		ourTRClass=parenttr.className;
		
		newTR=document.createElement('tr');
		
		parentofTRs= GetParent(parenttr);
	 
		clone=parenttr.cloneNode(true);
	 
		clone.style.backgroundColor='';
		thesechildren=clone.childNodes;
	 
	 	//alert(parentofTRs.getElementsByTagName("tr").length);
		ourNewClass=secondrow ;
		if(OldNumber!=0  )
		{
			ourNewClass=Alternate(firstrow, secondrow, ourTRClass);
	 	}
	 	if(OldNumber==0 &&  parentofTRs.getElementsByTagName("tr").length/2==parseInt(parentofTRs.getElementsByTagName("tr").length/2))
		{
			ourNewClass=firstrow;
	 	}
		//alert(thisid);
		MARenumberHenceforth("id" + thisid, "");
		 
		for(j=0; j<thesechildren.length; j++)
		{
	 
			if (thesechildren[j].nodeName.toLowerCase()=="td")
			{
				these2children=thesechildren[j].childNodes;
				
				if (thesechildren[j].style && !these2children[0].nodeName.toLowerCase()=="span")
				{
					//at the beginning of the fields, the first model of a row will be hidden and we have to unhide the clone
					thesechildren[j].style.display='';
				}
	
				for(k=0; k<these2children.length; k++)
				{
					if (these2children[k].nodeName.toLowerCase()=="label")
					{
						thesechildren[j].removeChild(these2children[k]);
					}
					if(these2children[k].nodeName.toLowerCase()=="a")
					{
						//alert(these2children[k].href);
						if (these2children[k].href.indexOf("addQrow")>0)
						{
							//alert("'addfield-" + OurNewNumber + "'");
							these2children[k].href="javascript: addQrow('addfield-" + OurNewNumber + "')";
							these2children[k].id="id" + "addfield-"  + OurNewNumber;
						}
	
						else if (these2children[k].name.indexOf("-")>0)
						{
						//alert("'zzzz" + OurNewNumber + "'");
							arrName=these2children[k].name.split("-");
							
							these2children[k].name=arrName[0] + "-" + OurNewNumber ;
							these2children[k].id="id" + arrName[0] + "-" + OurNewNumber ;
						}		
					}
					
					if(these2children[k].nodeName.toLowerCase()=="input"   || these2children[k].nodeName.toLowerCase()=="textarea" || these2children[k].nodeName.toLowerCase()=="select"  )
					{
	
					 
						if (these2children[k].style.display=="none" && these2children[k].name!=  "x_group_id[]" && these2children[k].name.indexOf("wapfield")<1)
						{
						 	
							//these2children[k].type="text";
							//fucking IE!!!
							these2children[k].style.display="";
						 
							
						}
						if(these2children[k].name==  "x_group_id")
						{
							these2children[k].value="";
						}
						//alert (these2children[k].name);
						 
						 
						these2children[k].value="";
						 
						if (these2children[k].id.indexOf("swapfieldd")>0)
						{
							these2children[k].name=  "swapfieldd-"  + OurNewNumber;
							these2children[k].id="id" + these2children[k].name;
							
						
						}
						else if (these2children[k].name.indexOf("-")>0)
						{
							arrName=these2children[k].name.split("-");
							these2children[k].name=arrName[0] + "-" + arrName[1] + "-" + OurNewNumber;
							//old way, without the x-y thing: these2children[k].id="id" + arrName[0] + "-" + OurNewNumber ;
							these2children[k].id="id" + arrName[0] + "-" +  arrName[1] + "-" + OurNewNumber;
						}		
					}
					else if (these2children[k].nodeName.toLowerCase()=="span" )//cant believe i have to do this
					{
						these3children=these2children[k].childNodes;
						for(m=0; m<these3children.length; m++)
						{
							if(these3children[m].nodeName.toLowerCase()=="input"   || these3children[m].nodeName.toLowerCase()=="textarea" || these3children[m].nodeName.toLowerCase()=="select"  )
							{
								these3children[m].value="";
							}
						}
					 	//alert (these2children[k].name + " " + these2children[k].nodeName );
					}
					 
				}
			}
	 
		}
	 
		//for some reason in firefox we run into trouble if i don't put some white space around the newly-inserted TRs.  wsp is the whitespace that fixes this
	
	 
		clone.className=ourNewClass;
		
		wsp=document.createTextNode("\n");
		
		insertAfter(parentofTRs, wsp, parenttr);
		insertAfter(parentofTRs, clone, parenttr);
		insertAfter(parentofTRs, wsp, parenttr);
		MAtrselect("idswapfieldd-"  + OurNewNumber, thisset);
		FocusFirstFormItem("idswapfieldd-"  + OurNewNumber, thisset);
		//increment our tally of rows
		document.BForm[qpre + "fieldcount"].value=parseInt(parseInt(document.BForm[qpre + "fieldcount"].value)+1);
		//alert(document.BForm[qpre + "fieldcount"].value);

		overinsertprevent=thisid;
	}
	else
	{
		alert("You must edit your new inserted item before you can insert another.");
	
	}
	//take this shit out when we do a real project!
	HideAllButLastNew();
}

function GenerateXIDstring(thisid)
{
	var thesechildren, these2children, parentnode, j, k, arrName;
	var out="";
	//alert(thisid);
	//alert(document.BForm["x_xlist"].value);
	out=document.BForm["x_xlist"].value;
	if(out=="")
	{
		parentnode=ClimbTreeToTR(thisid);
		thesechildren=parentnode.childNodes;
		for(j=0; j<thesechildren.length; j++)
		{
				if (thesechildren[j].nodeName.toLowerCase()=="td")
				{
					these2children=thesechildren[j].childNodes;
					for(k=0; k<these2children.length; k++)
					{
						if (these2children[k].nodeName.toLowerCase()=="input"  || these2children[k].nodeName.toLowerCase()=="textarea" || these2children[k].nodeName.toLowerCase()=="select")
						{
							arrName=these2children[k].name.split("-");
							if(arrName[1]!=undefined && arrName[2]!=undefined )
							{
								out=out + "|" + arrName[1];
							}
						}
					}
					
				}
		}
		out=out.substring(1);
		document.BForm["x_xlist"].value=out;
	}
	//alert(out);
	return out;
}

function MARenumberHenceforth(thisid, mode)
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
	var firstrow="firstrow";
	var secondrow="secondrow";
	OurNumber=thisid.substring(11);
	
	strXIDs=GenerateXIDstring(thisid);
 
	//alert(OurNumber + " strXIDs:" + strXIDs);
	thishref=document.getElementById(thisid);
	ourTR= ClimbTreeToTR(thisid);
	if(ourTR)
	{
		ourTRClass=ourTR.className;
		MasterParent=GetParent(ourTR);
	}
	if(MasterParent)
	{
		tagarray=MasterParent.getElementsByTagName("tr");

		//alert(ourTRClass);
		message="";
		if (mode=="delete")
		{
			topLimit=parseInt(parseInt(OurNumber)-1);
		}
		else
		{
			topLimit=parseInt(OurNumber);
		
		}
 		if(mode=="delete" &&(tagarray.length-OurNumber)/2!=parseInt((tagarray.length-OurNumber)/2)  )
		{
			ourTRClass=Alternate(firstrow, secondrow, ourTRClass);
		}
		if((tagarray.length-OurNumber)/2==parseInt((tagarray.length-OurNumber)/2)    )
		{
			ourTRClass=Alternate(firstrow, secondrow, ourTRClass);
		}
		//if(OurNumber==0)
		//{
			//ourTRClass=Alternate(secondrow, firstrow,ourTRClass);
		//}
		if (mode=="delete")
		{
			//for deletes we have to go from zero to the top
		
			for(i=OurNumber; i<tagarray.length; i++)
			{
				//now we have to renumber all the a hrefs inside the trs to keep it all dynamic
				MARenumberRow(mode, i, strXIDs, ourTRClass);
				ourTRClass=Alternate(secondrow,firstrow, ourTRClass);
				

				
			}
		}
		else
		{
			for(i=tagarray.length; topLimit<i; i--)
			{
				//now we have to renumber all the a hrefs inside the trs to keep it all dynamic
				MARenumberRow(mode, i, strXIDs, ourTRClass); 
				ourTRClass=Alternate(secondrow,firstrow, ourTRClass);
				
				
			}
		}
	}
	//if (mode=="delete")
	//{
	//	document.BForm[qpre + "fieldcount"].value= parseInt(document.BForm[qpre + "fieldcount"].value) - 1;
	//}
	//else
	//{
		//document.BForm[qpre + "fieldcount"].value= parseInt(document.BForm[qpre + "fieldcount"].value) + 1;
	
	//}
}

function MARenumberRow(mode, intIn, strXIDs, ourTRClass)
{
	var intNew, thisatagid;
	var j=0, k=0;
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
 
		strTargets="grid|addfield|swapfieldd";
		arrTargets=strTargets.split("|");
		//alert(strXIDs);
		arrXIDs=strXIDs.split("|");
		for(j=0; j<arrTargets.length; j++)
		{
			
			for(k=0; k<arrXIDs.length; k++)
			{
			
				thisatagid="id" + qpre + arrTargets[j] + "-" +  arrXIDs[k] + "-" +  intIn;
				//if (arrTargets[j]=="addfield")
				//{
				//alert(thisatagid);
				//}
				thisatagelement=document.getElementById(thisatagid);
				//alert(thisatagid);
				if(thisatagelement)
				{
					thisatagelement.name=qpre + arrTargets[j] + "-" +arrXIDs[k] + "-" +  intNew ;
					thisatagelement.id="id" + thisatagelement.name;
				}
				else if (document.getElementById("id" + arrTargets[j] + "-" +  intIn))
				{
					
					thisatagid="id" + arrTargets[j] + "-" +  intIn;
					//alert(thisatagid);
					thisatagelement=document.getElementById(thisatagid);
					thisatagelement.name= arrTargets[j] + "-" + intNew;
					//alert("before:" + thisatagelement.id);
					thisatagelement.id="id" + arrTargets[j] + "-" + intNew;
					//alert("after:" +thisatagelement.id);
				
					if(thisatagelement.href)
					{
						thisatagelement.href="javascript: addQrow('addfield-" +  intNew + "')";
						ourTR= ClimbTreeToTR(thisatagelement.id);
						ourTR.className=ourTRClass;
					}
					
					
				
				}

			}
			
		}
		 				 
	}
}



function glow(obj, typer)
{
	if(document.getElementById(obj))
	{
		obj=document.getElementById(obj);
	}
	if(typer=="on")
	{
		obj.style.opacity=".66";
		obj.style.filter='alpha(opacity=44)';
		//obj.style.alpha.opacity="66";
	}
	else
	{
		obj.style.opacity="1";
		obj.style.filter='alpha(opacity=100)';
		//obj.style.alpha.opacity="100";
	}
}

function HideAllButLastNew()
{
	var thiscount=document.BForm[qpre + "fieldcount"].value;
	var i;
 
	for(i=0; i<thiscount; i++)
	{
		
		thisimage=document.getElementById("idaddfield-" + i);
		thisimage.childNodes[0].style.display="none";
		//alert(thisimage.childNodes[0].nodeName);
	
	}

}

function groovify(obj, color)
{
	//overinsertprevent=0;
	obj.style.border="0.02cm groove " + color;
	if(document.all)
	{
		//obj.style.padding="12pt";
		//obj.style.fontSize="12pt";
		obj.style.filter='alpha(opacity=100)';
	}
	 
}

function degroovify(obj)
{
	obj.style.border="0.02cm dotted white";
	if(document.all)
	{
		obj.style.fontSize="";
		obj.style.padding="";
		obj.style.filter='alpha(opacity=100)';
	}
	
}



