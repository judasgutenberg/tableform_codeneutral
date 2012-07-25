function concordanceviewer()
{
	height=600;
	width=600;
	maxfield=parseInt(document.BForm[qpre + "maxfield"].value);
	table1=document.BForm[qpre + "table1"].value;
	table2=document.BForm[qpre + "table2"].value;
	db=document.BForm[qpre + "db"].value;
	dests="";
	for(i=0; i<maxfield; i++)
	{
		destselect= document.BForm[qpre + "field_" + i];
		dests=dests + destselect[destselect.selectedIndex].value + "|" + i + "~";
	}
	url="tf_table_concordance_viewer.php?" + qpre + "table1=" + table1 + "&" + qpre + "table2=" + table2 + "&" + qpre + "dests=" + dests; 
	remote = window.open(url,"viewer" + db + table1,"menubar=yes,height=" +  height + ",width=" +  width + ",scrollbars=yes");
}