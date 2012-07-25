 //This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

var qpre="x_";

function GetFormItemValue(formname, itemname, isdatecomplex)
//works with selects, textareas, text inputs, checkboxes, or radio button arrays
{
	itemobj=document[formname][itemname];
	if(isdatecomplex==true)
	{
	
		strpre=qpre + itemobj ;
		if(itemobj[strpre + "|month"]  && itemobj[strpre + "|year"]  && itemobj[strpre + "|day"])
		{
			if(itemobj[strpre + "|month"].selectedIndex  && itemobj[strpre + "|year"].selectedIndex && itemobj[strpre + "|day"].selectedIndex)
			{
				return itemobj[strpre + "|month"].selectedIndex.value + "-"  + itemobj[strpre + "|day"].selectedIndex.value + "-" + itemobj[strpre + "|year"].selectedIndex.value;
			}
		}
	
	}
	{
		if (document[formname][itemname])
		{
			if(itemobj.selectedIndex)
			{
				return itemobj[itemobj.selectedIndex].value;
			
			}
			else
			{
				return itemobj.value;
			
			}
		
		}
	}
	return "";
}


function GetQueryString(strURL)
{
	if(strURL.indexOf("?")>-1)
	{
		var arrThis = strURL.split("?");
		var strQS=arrThis[1];
	}
	else
	{
		var strQS=false;
	}
	return strQS;
}

function ReplaceQueryString(strURL, strNewQS)
{
	if(strURL.indexOf("?")>-1)
	{
		var arrThis = strURL.split("?");
		var strNonQS=arrThis[0];
	}
	else
	{
		var strNonQS=strURL;
	}
	return strNonQS + "?" + strNewQS;
}

function GetQueryStringVariable(strURL, strVarName)
{
	if(strURL.indexOf("?")>-1)
	{
		var arrThis = strURL.split("?");
		var strQS=arrThis[1];
		var arrPairs = strQS.split("&");
		var i;
		for (i=0; i<arrPairs.length; i++)
		{
			var thisPair = arrPairs[i].split("=");
			var thisName = thisPair[0];
			var thisValue = thisPair[1];
			if(thisName==strVarName)
			{
				return thisValue;
			}
		}
 
	}
	return false;
}


function ReplaceQueryStringVariable(strQuery, strName, newValue, newName, bwlEliminatePair)
{
	if(strQuery.indexOf("?")==0)
	{
		strQuery = strQuery.substring(1);
	}
	var strOut="";
	var arrPairs = strQuery.split("&");
	var i;
	for (i=0; i<arrPairs.length; i++)
	{
	     var thisPair = arrPairs[i].split("=");
	     var thisName = thisPair[0];
	     var thisValue = thisPair[1];
		 if(thisName!=strName)
		 {
			 strOut=strOut+ "&" +  thisName + "=" + thisValue;
		 }
		 else if(bwlEliminatePair)
		 {
		 	//skipwinkle
		 }
		 else if(newName)
		 {
		 	strOut=strOut+ "&" +  newName + "=" + newValue;
		 }
		 else if(newValue)
		 {
		 	strOut=strOut+ "&" +  thisName + "=" + newValue;
		 }
	}
	strOut = strOut.substring(1);
	return strOut;
}

function AddLabelLinkUpdateToPulldown(selectname)
{
	var linknode=document.getElementById("idl-" + selectname);
	var selectnode=document.getElementById("id" + selectname);
	//i have to add the event to the label link, not the select, since the select could have an onchange event from multitable stuff
	linknode.onclick=function()
	{
		var linkhref=linknode.href;
		var linkqs=GetQueryString(linkhref);
		var liveid=selectnode[selectnode.selectedIndex].value;
		linkqs=ReplaceQueryStringVariable(linkqs, selectname, liveid);
		
		var newurl=ReplaceQueryString(linkhref, linkqs);
		//alert(newurl);
		linknode.href=newurl;
	}
}

