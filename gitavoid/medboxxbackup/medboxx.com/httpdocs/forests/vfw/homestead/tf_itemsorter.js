
function TRactionG(thisaction)
{
	var i;
	tagarray=document.getElementsByTagName("tr");
	for(i=0; i<tagarray.length; i++)
	{
		if(document.getElementById("id" + "swapItemd" + i) )
		{
 			//alert("##exists" + document.BForm["swapItemd" + i].checked);
			if(document.getElementById("id" + "swapItemd" + i).checked==true)
			{
				// alert("##checked");
				basisid=i;
				//alert( "swapItemd" + basisid + " " + "swapItemd" + parseInt(parseInt(basisid)-1) + " " + "swapItemd" + parseInt(parseInt(basisid)+1)) ;
				if (thisaction=="up")
				{
				
					//alert("swapItemd" + basisid + " " + "swapItemd" + parseInt(parseInt(basisid)-1));
					
					swapItemG("swapItemd" + basisid, "swapItemd" + parseInt(parseInt(basisid)-1));
					return;
				
				}
				else if (thisaction=="down")
				{
					//alert("swapItemd" + basisid + " " +   "swapItemd" + parseInt(parseInt(basisid)+1));
					swapItemG("swapItemd" + basisid, "swapItemd" + parseInt(parseInt(basisid)+1));
					return;
				}
				else if (thisaction=="delete")
				{
				
					DeleteItemG("swapItemd" + basisid);
					return;
				}
			}
		}
	}
}

