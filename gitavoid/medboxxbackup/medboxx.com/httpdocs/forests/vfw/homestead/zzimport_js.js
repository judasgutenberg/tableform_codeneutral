
function importfieldnames()
{
	fieldcount=document.BForm[qpre + "fieldcount"].value;
	for(i=0; i<fieldcount; i++)
	{
		var val=document.BForm[qpre + "pulldown-" + i][document.BForm[qpre + "pulldown-" + i].selectedIndex].text;
		arrval=val.split(": ");
		val=arrval[1];
		document.BForm[qpre + "newfield-" + i ].value=val;
	 
	}

}

function importfieldnameslc()
{
	fieldcount=document.BForm[qpre + "fieldcount"].value;
	for(i=0; i<fieldcount; i++)
	{
		document.BForm[qpre + "newfield-" + i ].value=document.BForm[qpre + "newfield-" + i ].value.toLowerCase();
	}
}

function checkimportform()
{
	fieldcount=document.BForm[qpre + "fieldcount"].value;
	bwlNoFields=true;
	theseerrors="";
	for(i=0; i<fieldcount; i++)
	{
		if(document.BForm[qpre + "newfield-" + i ].value!="")
		{
			bwlNoFields=false;
		}
	}
	if(document.BForm[qpre + "newtable"].value=="")
	{
	
		theseerrors+="You must give your new table a name.\n";
	}
	if(bwlNoFields)
	{
		theseerrors+="You must provide at least one field name.\n";
	}
	if (theseerrors.length>0)
	{
	
		alert(theseerrors);
		return false;
	}
	return true;
}