function AddMultitableEventToSelect(selectid, db, table, selecttorepopulate, pkofremote, namefield, namefield2, rtable, rtablepkname, rtableresultfield)
{
	var thisselect=document.getElementById(selectid);
	var selectname=thisselect.name;
	var strOurFormName=thisselect.form.name;
	thisselect.onchange=function()
	{
		var thisselectvalue=thisselect[thisselect.selectedIndex].value;
		var str=db +"|" + table + "|" + pkofremote  + "|" + selecttorepopulate + "|" + namefield+"|" + namefield2 + "|" + thisselectvalue; 
		str=str + "|" + rtable +"|" + rtablepkname +"|" + rtableresultfield;
		frames['ajax'].location.href='dropdownrebuilder.php?' + qpre + "backfielddata=" + str;
	}

}

function ClimbTreeToTR(thisId)
//returns the node of the nearest <TR> HTML tag above our element described by thisId
//gus mueller june 12 2006
{
	var i=0;
	var thisItem=document.getElementById( thisId);
	//we loop through a max of ten times and if there's no tr by then there's not gonna be one
	for(i=0; i<10; i++)
	{
		thisItem= GetParent(thisItem);
		if (thisItem)
		{
			if (thisItem.nodeName.toLowerCase()=="tr")
			{
				return thisItem;
			}
		}
	}
}

function ClimbTreeToTRFromObj(thisItem)
//returns the node of the nearest <TR> HTML tag above our element described by thisId
//gus mueller june 12 2006
{
	var i=0;
	//we loop through a max of ten times and if there's no tr by then there's not gonna be one
	for(i=0; i<10; i++)
	{
		
		thisItem= GetParent(thisItem);
		if (thisItem)
		{
			if (thisItem.nodeName.toLowerCase()=="tr")
			{
				return thisItem;
			}
		}
	}
}


function Alternate(strOptionOne, strOptionTwo, strOptionNow)
{
	//swap between two strings 
	if (strOptionOne== strOptionNow)
	{
		return strOptionTwo;
	}
	return strOptionOne;

} 


function ClimbTreeToTRW(thisId, thisWindow)
//returns the node of the nearest <TR> HTML tag above our element described by thisId based on the window
//gus mueller june 12 2006
{
	var i=0;
	var thisItem=thisWindow.document.getElementById( thisId);
	//we loop through a max of ten times and if there's no tr by then there's not gonna be one
	for(i=0; i<10; i++)
	{
		
		thisItem= GetParent(thisItem);
		if (thisItem)
		{
			if (thisItem.nodeName.toLowerCase()=="tr")
			{
				return thisItem;
			}
		}
	}
}

function insertAfter(parent, node, referenceNode) 
{



	parent.insertBefore(node, referenceNode.nextSibling);
}

function deleteconfirm()
{
	return confirm("Do you really want to delete this?")
	
}

function tableconfirm(act, table)
{
	return confirm("Do you really want to " + act + " " + table + "?")
	
}


function Establish(strIn)
//returns "" if undefined - extremely useful!
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

function editselected(obj, url)
{
	var iLen=obj.length;
	var id;
	for (i=0; i<iLen; i++)
		{
		if (obj[i].selected)
			{
				id=  obj[i].value;
			}
		}
	if (id>-1)
	{
		remote = window.open(url + id,"_new","menubar=yes,height=600,width=800,scrollbars=yes");
	}
	return false;
}







function betterparseInt(strIn, startdelimiter)
{
	//parses a string for the first available positive integer, starting on the left
	//if startdelimiter is set, then begin looking after that is found.
	var i;
	var out="";
	var bwlOkay=false;
	if (startdelimiter=="")
		{
			bwlOkay=true;
		
		}
	for (i=0; i<strIn.length; i++)
	{
		thischar=strIn.substring(i, i+1);
		if (parseInt(thischar)==thischar && bwlOkay )
		{
			out+=thischar;
		}
		else if (thischar==startdelimiter)
		{
			bwlOkay=true;
		}
		else if (out!="")
		{
  
			return(parseInt(out));
		 
		}
		
	
	}
	if (out!="")
	{
		return parseInt(out);
	}
	else
	{
		return "";
	}

}

