function CountWords(formobject, sourcefieldname, destfieldname)
//counts words in one field to populate another with the value of the count
{
	var val=formobject[sourcefieldname].value;
	//alert("-" + val);
	thiscount=CountWorder(val);
	formobject[destfieldname].value=thiscount;

}

function CountWorder(fullStr) 
{
 
	var charCount = fullStr.length;
	var rExp = /[^A-Za-z0-9']/gi;
	var spacesStr = fullStr.replace(rExp, " ");
	var cleanedStr = spacesStr + " ";
	do 
	{
		var old_str = cleanedStr;
		cleanedStr = cleanedStr.replace("  ", " ");
	} 
	while(old_str != cleanedStr);
	
	var splitString = cleanedStr.split(" ");
	var wordCount = splitString.length -1;
	
	if (fullStr.length <1) 
	{
		wordCount = 0;
	}
	return wordCount;
}

function CleanUp (this_field) 
{
	var cleanedStr = this_field.value;
	do {
		var old_str = cleanedStr;
		var dq = String.fromCharCode(34); 
		cleanedStr = cleanedStr.replace("  "," ");
		cleanedStr = cleanedStr.replace("  "," ");
		cleanedStr = cleanedStr.replace(String.fromCharCode(145),"'");
		cleanedStr = cleanedStr.replace(String.fromCharCode(146),"'");
		cleanedStr = cleanedStr.replace(String.fromCharCode(147),dq);
		cleanedStr = cleanedStr.replace(String.fromCharCode(148),dq);
	} 
	while(old_str != cleanedStr);
	document.FORM.TEXT.value=cleanedStr;
}
