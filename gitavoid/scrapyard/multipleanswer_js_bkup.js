
function MATRaction(thisaction)
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
					swapQrow("swapfieldd-" + basisid, "swapfieldd-" + parseInt(parseInt(basisid)-1));
					return;
				}
				else if (thisaction=="down")
				{
					swapQrow("swapfieldd-" + basisid, "swapfieldd-" + parseInt(parseInt(basisid)+1));
					return;
				}
				else if (thisaction=="delete")
				{
					MAdeletefield("swapfieldd-" + basisid);
					return;
				}
			}
		}
	}
}
 

function MAtrselect(thisid)
{
	var i, arrID, intID;
	var selectcolor;
	selectcolor='cceeff';
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
		 
	}
	Thisparenttr=ClimbTreeToTR(thisid);
	document.getElementById(thisid).checked=true;
	Thisparenttr.style.backgroundColor=selectcolor;
	
 


}
function MAtrselectfromline(obj)
{
	var MasterParent, j,k, thatchildren, these2children;
	MasterParent=ClimbTreeToTRFromObj(obj);
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
					if (these2children[k].id.indexOf("swapfieldd")>0)
					{
						//alert(these2children[k].id);
						MAtrselect(these2children[k].id);
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
		document.BForm[qpre + "fieldcount"].value=document.BForm[qpre + "fieldcount"].value-1;
		MasterParent=GetParent(parenttr);
		MasterParent.removeChild(parenttr);
		MARenumberHenceforth("idaddfield-" + parseInt(parseInt(thisNumber)+1), "delete");
	}
	
 
}

function swapQrow(thisid, thatid)
{
	var ThisNumber, ThatNumber, Thisparenttr, Thatparenttr, thischildren, thatchildren, j, k, parentofTRs;
	var afterfieldvalue;
	var thisfieldvalue="";
	var afterfieldvalue="";
 
	ThisNumber=parseInt(thisid.substring(11));
	ThatNumber=parseInt(thatid.substring(11));
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
					if (thischildren[j].style)
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
								these2children[k].name=  "swapfieldd-"  + ThatNumber;
								these2children[k].id="id" + "swapfieldd-"  + ThatNumber;
								
							
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
					if (thatchildren[j].style)
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
								these2children[k].name=  "swapfieldd-"  + ThisNumber;
								these2children[k].id="id" + "swapfieldd-"  + ThisNumber;
								
							
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
 
		document.getElementById("idswapfieldd-" + ThisNumber).checked=false;
		document.getElementById("idswapfieldd-" + ThatNumber).checked=true;
		
	
		
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

 


function addQrow(thisid)
{
	var OurNewNumber, OldNumber, parenttr;
	var j, k, p;
 	var firstrow="firstrow";
	var secondrow="secondrow";
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
			if (thesechildren[j].style)
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
				
				if(these2children[k].nodeName.toLowerCase()=="input"   || these2children[k].nodeName.toLowerCase()=="textarea" )
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

				 
			}
		}
 
	}
 
	//for some reason in firefox we run into trouble if i don't put some white space around the newly-inserted TRs.  wsp is the whitespace that fixes this

 
	clone.className=ourNewClass;
	
	wsp=document.createTextNode("\n");
	
	insertAfter(parentofTRs, wsp, parenttr);
	insertAfter(parentofTRs, clone, parenttr);
	insertAfter(parentofTRs, wsp, parenttr);
	MAtrselect("idswapfieldd-"  + OurNewNumber);
	
}

function GenerateXIDstring(thisid)
{
	var thesechildren, these2children, parentnode, j, k, arrName;
	var out="";
	//alert(thisid);
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
	ourTRClass=ourTR.className;

	
	
	MasterParent=GetParent(ourTR);
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



function groovify(obj, color)
{
	obj.style.border="0.01cm groove " + color;
}

function degroovify(obj)
{
	obj.style.border="0.01cm dotted white";
}