function trimEndDelimiters(strIn, chrDelimiter)
{
	var out=strIn;
	 if (out.substring(0,1)==chrDelimiter)
	 {
	 	
	 	out=out.substring(1,out.length);
	 }
	 if (out.substring(out.length-1,out.length )==chrDelimiter)
	 {
	 	
	 	out=out.substring(0,out.length-1);
	 }
	 return out;
}

function insertintoDelimitedString(strData, strToInsert, rowDelimiter, fieldDelimiter, intNumericField, intThisNumber)
//pass in a double-delimited data string, a string to add, the field containing the numeric key of the data, and the //the numeric place in the data to insert it.
{

	var i=0;
	var out="";
	var strToInsert=trimEndDelimiters(strToInsert, rowDelimiter);
	var strData=trimEndDelimiters(strData, rowDelimiter);
	var bwlDone=false;
	//alert( strData);
	arrOriginalData=strData.split(rowDelimiter);
	//alert ("}" + strData);
	for (i=0; i<arrOriginalData.length; i++)
	{
	
		strThisOriginalRow=arrOriginalData[i];
		//alert("#" +strThisOriginalRow);
		arrOriginalRowData=strThisOriginalRow.split(fieldDelimiter);
		if (intThisNumber==0 && i==0)
		{
			out=out + rowDelimiter +  strToInsert;
			bwlDone=true;
		}
		out=out + ""  + rowDelimiter + "" +  strThisOriginalRow;
		//alert("*" + betterparseInt(arrOriginalRowData[intNumericField],"") + "-" + parseInt(intThisNumber));
		if (betterparseInt(arrOriginalRowData[intNumericField],"")==parseInt(intThisNumber) && !bwlDone)
		{
			//alert("!");
			out=out + rowDelimiter +  strToInsert;
			bwlDone=true;
		}
	//alert("cc" + out + "---delimiter: " +rowDelimiter);
	
	}
	out=trimEndDelimiters(out, rowDelimiter);
	 //alert (strData + "\n" + strToInsert + "\n" + intThisNumber + "\n" + out);
	return out;
}

function getFromFormIfExists(strFormItemName)
{
 
	if (eval("document.BForm." + strFormItemName))
		{
			return eval("document.BForm." + strFormItemName + ".value;");
		}
	else
	{
		return "";
	}
}

 


function addIndexRadio(idnum)
{
	var html=document.createElement('input');
	html.setAttribute("type", "radio");
	html.setAttribute("name", "indexval");
	html.setAttribute("value", idnum);
	return html;

}
 

function aCreate(obj)
{
    var iIndex=obj.length;
    aEditWindow(obj, iIndex, "");
    return false;
}


function aEdit(obj)
{
    if (obj.selectedIndex>-1)
	{
    	var iIndex=obj.selectedIndex;
        var text=obj[iIndex].text;
        aEditWindow(obj, iIndex,text);

    }
    return false;
}

function aDelete(obj)
{
    var iIndex=obj.selectedIndex;
    deletelistitem(obj, iIndex);
    return false;

}
 
