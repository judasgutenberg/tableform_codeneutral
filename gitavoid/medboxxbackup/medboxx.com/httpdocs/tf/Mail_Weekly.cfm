<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><HEAD>
  <meta http-equiv="Context-Type" content="text/html" charset="iso-8859-1">
	<TITLE>Weekly Email</TITLE>
</HEAD>
<BODY bgcolor="white">

<CF_LINKS>

<FONT size="+1">Weekly Email</FONT>

<CFIF isDefined("FORM.Submit")>
  <CFSTOREDPROC  DATASOURCE="#DSN#" PROCEDURE="fw_client_emails">
    <CFIF not isDefined("chkLive")>
      <CFPROCPARAM TYPE="In" DBVARNAME="@TEST_USER_ID" CFSQLTYPE="CF_SQL_INTEGER" VALUE="#FW_UserID#">
    </CFIF>
    <CFPROCRESULT NAME="GetClients">
  </CFSTOREDPROC>

  <TABLE>
    <CFLOOP query="GetClients">
      <CFIF IsDefined("chkIgnoreDOW") or Dayofweek(Now()) eq GetClients.EMAIL_DOW>
      <TR>
        <CFQUERY NAME="qGetArticles" DATASOURCE="#DSN#">
      	  select A.ID, LTRIM(RTRIM(A.TITLE)) AS TITLE, A.SUBJECT, A.WORD_COUNT, A.NOTES, A.LOADED_DATE, A.USA_CANADA,
                 C.NAME AS CAT_NAME, W.FIRST_NAME + ' ' + W.LAST_NAME AS AUTH
            from ARTICLE A, USER_CATEGORY, CATEGORY C, USERS W
            where USER_CATEGORY.USER_ID = #GetClients.ID#
              and C.ID = A.CATEGORY_ID
              and W.ID = A.AUTHOR_ID
              and A.CATEGORY_ID = USER_CATEGORY.CATEGORY_ID
              and A.ACTIVE = 1
              and (A.LOADED_DATE > '#GetClients.LAST_EMAIL#' or A.LATEST > 0)
            order by C.ORDERBY, A.LATEST DESC, A.LOADED_DATE DESC
        </CFQUERY>

        <CFSET BODY=''>
        <CFSET CRLF=CHR(13)&CHR(10)>
        <CFOUTPUT query="qGetArticles">
          <CFIF USA_CANADA eq 0 or #GetClients.COUNTRY_CODE# eq 1 or #GetClients.COUNTRY_CODE# eq 107>
              <CFSET BODY=BODY & "#CRLF##CAT_NAME#: #UCase(TITLE)# by #UCase(AUTH)# #WORD_COUNT# words.#CRLF#">
              <CFSET BODY=BODY &"#SUBJECT##CRLF#">
              <CFIF not(NOTES eq "")><CFSET BODY=BODY &"#NOTES##CRLF#"></cfif>
              <CFSET BODY=BODY &"Full story at http://www.featurewell.com/i.php?#ID#.#GetClients.ID#.100#CRLF#">
          </CFIF>
        </CFOUTPUT>

        <CFIF BODY neq ''>
    		  <CFOUTPUT>
    			  <TD>#ID#</td>
    			  <TD>#FIRST_NAME# #LAST_NAME#</td>
    			  <TD>#EMAIL#</td>
    			  <TD>#EMAIL_FORMAT# </td>
    			  <TD>#LAST_EMAIL#</td>
    		  </cfoutput>

          <CFSET PW="For a password reminder, click here http://www.featurewell.com/?Doc=Forgot.cfm#chr(38)#clue=#USERNAME#">
          <!---CFQUERY name="qSendPassword" datasource="#DSN#">
            select DATEADD(day,30,max(timestamp)) as ts
              from hit
             where user_id = #GetClients.ID#
          </cfquery>

          <CFIF qSendPassword.ts gt now()>
            <CFSET PW="If you need a reminder of your password click here http://www.featurewell.com/?Doc=Forgot.cfm#chr(38)#clue=#USERNAME#">
          <CFELSE>
            <CFSET PW="Your password is '#PASSWORD#'">
          </CFIF--->

 
		  
		  
      	  <CFMAIL
          	from="Featurewell Sales<sales@featurewell.com>"
          	to="#GetClients.EMAIL_STR#"
          	subject="#FORM.SUBJ#"
          	SERVER="#SMTP#">#FORM.MESSAGE#

Your Featurewell.com username is '#UCASE(USERNAME)#'. #PW#.

#BODY#

If you do not wish to receive further emails from us, please reply to this email with 'remove' in the subject.

http://www.featurewell.com
Reproduction of material from any of Featurewell.com's pages, without written permission is prohibited. (c) 2000-#DateFormat(Now(),'yyyy')# Featurewell.com all rights reserved.
          </CFMAIL>

    		  <CFIF IsDefined("FORM.chkLIVE")>
        	  <CFQUERY datasource="#DSN#">
            	update USERS set LAST_EMAIL=GetDate()
      				where ID = #GetClients.ID#
            </cfquery>
          </cfif>
      	</CFIF>
      </tr>
      <CFFLUSH>
      </CFIF>
    </CFLOOP>
  </table>
<CFELSE>
  <CFFORM action="../form.php" method="post">
  <INPUT TYPE="hidden" NAME="x_dest2" VALUE="Mail_Weekly.cfm?RequestTimeout=8500">
   <CFINPUT type="Checkbox" name="chkLIVE" checked="no">Live Email
    <CFINPUT type="Checkbox" name="chkIgnoreDOW" checked="no">Ignore day of week
    <TABLE border=1 cellspacing=0 cellpadding=1 bgcolor="#cccccc">
    	<TR>
    		<TD align="right"><FONT size=-1><B>Subject:</B></FONT></TD>
        <CFSWITCH EXPRESSION="#DateFormat(Now(),'d')#">
        <CFCASE VALUE="1"><CFSET suffix='st'></CFCASE>
        <CFCASE VALUE="2"><CFSET suffix='nd'></CFCASE>
        <CFCASE VALUE="3"><CFSET suffix='rd'></CFCASE>
        <CFDEFAULTCASE><CFSET suffix='th'></CFDEFAULTCASE>
        </CFSWITCH>
    		<TD><CFINPUT type="text" name="SUBJ" size=40 value="Featurewell's Top Stories - #DateFormat(Now(),'mmmm d')##suffix#"></TD>
    	</TR>
    	<TR><TD colspan=2>
    		<TEXTAREA name="Message" rows=7 cols=80 wrap="soft">To contact Featurewell's New York sales office, please call +1 (212) 924 2283 or email sales@featurewell.com</TEXTAREA>
    		</TD>
    	</TR>
    	<TR><TD colspan=2 align="center"><INPUT type="submit" value="  Submit  " NAME="Submit"></TD></TR>
    </TABLE>
  </CFFORM>
</CFIF>

</BODY>
</HTML>
