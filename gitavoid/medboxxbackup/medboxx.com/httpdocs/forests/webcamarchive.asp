<%option explicit%>
<!--#include virtual="/global/BTG_functions.asp"-->
<!--#include virtual="/c/include/contentLib.asp"-->
<!--#include virtual="/global/wisdom.asp"-->

<%
response.write Main()

function Main()
	dim strOut, rst
	dim strASP
	dim colMedium, colBg
	dim strPageTitle
	dim intDelta
	dim strBarText
	dim strPath
	dim intStart
	dim bwlSuperUser
	
	bwlSuperUser=isSuperUser(UserID)
	response.write userid & "<P>" & bwlSuperUser
	intStart=request("d")
	strPath=request("path")
	if strPath="" then strPath="/members/webcam/archive"
	intDelta=myint(request("r"))
	colBg="ffffff"
	colMedium="0099cc"
	strASP="webcamarchive.asp"
	strPageTitle="View Webcams"
	strPageTitle="Bathtubgirl Webcam Archive Viewer"
	strBarText="<x href=""" & strASP & """>" & strPageTitle & "</x>"    & vbLF
	strOut= LabelBar("940202", "ffffff", strBarText) & strOut
	strOut = strOut & LatestImages(strPath, intDelta, intStart, strASP, bwlSuperUser)
	strOut= FlashHeader() & TableStructure(SiteNav(6, ""),  strOut)
	strOut=bodyWrap(strOut, strPageTitle, "000000", "cccccc", "cccccc", "")
	Main=strOut
end function


function prevnextwebcam(strASP, intDelta, strPath, strLowDateCode, strHighDateCode)
	dim strOut
	if strLowDateCode<>"" then
		strOut="<a href=" & strASP & "?r=" & intDelta & "&path=" & strPath & "&d=" & strLowDateCode & ">previous</a>" 
	end if
	if  strLowDateCode<>"" and strHighDateCode<>"" then
		strOut=strOut & " | "
	end if
	if strHighDateCode<>"" then
		strOut=strOut & "<a href=" & strASP & "?r=" & intDelta & "&path=" & strPath & "&d=" & strHighDateCode & ">next</a>" 
	end if
	prevnextwebcam=strOut
end function

function TableStructure(strSidebar, strBody)
	dim strOut
	strOut=strOut & "<table width=800 cellpadding=0 cellspacing=0 border=0>" & vbNewLine
	strOut=strOut & "<tr>" & vbNewLine
	strOut=strOut & "<td width=140 valign=top>" & vbNewLine
	strOut=strOut & strSidebar
	strOut=strOut & "</td>" & vbNewLine
	strOut=strOut & "<td valign=top>" & vbNewLine
	strOut=strOut & strBody
	strOut=strOut & "</td>" & vbNewLine
	strOut=strOut & "</tr>" & vbNewLine
	strOut=strOut & "</table>" & vbNewLine
	TableStructure=strOut
end function

function LatestImages(byval strPath, intNumber, strStart, strASP, bwlSuperUser)
	'Gus Mueller, June 2002
	'browse all the files in a webcam archive images in an archive folder
	'intNumber is the pagination delta
	'strStart is the highest image to display (alphabetically)
	'strPath is the directory to look in
	dim fso, fold, filsOut, strOut, intTop, t, fil, arrOut, bwlDone, intOut
	dim strLowDateCode, strHighDateCode
	dim intHighestInDisplay
	dim strLow, strHigh, strRangeData
	set fso=createobject("scripting.filesystemobject")
	set fold=fso.getfolder(server.mappath(strPath))
	bwlDone=false
	set filsOut=fold.files
		intTop=filsOut.count
 		redim arrOut(intTop)
 	 	t=0
		for each fil in filsOut
			if fil.size>1000 then
				'response.write fil.size & "<br>" 
				arrOut(t)= fil.name  
			end if
			t=t+1
		next 
		t= intTop-1  
		do until bwlDone
			if t>=0 then
				if arrayresolve(arrOut,t)<>"" then
					if arrayresolve(arrOut,t)<=strStart or strStart="" then
						if arrayresolve(arrOut,t)=strStart then
							intHighestInDisplay=t
						end if
						strOut =strOut & "<table cellpadding=""0"" cellspacing=""0"" border=""0""><tr><td>" & vbNewLine
						strOut =strOut & DisplayRatedImage( arrayresolve(arrOut,t), 6, "name", false, "center", "", strPath, 320, 240) & vbNewLine
						strOut =strOut & "</td></tr><tr><td align=""center"">" & vbNewLine
						if bwlSuperUser then
							strOut =strOut & "<a href=""" & strASP & "?path=" & strPath & "&r=" & intNumber & "&d=" & strStart & "&action=delete&this=" & arrayresolve(arrOut,t) & """>" & vbNewLine
						
						end if
						strOut =strOut & "</td></tr></table>" & vbNewLine
						if intOut=0 then strLow=arrayresolve(arrOut,t)
						strHigh=arrayresolve(arrOut,t)
						intOut=intOut+1
						if intOut=>intNumber then 
							if t>0 then
								strLowDateCode = scanforlowdatecode(arrOut, t)
							end if
							bwlDone=true
						end if
					end if
				end if
			else
				bwldone=true
			end if
			'response.write t & "<br>"
			t=t-1
 		loop
		'response.write intHighestInDisplay & " ** " &  intTop-1
		if intHighestInDisplay<>"" then
			strHighDateCode =scanforhighdatecode(arrOut, intHighestInDisplay+intNumber, intTop-1)
		end if
	set fold=nothing
	set fso=nothing
	'strRangeData=strLow & "-" & strHigh
	'strOut= strRangeData & "<p>"  & strOut
	strOut =  prevnextwebcam(strASP, intNumber, strPath, strLowDateCode, strHighDateCode) & "<p>" & strOut
	 LatestImages=strOut
end function

function scanforlowdatecode(arrIn, intStart)
	'looks for the next lowest viable webcam archive image below intStart
	dim t, strOut
	for t= intStart-1 to 0 step-1
		if strOut="" then
			strOut=arrayresolve(arrIn,t)
		else
			exit for
		end if
	next
	'response.write "low@" & strOut & "-<P>"
	scanforlowdatecode=strOut
end function

function scanforhighdatecode(arrIn, intStart, intTop)
	'looks for the next highest viable webcam archive image above or equal to intStart, going up to intTop
	dim t, strOut
	for t= intStart to intTop
		if strOut="" then
			strOut=arrayresolve(arrIn,t)
		else
			exit for
		end if
	next
	'response.write "high@" & strOut & "-<P>"
	scanforhighdatecode=strOut
end function
%>