function UpdateOpener()
{
	//sends data back to the opener window after things are altered in a launched window
	targetofnewstuff=opener.document.BForm[qpre + "newitemid"].value;
	idfrominsert=opener.document.BForm[qpre + "idfrominsert"].value;
	frontendlist=opener.document.BForm[qpre + "frontendlist"].value;
	dropdowntextvalue=opener.document.BForm["ret_" + qpre + "dropdowntextvalue"].value;
	arrfel=frontendlist.split("|");
	newid=opener.document.BForm["ret_" + arrfel[1]].value;
	newtext=opener.document.BForm["ret_" + arrfel[2]].value;
	if (newtext=="")
	{
		//i calculate the text for the name link in cases where it's a crazy join
		//to set this up i had to include a hack into validate_form()
		newtext=genericdata(arrfel[1],0, 1, dropdowntextvalue, "~", "|");
	
	}
	
	ThisNumber=parseInt(targetofnewstuff.substring(11));
	Thisparenttr=ClimbTreeToTRW(targetofnewstuff, opener);
	//dont want to do this if we're at the end of the range
 	if (Thisparenttr)
	{
		thischildren=Thisparenttr.childNodes;
		 
		for(j=0; j<thischildren.length; j++)
		{
			//alert(j);
			if (thischildren[j].nodeName=="TD")
			{
				these2children=thischildren[j].childNodes;
				if(IsNumeric(thischildren[j].innerHTML))
					//replace the id in the list
					{
						thischildren[j].innerHTML=newid;
					
					
					}
					
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
						if (these2children[k].href.indexOf("editItem")>0)
						{
							//these2children[k].href=these2children[k].href.replace('editItem' + ThisNumber, 'editItem' + ThatNumber);
			
							//these2children[k].id="id" + "editItem"  + ThatNumber;
							//alert(these2children[k].innerHTML);
							these2children[k].innerHTML=newtext;
							searchstring="editItemG('";
							startpoint=these2children[k].href.indexOf(searchstring)+searchstring.length;
							endpoint=these2children[k].href.indexOf("'",startpoint );
							oldid=these2children[k].href.substring(startpoint, endpoint);
							//alert(oldid + " " + newid);
							these2children[k].href=these2children[k].href.replace(searchstring + oldid + "'", searchstring + newid + "'")
						}
					}
					else if(these2children[k].nodeName=="INPUT")
					{
						
						//these2children[k].value="";
						if (these2children[k].name.indexOf("pkid")>0)
						{
							these2children[k].value= idfrominsert;
							//these2children[k].id="id" + "swapItemd"  + ThatNumber;
							//alert("swapItemd"  + ThatNumber);
						}

					}
 	
					 
				}
			}
	 
		}
	
		window.close();
	}
	
}
 
 
function IsNumeric(sText)
{
   var ValidChars = "0123456789.\n\l ";
   var IsNumber=true;
   var Char;

 	if (sText)
	{
	   for (i = 0; i < sText.length && IsNumber == true; i++) 
	      { 
	      Char = sText.charAt(i); 
	      if (ValidChars.indexOf(Char) == -1) 
	         {
	         IsNumber = false;
	         }
	      }
	   return IsNumber;
   }
   else
   {
   		return false;
   }
}

   
function popwindowwithconfirm(url, height, item, method)
{

    //url="ConfModule.html?cms_module=Questionnaire&cms_template_visible=false&qu_menupage=questionEdit&qu_formid=";
	if (confirm("Are you sure you want to " + method + " the item named \"" +  item +  "\"?"))
	{
		remote = window.open(url,"secondarytool","menubar=yes,height=" +  height + ",width=100,scrollbars=yes");
 	   	remote.focus();
	}
	return false;
}


function recrank(str)
{
	if (parent.foreignstuff)
	{
		parent.foreignstuff.location.href=parent.foreignstuff.location.href;
		clearinabit(5000);
	}
	if (parent.ajax)
	{
		parent.ajax.location.href='dropdownrebuilder.php?' + qpre + "backfielddata=" + str;
		clearinabit(5000);
	}
	else
	{
		simplendup();
		window.close();
	}

}

function simplendup() //closes the window and refreshes the opener
	{
		if (opener)
		{
			//alert("###");
			strBriefURL=opener.location.href 
			if (strBriefURL.indexOf("?")>0)
			{opener.location.href = strBriefURL + "&x=" + sanerand()}
			else
			{opener.location.href = strBriefURL + "?x=" + sanerand()}
			window.close()
		}
	}