function trselectG(thisid)
{
	var i;
	tagarray=document.getElementsByTagName("tr");
	//alert(thisid);
	 
	for(i=0; i<tagarray.length; i++)
	{
		//alert("swapItemd" + i +  " " + thisid );
		//alert(iswapItemd);
		if(document.getElementById("id" + "swapItemd" + i))
		{
			//if("swapItemd" + i!=thisid)
			{
	 			//alert("off: swapItemd" + i +  " " + thisid );
				//dumpwindow(document.BForm.innerHTML);
				document.getElementById("id" + "swapItemd" + i).checked=false;
			}
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
	Thisparenttr.style.backgroundColor='ccccff';
}

function alldumpcheckboxesG(shouldcheck)
{
	var qpre="x_";
	if (shouldcheck==false)
	{
		shouldcheck="";
	}
	for(i=0; i<document.getElementById("id" + qpre + "Items[]").length; i++)
	{
		document.getElementById("id" + qpre + "Items[]").checked=shouldcheck;
	}
}



function DeleteItemG(thisid)
{
	var parenttr;
	var qpre="x_";
	parenttr=ClimbTreeToTR("id" + thisid);
	//alert(thisid);
	thisNumber=parseInt(thisid.substring(9));
	//alert(thisNumber);
	thisatagid="id" + qpre + "pkid" +  thisNumber;
	//alert(thisatagid);
	Itemvalue=document.getElementById( thisatagid).value;
	if (Itemvalue=="")
	{
		confirmstring="Are you certain you want to delete this unnamed item?";
	}
	else
	{
		confirmstring="Are you certain you want to delete the item number " + Itemvalue + "?";
	}
	if (confirm(confirmstring))
	{
		//alert(thisatagid);
		//thisatagelement=document.getElementByID(thisatagid);
		//alert(qpre + "Item-" + thisNumber);
		killItem=document.getElementById("id" + qpre + "pkid" + thisNumber).value
		document.BForm[qpre + "delete"].value=document.BForm[qpre + "delete"].value + "|" + killItem;
		MasterParent=GetParent(parenttr);
		MasterParent.removeChild(parenttr);
	}
	TBRenumberHenceforthG("idaddItem" + parseInt(parseInt(thisNumber)+1), "delete");
 
}

function swapItemG(thisid, thatid)
{
	var qpre="x_", ThisNumber, ThatNumber, Thisparenttr, Thatparenttr, thischildren, thatchildren, j, k, parentofTRs;
	var afterItemvalue;
	var thisItemvalue="";
	var afterItemvalue="";
	ThisNumber=parseInt(thisid.substring(9));
	ThatNumber=parseInt(thatid.substring(9));
	//alert (ThisNumber +  " " +  ThatNumber);
	//alert (thisid +  " " +  thatid);
	Thisparenttr=ClimbTreeToTR("id" + thisid);
	Thatparenttr=ClimbTreeToTR("id" + thatid);
	//dont want to do this if we're at the end of the range
 	if (Thisparenttr && Thatparenttr  && ThatNumber>0)
	{
		//ThisChecked=document.getElementById("swapItemd" + ThisNumber).checked;
		//ThatChecked=document.getElementById("swapItemd" + ThatNumber).checked;
		thischildren=Thisparenttr.childNodes;
		thatchildren=Thatparenttr.childNodes;
		for(j=0; j<thischildren.length; j++)
		{
			if (thischildren[j].nodeName=="TD")
			{
				these2children=thischildren[j].childNodes;
				if (thischildren[j].style)
				{
					//at the beginning of the Items, the first model of a row will be hidden and we have to unhide the clone
					thischildren[j].style.display='';
				}
				//a hack to make things line up at the beginning of the editor
				if (thischildren[j].id=="killmeonexpand")
				{
					//at the beginning of the Items, the first model of a row will be hidden and we have to unhide the clone
					thischildren[j].style.display='none';
				}
				for(k=0; k<these2children.length; k++)
				{
					//alert(these2children[k].nodeName);
				
					if(these2children[k].nodeName=="A")
					{
						if (these2children[k].href.indexOf("addItem")>0)
						{
							these2children[k].href=these2children[k].href.replace('addItem' + ThisNumber, 'addItem' + ThatNumber);
							these2children[k].id="id" + "addItem"  + ThatNumber;
						}
 
			
						
						else if (these2children[k].href.indexOf("editItem")>0)
						{
							these2children[k].href=these2children[k].href.replace('editItem' + ThisNumber, 'editItem' + ThatNumber);
							these2children[k].id="id" + "editItem"  + ThatNumber;
						}
					}
					if(these2children[k].nodeName=="INPUT")
					{
						
						//these2children[k].value="";
						if (these2children[k].name.indexOf("apItem")>0)
						{
							these2children[k].name= "swapItemd" + ThatNumber;
							these2children[k].id="id" + "swapItemd"  + ThatNumber;
							//alert("swapItemd"  + ThatNumber);
						}
						else if (these2children[k].name.indexOf("Item")>0)
						{
							these2children[k].name=qpre + "Item-" + ThatNumber ;
							these2children[k].id="id" + qpre + "Item-" + ThatNumber ;
						
						}
						else if (these2children[k].name.indexOf("length")>0)
						{
							these2children[k].name=qpre + "length-" + ThatNumber ;
							these2children[k].id="id" + qpre + "length-" + ThatNumber ;
						}

								
						else
						{
							//DONT keep old the way it used to be so we can track location changes
							these2children[k].name=qpre + "pkid" + ThatNumber ;
							these2children[k].id="id" + qpre + "pkid" + ThatNumber ;
						}
					}
					if(these2children[k].nodeName=="SELECT")
					{
						these2children[k].name=qpre + "type-" + ThatNumber ;
						these2children[k].id="id" + qpre + "type-" + ThatNumber ;
						//these2children[k].selectedIndex=-1;
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
					//at the beginning of the Items, the first model of a row will be hidden and we have to unhide the clone
					thatchildren[j].style.display='';
				}
				//a hack to make things line up at the beginning of the editor
				if (thatchildren[j].id=="killmeonexpand")
				{
					//at the beginning of the Items, the first model of a row will be hidden and we have to unhide the clone
					thatchildren[j].style.display='none';
				}
				for(k=0; k<these2children.length; k++)
				{
					//alert(these2children[k].nodeName);
				
					if(these2children[k].nodeName=="A")
					{
						if (these2children[k].href.indexOf("addItem")>0)
						{
							these2children[k].href=these2children[k].href.replace('addItem' + ThatNumber, 'addItem' + ThisNumber);
							these2children[k].id="id" + "addItem"  + ThisNumber;
						}
 
						
						else if (these2children[k].href.indexOf("editItem")>0)
						{
							these2children[k].href=these2children[k].href.replace('editItem' + ThatNumber, 'editItem' + ThisNumber);
							these2children[k].id="id" + "editItem"  + ThisNumber;
						}
						
					}
					if(these2children[k].nodeName=="INPUT")
					{
						
						//these2children[k].value="";
						if (these2children[k].name.indexOf("apItem")>0)
						{
							these2children[k].name= "swapItemd" + ThisNumber  ;
							these2children[k].id="id" + "swapItemd"  + ThisNumber;
							//alert("swapItemd"  + ThisNumber);
						}
						else if (these2children[k].name.indexOf("Item")>0)
						{
							these2children[k].name=qpre + "Item-" + ThisNumber ;
							these2children[k].id="id" + qpre + "Item-" + ThisNumber ;
						
						}
						else if (these2children[k].name.indexOf("length")>0)
						{
							these2children[k].name=qpre + "length-" + ThisNumber ;
							these2children[k].id="id" + qpre + "length-" + ThisNumber ;
						}

						
											
						else
						{
							//DONT keep old the way it used to be so we can track location changes
							these2children[k].name=qpre + "pkid" + ThisNumber ;
							these2children[k].id="id" + qpre + "pkid" + ThisNumber ;
						}
					}
					if(these2children[k].nodeName=="SELECT")
					{
						these2children[k].name=qpre + "type-" + ThisNumber ;
						these2children[k].id="id" + qpre + "type-" + ThisNumber ;
						//these2children[k].selectedIndex=-1;
					}
					 
				}
			}
	 
		}
		
		Thatparenttr.swapNode(Thisparenttr);
		document.getElementById("idswapItemd" + ThisNumber).checked=false;
		document.getElementById("idswapItemd" + ThatNumber).checked=true;
	
		//keep a running account of what things have been moved to where so we can deal with them when we alter the table
		if (parseInt(ThisNumber)>2)
		{
			//alert("%" + qpre + "Item-" + parseInt(parseInt(ThisNumber)-1));
			if (document.getElementById("id" + qpre + "Item-" +  parseInt(parseInt(ThatNumber)-1)))
			{
				afterItemvalue=document.getElementById("id" + qpre + "Item-" +  parseInt(parseInt(ThatNumber)-1)).value;
			}
			//alert("$" + afterItemvalue);
		}
		else
		{
			afterItemvalue="*";
		}
		//alert("&");
		
		if (document.getElementById("id" + qpre + "Item-" + parseInt(ThatNumber)))
		{
			thisItemvalue=document.getElementById("id" + qpre + "Item-" + parseInt(ThatNumber)).value;
		}
		
		//document.BForm[qpre + "repositions"].value=document.BForm[qpre + "repositions"].value + " " + thisItemvalue + "|" + afterItemvalue;
	}
	
	
}


function editItemG(id, idfield, table)
{
	var qpre="x_";
	if (table=="")
	{
		table =document.BForm[qpre + "table"].value;
	}
	if(idfield=="")
	{
		idfield=document.BForm[qpre + "idfield"].value;
	}
	var db=document.BForm[qpre + "db"].value;
 
 
	url="tf.php?" + qpre + "table=" + table + "&" + qpre + "db=" +db + "&" + qpre + "mode=edit" + "&" + qpre + "behave=closeclickrecycle&" + qpre + "idfield=" + idfield + "&" + idfield + "=" + id + "&id=" + id;

	//alert(db);
	height=300;
	width=500;
	remote = window.open(url,"edititem","menubar=yes,height=" +  height + ",width=" + width + ",scrollbars=yes");
	remote.focus();

}



function createItemG(thisid, idfield, table, joinfield, joinvalue, sortfield, filterfield, filterfieldvalue)
{
	var qpre="x_", OurNewNumber, OldNumber, parenttr;
	var j, k;
	var extrapair="";


 	thishref=document.getElementById("id" + thisid);
	
	OldNumber=parseInt(thisid.substring(7));
	OurNewNumber=parseInt(OldNumber)+1;
 	//alert(OldNumber + " " + OurNewNumber);
	parenttr=ClimbTreeToTR("id" + thisid);
	newTR=document.createElement('tr');
	

	TBRenumberHenceforthG("id" + thisid, "");

	parentofTRs= GetParent(parenttr);
	
	clone=parenttr.cloneNode(true);
	
	clone.style.backgroundColor='';
	
	var attrMax = clone.attributes.length
	for(var j = 0; j < attrMax; j++)
   {
    if(clone.attributes.item(j).nodeName == 'class')
       {
        	clone.attributes.item(j).value="bgclassfresh";
       }
   }
   
 
	 
	thesechildren=clone.childNodes;
	
	for(j=0; j<thesechildren.length; j++)
	{
 
		if (thesechildren[j].nodeName.toLowerCase()=="td")
		{
		
			these2children=thesechildren[j].childNodes;
			if (thesechildren[j].style)
			{
				//at the beginning of the Items, the first model of a row will be hidden and we have to unhide the clone
				thesechildren[j].style.display='';
			}
			//a hack to make things line up at the beginning of the editor
			if (thesechildren[j].id=="killmeonexpand")
			{
				//at the beginning of the Items, the first model of a row will be hidden and we have to unhide the clone
				thesechildren[j].style.display='none';
			}
			for(k=0; k<these2children.length; k++)
			{
				//alert(these2children[k].nodeName);
			
				if(these2children[k].nodeName.toLowerCase()=="a")
				{
					if (these2children[k].href.indexOf("addItem")>0)
					{
						these2children[k].href=these2children[k].href.replace("addItem"  + OldNumber, "addItem"  + OurNewNumber);
						these2children[k].id="id" + "addItem"  + OurNewNumber;
						
					}
					else
					{
						//clear text from new items before they are filled out
						these2children[k].innerHTML="";
					}
	
				}
				
				if(these2children[k].nodeName.toLowerCase()=="input")
				{
					 
					these2children[k].value="";
					
					if (these2children[k].name.indexOf("apItem")>0)
					{
						//alert("swapItemd" + OurNewNumber);
						these2children[k].name= "swapItemd" + OurNewNumber ;
						these2children[k].id="id" + "swapItemd"  + OurNewNumber;
						these2children[k].checked=false;
						//alert(these2children[k].name);
						//alert("swapItemd"  + OurNewNumber);
					}				
					else if (these2children[k].name.indexOf("Item")>0)
					{
						these2children[k].name=qpre + "Item-" + OurNewNumber ;
						these2children[k].id="id" + qpre + "Item-" + OurNewNumber ;
					}
					else if (these2children[k].name.indexOf("length")>0)
					{
						these2children[k].name=qpre + "length-" + OurNewNumber ;
						these2children[k].id="id" + qpre + "length-" + OurNewNumber ;
					}
					else
					{
						these2children[k].name=qpre + "pkid" + OurNewNumber ;
						these2children[k].id="id" + qpre + "pkid" + OurNewNumber ;
					}
				}
				if(these2children[k].nodeName.toLowerCase()=="select")
				{
					these2children[k].name=qpre + "type-" + OurNewNumber ;
					these2children[k].id="id" + qpre + "type-" + OurNewNumber ;
					these2children[k].selectedIndex=-1;
				}
				 
			}
		}
 
	}
	//for some reason in firefox we run into trouble if i don't put some white space around the newly-inserted TRs.  wsp is the whitespace that fixes this
	wsp=document.createTextNode("\n");
	insertAfter(parentofTRs, wsp, parenttr);
	insertAfter(parentofTRs, clone, parenttr);
	insertAfter(parentofTRs, wsp, parenttr);

	
	if (table=="" || !table )
	{
		table =document.BForm[qpre + "table"].value;
		
	}
	
	if(idfield==""  || !idfield )
	{
		idfield=document.BForm[qpre + "idfield"].value;
	}
	if (joinfield!="" && joinfield)
	{
		extrapair=extrapair+ "&" + filterfield + "=" + filterfieldvalue;
	}
	var db=document.BForm[qpre + "db"].value;
	url="tf.php?" + qpre   + "noshow=" + sortfield + "&" + qpre + "table=" + table + "&" + qpre + "db=" +db + "&" + qpre + "mode=new" + "&" + qpre + "behave=closeclickrecycleupdateopener" + extrapair;
	//alert(db);
	height=300;
	width=500;
	document.BForm[qpre + "newitemid"].value="id" + "swapItemd"  + OurNewNumber;
	remote = window.open(url,"newitem","menubar=yes,height=" +  height + ",width=" + width + ",scrollbars=yes");
	remote.focus();
}

function TBRenumberHenceforthG(thisid, mode)
{
	//first get the number we're at
	var OurNumber, thisatagid;
	var thishref;
	var ourTR;
	var MasterParent;
	var i;
	var tagarray;
	var qpre="x_";
	var topLimit;
	var intNew=0;

	OurNumber=thisid.substring(9);
	//alert(OurNumber);
	thishref=document.getElementById(thisid);
	ourTR= ClimbTreeToTR(thisid);
	//alert(thisid);
	MasterParent=GetParent(ourTR);
	if(MasterParent)
	{
 		
		tagarray=MasterParent.getElementsByTagName("tr");
		message="";
	
		//alert(OurNumber);
		if (mode=="delete")
		{
			//alert("!");
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
				RenumberRowG(mode, i);
				 
			}
		
		}
		else
		{
			 
			//alert(tagarray.length);
			for(i=tagarray.length; topLimit<i; i--)
			{
				//alert("$");
				//now we have to renumber all the a hrefs inside the trs to keep it all dynamic
				RenumberRowG(mode, i);
				 
			}
		}
	}
	if (mode=="delete")
	{
		document.BForm[qpre + "Itemcount"].value= parseInt(document.BForm[qpre + "Itemcount"].value) - 1;
	}
	else
	{
		document.BForm[qpre + "Itemcount"].value= parseInt(document.BForm[qpre + "Itemcount"].value) + 1;
	
	}
}

function RenumberRowG(mode, i)
{
	var intNew, thisatagid;
	var qpre="x_";
	
	thisatagid="id" + "addItem" + i;
	thisatagelement=document.getElementById(thisatagid);
	//alert(thisatagid);
				//rename!!
	if(thisatagelement)
	{
		//alert(i);
		
		if (mode=="delete")
		{
			//alert("!");
			intNew=parseInt(i-1);
		}
		else
		{
			intNew=parseInt(i+1);
 
		}
		//alert (intNew);
		thisatagelement.name= "addItem" + intNew;
		thisatagelement.id="id" + "addItem" + intNew;
		thisatagelement.href=thisatagelement.href.replace('addItem' +  i,'addItem' +  intNew);
		swapItemid= "id" + "swapItemd" + parseInt(i);
		thisatagelement=document.getElementById( swapItemid);
		thisatagelement.id="id" + "swapItemd" + intNew;
		//alert(thisatagelement.id);
		thisatagelement.name="swapItemd" +  intNew;
		thisatagelement.id="id" + "swapItemd" +  intNew;
		itemid= qpre + "pkid" + parseInt(i);
		//alert(itemid);
		thisatagelement=document.getElementById("id" + itemid);
		thisatagelement.id="id" + qpre + "pkid" + intNew;
		thisatagelement.name=qpre + "pkid" + intNew;			 
	}
}

 