function sanerand() //returns a random integer between 0 and 1000//
	{
		return parseInt(Math.random()*1000)
	}	

function pickerwindow(db, table, formitem, extrafield, extraid)
{
 	pre="x_";
	height=400;
	width=635;
	url="tablesearcher.php?" + extrafield + "=" + extraid + "&" + pre + "db=" + db + "&" + pre + "table=" + table + "&" + pre + "launcherfield=" + formitem;
	remote = window.open(url,"picker" + db + table,"menubar=yes,height=" +  height + ",width=" +  width + ",scrollbars=yes");
    remote.focus();
	return false;
}


function help(db, table, field)
{
 	pre="x_";
	height=400;
	width=635;
	url="help.php?" + pre + "db=" + db + "&" + pre + "table=" + table + "&" + pre + "field=" + field;
	remote = window.open(url,"help" + db + table,"menubar=yes,height=" +  height + ",width=" +  width + ",scrollbars=yes");
    remote.focus();
 
}

function editpopup(db, table, idfield, id, arrNames , arrValues, behave,  kosherfields, widthguidance, heightguidance)
{
 	pre="x_";
	if(!heightguidance)
	{
		height=400;
	}
	else
	{
		height=heightguidance;
	}
	if(!widthguidance)
	{
		width=600;
	}
	else
	{
		width=widthguidance;
	}
	
	extravars="";
	if(arrNames)
	{
 
		for (i=0; i<arrNames.length; i++)
		{
			extravars=extravars + "&" + arrNames[i] + "=" + escape( arrValues[i]);
		
		}
	}
	url="tableform.php?" + pre + "behave=closeclickrecycle" +  behave   + "&" + pre + "kosherfields=" + kosherfields + "&" + pre + "mode=edit&" + pre + "db=" + db + "&" + pre + "table=" + table + "&" + pre + "idfield=" + idfield + "&" + idfield + "=" + id + extravars;
    //url="ConfModule.html?cms_module=Questionnaire&cms_template_visible=false&qu_menupage=questionEdit&qu_formid=";
	remote = window.open(url,"editor" + db + table,"menubar=yes,height=" +  height + ",width=" +  width + ",scrollbars=yes");
    remote.focus();
	//return false;
}

function clearinabit(milliseconds)
{
	setTimeout('window.location.href=\"message.php\"',milliseconds);
}

function closefeedbackdiv()
{
	thisobj=document.getElementById("idfeedback");
	thisParent= GetParent(thisobj);
	thisParent.removeChild(thisobj);
}

function closeothertools()
{
	thisobj=document.getElementById('idothertools'); 
	thisParent= GetParent(thisobj);
	thisParent.removeChild(thisobj);
}

function setupclearfeedback()
{
	var arrFeedback=document.getElementsByTagName("div");
	var feedbackdiv = false;
	for(i=0; i<arrFeedback.length; i++)
	{
		var thisattrib=arrFeedback[i].getAttribute("class");
		if(thisattrib=="feedback")
		{
			feedbackdiv=arrFeedback[i];
		}
	}
	if(feedbackdiv)
	{
		feedbackdiv.id="idfeedback";
		feedbackdiv.innerHTML+="<div align=\"right\">[<a href=\"javascript: closefeedbackdiv()\">close</a>]";
 	}
}

globaltableeditorstatus="open";

function TextAreaScan()
{
	var milliseconds=500;
	var arrTA=document.getElementsByTagName("textarea");
	//alert(document.parentWindow.name);
	var widthdivisor=10;
	if(document.parentWindow  )
	{
		ourwindow=document.parentWindow;
		windowidth=document.body.offsetWidth;
 		
	}
	else if(document.defaultView  )
	{
		ourwindow=document.defaultView;
		windowidth=ourwindow.innerWidth;
	}
	else
	{
		windowidth=ourwindow.document.body.offsetWidth;
	}	

	
	textareawidth=windowidth/widthdivisor;
	if(ourwindow["secondarytool"])
	{
		//alert(ourwindow["secondarytool"].width);
		//ourwindow["secondarytool"].width=windowidth-360;
		
		if(document.getElementById("idsecondarytool").width)
		{
			//alert(windowidth);
			document.getElementById("idsecondarytool").width=windowidth-360;
		}
		//ourwindow["secondarytool"].window.innerWidth=windowidth-360;
	}
	for(i=0; i<arrTA.length; i++)
	{
		thisvalue=arrTA[i].value;
		thislen=thisvalue.length;
		thiscols=arrTA[i].cols;
		arrRows=thisvalue.split("\n");
		thisrows= thislen/thiscols + arrRows.length;
		arrTA[i].cols=	textareawidth;
		if(thisrows<30 )
		{
			arrTA[i].rows=thisrows;
			
			//specific for wysiwygpro:
			//thisname=arrTA[i].name;
			//wysiwygproid=thisname + "_editFrame";
			//wysiwygproiframe=document.getElementById(wysiwygproid);
			//if(wysiwygproiframe)
			//{
				//alert("!");
				//wysiwygproiframe.height=thisrows*12;
			//}
		
		}
		//next maybe switch back and forth between inputs and textareas

	
	}
	//var arrTable=document.getElementsByTagName("table");
	//for(i=0; i<arrTable.length; i++)
	//{
		//thisheight=arrTable[i].getAttribute("height");
		//if(thisheight==167)
		//{
			//alert("$$");
			//arrTable[i].height=500;
			//arrTable[i].setAttribute("height", 500);
		//}
	//}
	setTimeout('TextAreaScan();',milliseconds);

}



function changetableeditorcollapse()
{
	var arrTR=document.getElementsByTagName("tr");
 	thisiframe=document.getElementById("idsecondarytool");
	for(i=0; i<arrTR.length; i++)
	{
		thisTRClass=arrTR[i].getAttribute("class");
		if(thisTRClass)
		{
			if(thisTRClass.indexOf("first")>-1  || thisTRClass.indexOf("second")>-1  || thisTRClass.indexOf("line")>-1 )
			{
			 
				if(arrTR[i].style.display=='none')
				{
					arrTR[i].style.display='';
				}
				else
				{
					arrTR[i].style.display='none';
				}
		 
			}
		}

	}
	if(globaltableeditorstatus=="open")
	{
		globaltableeditorstatus="closed"
		
		thisiframe.height=700;
	}
	else
	{
		globaltableeditorstatus="open"
		thisiframe.height=400;
	}
}

function openeditor(tablename)
{
	if (foreignstuff.window.document)
	{
	 
		confirm('Are you certain you want to update this ' + tablename + ' while an associated editor is still open?  Changes made on that editor will be lost.');
		return true;
		 
	}
	else
	{
		return true;
	}
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
	
	
	
function validate_form()
{
	///alert(validationconfig);
	var thisrow="", nextnextvalidata=0;
	var validatatag="<validata/>";
	var bwlDone=false;
	var nextvalidata=0;
	var p=0;
	var namer, typer, regex;
	var message="";
	//var delimiter=String.fromCharCode(160) ;
	var delimiter="~";
	//alert(delimiter);
	//nextvalidata=validationconfig.indexOf(validatatag, nextvalidata) ;
	while(!bwlDone)
	{
		//alert(nextvalidata );
		nextnextvalidata=validationconfig.indexOf(validatatag, nextvalidata );
		if (isNaN(nextnextvalidata)  || nextnextvalidata<0)
		{
			//nextnextvalidata=validationconfig.length;
			bwlDone=true;
		}
		else
		{
			thisrow=validationconfig.substring(nextvalidata, nextnextvalidata);
			//alert(thisrow);
			arrValid=thisrow.split(delimiter);
			//code to deal with the prospect of the regular expression containing the delimiter I'm using
			//in such a case I need to put the delimiters back in and unsplit the regular expression part of the array
			if (arrValid.length>3)
			{
				for(p=4; p<arrValid.length; p++)
				{
					arrValid[3]+=delimiter + arrValid[p];
				
				}
			
			}
			namer=arrValid[0];
			typer=arrValid[1];
			friendly=arrValid[2];
			regex=arrValid[3];
			RegularExpression  =  new RegExp(regex);
			//alert(typer);
			if (!RegularExpression.test(document.BForm[namer].value))
			{
				if (parseInt(typer)==0)
				{
				
				}
				else if (parseInt(typer)==2  && document.BForm[namer].value!=""  || parseInt(typer)==3)
				{
					//alert(regex);
					message=  message +  "You must supply a valid " + friendly + ".\n";
					skiptest=true;
				}
			}
			else
			{
			
	
				if (parseInt(typer)==5  && document.BForm[namer].value!=""  || parseInt(typer)==4)
				{
					//alert(regex);
					message=  message +  "You must supply a valid " + namer + ".\n";
					skiptest=true;
				}
			
			}
			//alert(namer + "\n" + typer + "\n" + regex);
			nextvalidata=nextnextvalidata + validatatag.length;
		}
		
	 
	}
	if (message!="")
	{
		
		alert(message);
		return false;
	}
	else
	{
		return true;
	}
}
 
function popwindow(url, height)
{

    //url="ConfModule.html?cms_module=Questionnaire&cms_template_visible=false&qu_menupage=questionEdit&qu_formid=";
	remote = window.open(url,"secondarytool","menubar=yes,height=" +  height + ",width=300,scrollbars=yes");
    remote.focus();
	return false;
}

function popdetachedwindow(url, height, width)
{

    //url="ConfModule.html?cms_module=Questionnaire&cms_template_visible=false&qu_menupage=questionEdit&qu_formid=";
	remote = window.open(url,sanerand(),"menubar=yes,height=" +  height + ",width=" + width + ",scrollbars=yes");
    remote.focus();
	return false;
}

function deselectall(obj)
{
	if (obj)
	{
		var iLen=obj.length;
		var str="";
		for (i=0; i<iLen; i++)
			{
			obj[i].selected=false;
			}
 
	}
 
	return(true);
}

function dumpwindow(text)
{
	dump = window.open("","_new","menubar=yes,height=800,width=800,scrollbars=yes");
	dump.document.write("<plaintext>" + text);

}

function domdumpwindow()
{
	tagarray=document.getElementsByTagName("body");
	whatwewanttosee=tagarray[0];
	dump = window.open("","_new","menubar=yes,height=800,width=800,scrollbars=yes");
	dump.document.write("<plaintext>" + whatwewanttosee.innerHTML);

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

function alldumpcheckboxes(thisName, shouldcheck, start, end)
{
	var arrThis=document.getElementsByName(qpre + thisName);
	if(start==undefined  || start=="")
	{
		start=0;
	}
	if(end==undefined  || end=="")
	{
		end=arrThis.length-1;
	}

	if (shouldcheck==false)
	{
		shouldcheck="";
	}
	
	for(i=start; i<end+1; i++)
	{
		if(shouldcheck=="rev")
		{
			arrThis[i].checked=!arrThis[i].checked;
		}
		else
		{
			arrThis[i].checked=shouldcheck;
		}
	}
}

function scripthandback(scriptin, php)
{
	scriptin=scriptin.replace(/\^/g, "'");
	php=php.replace(/\^/g, "'");
	parent.document.BForm[qpre + 'actscript'].value=scriptin;
	parent.document.BForm[qpre + 'postrunscript'].value=php;
}









