<?php 
//Judas Gutenberg January 1 2008
//message board system functions

define("bb_name", "forum");
define("bb_single_thread", "topic");
define("show_nesting", false);

function AlterBoard($board_id, $board_name, $parent_id, $description, $user_id="", $has_posts=0, $strDatabase="")
{
	
	$bwlNew=false;
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$arrSpec="";
	if($board_id!="")
	{
 		$arrSpec= Array("board_id"=>$board_id);
	}
	$modified_date= date("Y-m-d H:i:s");
	$arrVals=Array("top_stickiness" =>0,"board_name"=>$board_name,"parent_id"=>$parent_id,"description"=>$description,"user_id"=>$user_id, "has_posts"=>$has_posts, "altered"=>$modified_date, "last_post"=>$modified_date);
	if($board_id=="")
	{
		$arrVals["created"]= $modified_date;
		$arrVals["post_count"]=0;
	}
	if($board_id<1)
	{
		$bwlNew=true;
	}
	$board_id=UpdateOrInsert($strDatabase, "mb_board",$arrSpec, $arrVals, true, false);
	if($bwlNew)
	{
		$parent_record=GenericDBLookup($strDatabase, "mb_board", "board_id",$parent_id, "");
		UpdateOrInsert($strDatabase, "mb_board",Array("board_id"=>$parent_id),Array("last_post"=>$modified_date,"post_count"=> $parent_record["post_count"]+1), true, false);
	}
	return $board_id;
	 
}

//AlterPost($board_id, $post_text, $user_id  ,  "",  "", $previous_post_id , "",  "",  $response_to_post_id);
function AlterPost($board_id, $post_text, $user_id="", $post_id="", $nesting="", $previous_post_id="", $next_post_id="", $strDatabase="", $response_to_post_id="")
//can be used to alter a post or just append a post to the bottom of a board
{
	$poster_info =GenericDBLookup($strDatabase, "user", "user_id", $user_id);
	$poster_post_count=intval($poster_info["post_count"]);
	$postername=StripOffAfterAt(gracefuldecay($poster_info["username"], $poster_info["email"])); 
	
	$board_record=GenericDBLookup($strDatabase, "mb_board", "board_id", $board_id, "");
	$intAdminType= AdministerType($strDatabase, "mb_post", "", "", $user_id);
	$post_count=$board_record["post_count"];
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	if($previous_post_id=="")
	{
		$previous_post_id=LargestPostIDinBoard($board_id, $strDatabase);
	
	}
	else
	{
		$rs=GetPostInfo($post_id,  $strDatabase);
		$nesting=$rs["nesting"] + 1;
	}
	$nesting=gracefuldecaynumeric($nesting, 0);
	if($post_id!="")
	{
		$founduserid =GenericDBLookup($strDatabase, "mb_post", "post_id", $post_id, "user_id");
	}
	$modified_date= date("Y-m-d H:i:s");
	$arrVals=Array("previous_post_id"=>$previous_post_id, "next_post_id"=>$next_post_id, "modified_date"=>$modified_date,  "post_text"=>$post_text, "board_id"=>$board_id, "user_id"=>gracefuldecay($founduserid, $user_id), "nesting"=>$nesting);
	if(intval($response_to_post_id)>0)
	{
		$arrVals["response_to_post_id"]=$response_to_post_id;
	}
	if($post_id=="")
	{
		$arrVals["post_date"]= $modified_date;
	}
	//die(gracefuldecaynumeric($response_to_post_id,0));

	//die($intAdminType . "+" . $user_id . "+" . $post_id . "+" . $post_text);
	if($intAdminType>1 || $user_id==$founduserid || $post_id=="")
	{
		
		$out_id=UpdateOrInsert($strDatabase, "mb_post", Array("post_id"=>$post_id), $arrVals, true, false);
		//send some emails to the bitches in the hizouse:
		
		
		
		
		
		$bwlSentAMail=false;
		if($response_to_post_id!="")
		{
			$respondedtopost_info=GenericDBLookup($strDatabase, "mb_post", "post_id", $response_to_post_id, "");
			$respondedto_user_id=$respondedtopost_info["user_id"];
			$respondedto_info=GenericDBLookup($strDatabase, "user", "user_id", $respondedto_user_id, "");
			
			
			
			$body="\r\n\r\nA user named " . $postername . " has replied to your post as follows:\r\n\r\n";
			$body.=$post_text;
			$body.="\r\n\r\n";
			$body.="To return to the thread, go here:\r\n http://a2zkeywording.com/bb_index.php?board_id=" . $board_id;
			$body.="\r\n\r\n";
		 	$fromemail=GenericDBLookup(our_db,"content", "name", "admin email address", "content");
		 	$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
			$toemail=$respondedto_info["email"];
			if($respondedto_info["receive_mb_email_updates"]  && $toemail!= $poster_info["email"])
			{
				mail($toemail, "A2ZKeywording: reply to your post",  $body, $headers, "-f" . $fromemail);
				$toemail="gus@asecular.com";
			
				mail($toemail, "A2ZKeywording: reply to your post",  $body, $headers, "-f" . $fromemail);
				$bwlSentAMail=true;
			}
		
		}
		$respondedtopost_info=GenericDBLookup($strDatabase, "mb_board", "board_id", $board_id, "");
		$respondedto_user_id=$respondedtopost_info["user_id"];
		$respondedto_info=GenericDBLookup($strDatabase, "user", "user_id", $respondedto_user_id, "");
		if(!$bwlSentAMail)
		{
			$body="\r\n\r\nA user named " . $postername . " has posted on your " . bb_single_thread . " as follows:\r\n\r\n";
			$body.=$post_text;
			$body.="\r\n\r\n";
			$body.="To return to the " . bb_single_thread . ", go here:\r\n http://a2zkeywording.com/bb_index.php?board_id=" . $board_id;
			$body.="\r\n\r\n";
		 	$fromemail=GenericDBLookup(our_db,"content", "name", "admin email address", "content");
		 	$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
			$toemail=$respondedto_info["email"];
			if($respondedto_info["receive_mb_email_updates"]  && $toemail!= $poster_info["email"])
			{
				mail($toemail, "A2ZKeywording: post on your " . bb_single_thread,  $body, $headers, "-f" . $fromemail);
				$toemail="gus@asecular.com";
				
				mail($toemail,  "A2ZKeywording: post on your " . bb_single_thread,  $body, $headers, "-f" . $fromemail);
			}
		}
		if($post_id=="")
		{
			UpdateOrInsert($strDatabase, "mb_board", Array("board_id"=>$board_id),  Array("post_count"=>$post_count+1, "last_post"=>$modified_date));
			
			UpdateOrInsert($strDatabase, "user", Array("user_id"=>$user_id),  Array("post_count"=>$poster_post_count+1, "last_post"=>$modified_date));
			
			
		}
		if($previous_post_id!="")
		{
			UpdateNextPostID($previous_post_id, gracefuldecay($post_id, $out_id), $strDatabase);
		}
	}
	if($post_id=="")
	{
		return $out_id;
	}
}

function UpdateNextPostID($post_id, $next_post_id, $strDatabase="")
{
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	UpdateOrInsert($strDatabase, "mb_post", Array("post_id"=>$post_id), Array("next_post_id"=>$next_post_id), true, false);
}

function LargestPostIDinBoard($board_id, $strDatabase="")
{
	$sql=conDB();
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$strTable="mb_post";
	$strSQL="SELECT MAX(post_id) as maxi FROM " . $strDatabase . "." .  $strTable . " WHERE board_id='" . $board_id . "'";
	//echo $strSQL;
	$records=$sql->query($strSQL);
	$record =$records[0];
	return $record["maxi"];
}

function GetPostInfo($post_id,  $strDatabase="")
{
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$rs=GenericDBLookup($strDatabase, "mb_post", "post_id", $post_id, "");
	return $rs;
}


function BoardBrowser($user_id, $parent_id, $intStartPost=0, $intPostCount=50, $intSortType=2, $strDatabase="")
{
	$sql=conDB();
	$boardpage="bb.php"; 
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$strWhere=  " WHERE parent_id is null OR  parent_id=0 ";
	if( $parent_id!="")
	{
		$strWhere=  " WHERE parent_id='" . $parent_id . "'";
	}
	$strSQL="SELECT * FROM " . $strDatabase . ".mb_board " . $strWhere ."  ORDER BY ";
	if($intSortType==0)
	{
	
	
		$strSQL.=" board_name";
	
	}
	$strSQL.=" LIMIT " . $intStartPost . "," . $intPostCount;
	//echo $strSQL;
	$records=$sql->query($strSQL);
	$verticalplace=$toppos;
	foreach($records as $rs)
	{
		$board_id=$rs["board_id"];
		$board_name=$rs["board_name"];
		$description=$rs["description"];
		$thisboardinfo="<div class=\"username\"><a href=\"" . $boardpage  . "?board_id=" . $board_id . "\">" . $board_name . "</a> : "  . $created . "</div>";
		$thisboardinfo.="<div class=\"postbody\">"  . $description . "</div>";

		$styleinfo=" width: 650px; float: left;left: " .  intval($nesting * $nestingfactor)+$leftpos . "px;";
		
		$out.="<div id=\"idboard-" . $board_id . "\" style=\"" . $styleinfo . "\" class=\"post\">" . $thisboardinfo . "</div>";
	}
	return $out;
}



function PostStream($board_id, $post_id_responded_to, $depth=0, $user_id, $width )
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "' AND response_to_post_id=" . $post_id_responded_to . " ORDER BY  post_date  ";
	//echo $strSQL;
	$out.="";
	$subrs=$sql->query($strSQL);
	foreach($subrs  as $thissubrs)
	{
		$indent=$depth*20;
		// DisplayPost($rs, $additionalcontent="", $user_id="", $indent="", $width=830)
		//echo "$". $width . "<BR>";
		$out.= DisplayPost($thissubrs, "", $user_id, $indent, $width);
		$post_id=$thissubrs["post_id"];
 
		$out.=PostStream($board_id, $post_id, $depth+1,  $user_id, $width);
	}
	return $out;
}



function DisplayBoard($board_id, $user_id="", $intStartPost=0, $intPostCount=50, $intSortType="3.4", $strDatabase="", $width=880)
{
	$sql=conDB();
	BoardAction($board_id, $user_id, $strDatabase);
	$windowspec="menubar=no,height=190,width=540,scrollbars=yes";
	$user_record=GenericDBLookup(our_db, "user", "user_id", $user_id);
	$thisuser=StripOffAfterAt(gracefuldecay($user_record["username"], $user_record["email"])); 
	$leftpos=5;
	$toppos=20;
	$usertable="user";
	$usertablepk="user_id";
	$usertabledisplayname="email";
	$userlookuppage="other_profile.php";
	$nestingfactor=25;
	$outcount=0;
	$oldid="";
	$out="";
	$out.="<script src=\"bb.js\"><!-- --></script>\n";
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	if(contains($intSortType, "."))
	{
		$arrSortType=explode(".", $intSortType);
		$intPostSortType=$arrSortType[0];
		$intBoardSortType=$arrSortType[1];
		
	}
	else
	{
		$intBoardSortType=$intSortType;
		$intPostSortType=$intSortType;
	}
	//echo $intSortType . " " . $intPostSortType;
	$out.="<div class='mb_title'>" . $board_info["board_name"] . "</div>";
	$out.="<div class='mb_description'>" . CleanText($board_info["description"]) . "</div>";
	//echo $intSortType;
	$search=$_REQUEST["searchterm"];
	$nowdatetime=date("Y-m-d H:i:s");
	
	$strDirIndication="ASC";

				
	if($search!="")
	{
 
		$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE post_text LIKE'%" . addslashes($search). "%'  ORDER BY  post_date DESC";
		$records=$sql->query($strSQL);
		$verticalplace=$toppos;
		$out.="<h3>Search results for '" . $search . "':</h3><br>";
		foreach($records as $rs)
		{
			$additionalcontent="<div class='postadditional'>From the <a href='bb_index.php?board_id=" . $rs['board_id'] . "'>" . GenericDBLookup(our_db, "mb_board", "board_id", $rs['board_id'], "board_name") . "</a> " . bb_name . ":</div>";
			$out.=DisplayPost($rs, $additionalcontent, $user_id, 0, $width);
			$rs=$sql->query($strSQL);
			$verticalplace=$verticalplace+ $post_text*10;
 
			
		}
		if(count($records)==0)
		{
			$out.="<div class='noresults'>No matches were found.</div>";
		}
		UpdateOrInsert($strDatabase, "search", "", Array("user_id"=>$user_id, "search_time"=>$nowdatetime, "search_phrase"=>$search, "result_count"=>count($records)));
	}
	else
	{
		
		$board_info=GenericDBLookup($strDatabase, "mb_board", "board_id", $board_id, "");
		$out.="<table border='0'  width='100%' cellpadding='0' cellspacing='0'>\n";
		$out.="<tr>\n";
		$out.="<td width='420' valign='top'>\n";
		$out.="<div class='boardnav'>" .  BoardNav($board_id, "bb_index.php", true, 30," : ") . "</div><br>";
		$out.="<h3>" . $board_info["board_name"] . "</h3><br>";
		$out.="<div class='boarddescription' >" . $board_info["description"] . "</div><br>";
		$out.="</td>\n";
		$out.="<td width='420'  valign='top' align='right'>\n";
		$out.= PostSearchForm( $user_id );
		if($user_id=="")
		{
			$out.="You need to <a href=\"signin.php?login_dest=bb_index.php?board_id=" .$board_id . "'\">log-in</a>  or <a href=\"register.php\">register</a> to post.";
		}
		else
		{
			$out.="<div class='loginline'>You are logged in as <a href='other_profile.php?user_id=" .   $user_id. "'>" . $thisuser . "</a> <a href='bb_index.php?mode=logout'>logout</a></div><br>";
		}
		$out.="</td>\n";
		$out.="</tr>\n";
		$out.="</table>\n";
		if(!$board_info["locked"]  &&  $board_id>0 )
		{
			$strPostLinkLabel="start a new " . bb_single_thread;
			if($board_info["has_posts"])
			{
			//	$postform= PostForm($board_id,  $user_id ,  "",  "","");
			$strPostLinkLabel="Ask a question/contribute";
			}
			//else
			{
				$postform= " <div align='right'><a class='boardtool' href='javascript:remote=window.open(\"bb_reply.php?board_id=" . $board_id . "&post_id=&action=\",\"poster\",\"" . $windowspec. "\");remote.focus()'>" . $strPostLinkLabel . "</a></div>";
			}
		}
		else
		{
			$postform= "This level of this " . bb_name . " is locked.";
		}
		
		
		//echo "%" .  $board_id;
 
		if($board_info["has_posts"])
		{
			$strDirIndication="ASC";
			if($intPostSortType==4)
			{
				$strDirIndication="DESC";
			}
			//echo $strDirIndication;
			if($intPostSortType==3  || $intPostSortType==4 )
			{
				if(show_nesting)
				{
					$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "' AND (response_to_post_id=0  OR isnull(response_to_post_id ) ) ORDER BY  post_date " . $strDirIndication ."";
				}
				else
				{
					$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "'   ORDER BY  post_date " . $strDirIndication ."";
				
				}
				
				//echo $strSQL;
				
				$rs=$sql->query($strSQL);
				$verticalplace=$toppos;
				//echo count($rs);
				foreach($rs  as $thisrs)
				{
					$out.= DisplayPost($thisrs, "", $user_id, 0, $width);
					if(show_nesting)
					{
						$post_id=$thisrs["post_id"];
						$out.= PostStream($board_id, $post_id,1,   $user_id, $width);
					}
				  
					//echo $strSQL . "<br>";
				}
			
			}
			else
			{
				$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "' ORDER BY ";
				if($intPostSortType==1)
				{
					$strSQL.=" post_date ASC";
				}
				if($intPostSortType==2)
				{
				
					$strSQL.=" post_date DESC";
				
				}
				$records=$sql->query($strSQL);
				$verticalplace=$toppos;
				foreach($records as $rs)
				{
					$out.=DisplayPost($rs, "", $user_id, 0, $width);
					$rs=$sql->query($strSQL);
					$verticalplace=$verticalplace+ $post_text*10;
					$out.="<p\><br\>";
					
				}
			}
		}
		else
		{
			$strDirIndication="ASC";
			if($intBoardSortType==4)
			{
				$strDirIndication="DESC";
			}
			$strSQL="SELECT * FROM " . $strDatabase . ".mb_board WHERE parent_id='" . ClearNumeric($board_id) . "'  ORDER BY top_stickiness DESC, altered " . $strDirIndication ."";
			//echo $strSQL;
			$records=$sql->query($strSQL);
			$out.=BoardRecordsHeader($width);
			if(count($records)<1)
			{
				$out.="<div class='noresults'>There are no " . pluralize(bb_single_thread) . " here yet.</div>";
			}
			foreach($records as $rs)
			{
				//DisplayBoardRecord($rs, $additionalcontent="", $user_id="" $width=830)
				$out.=DisplayBoardRecord($rs, "",  $user_id, $width);
				$out.="<p\><br\>";
			}
					
		}
		$out.=$postform;
	}
	return $out;
	
}

function BoardRecordsHeader($width=830)
{	
	$out="";
	$out.="<div class='catalogheader'  >";
	$out.="<table border='0'  width='" . $width. "' cellpadding='0' cellspacing='0'>\n";
	$out.="<tr>\n";
	$out.="<td width='420'>\n";
	$out.=firstlettercapitalize(pluralize(bb_single_thread));
	$out.="</td><td width='50'>\n";
	$out.="Posts";
	$out.="</td><td width='120'>\n";
	$out.="Author";
	$out.="</td><td>\n";
	$out.="Last Post";
	$out.=" by <a href='other_profile.php?user_id=" . $record["user_id"] . "'>" . $lastusernametopost . "</a>";
	$out.="</td><td></td></tr>\n";
	$out.="</table>\n";
	$out.="</div>\n";
	return $out;
}

function DisplayBoardRecord($rs, $additionalcontent="", $user_id="",$width=830)
{
	$out="";
	$sql=conDB();
	$windowspec="menubar=no,height=240,width=540,scrollbars=yes";
	$usertable="user";
	$usertablepk="user_id";
	$usertabledisplayname="email";
	$userlookuppage="other_profile.php";
	$description=$rs["description"];
	$poster_id=$rs["user_id"];
	$record=GenericDBLookup(our_db, $usertable, $usertablepk, $poster_id);
	$postername= StripOffAfterAt(gracefuldecay($record["username"],$record[$usertabledisplayname])); 
 
	$nesting=$rs["nesting"];
	$board_id=$rs["board_id"];
	$board_name=$rs["board_name"];
	$locked=$rs["locked"];
	$ts=strtotime($rs["created"]);
	$post_date=date("m/d/y", $ts);
	$post_time=date("g:iA", $ts);
	$modified_date=$rs["altered"];
	$previous_post_id=$rs["previous_post_id"];
	$post_count=$rs["post_count"];
	$background_color=$rs["background_color"];
	$bgstyle="";
	if($background_color!="")
	{
		$bgstyle=";background-color:" . $background_color ;
	}
 	$lastpostagoinseconds=strtotime($rs["last_post"])+1;
	$intervaldesc = DescribeTimeSpan($lastpostagoinseconds,time(), "ago");
	//get info about last user to post
	$strSQL="SELECT u.user_id, username, email FROM mb_post p JOIN user u ON p.user_id=u.user_id ORDER BY post_date DESC LIMIT 0,1"; 
	$records=$sql->query($strSQL);
	$record=$records[0];
	$lastusernametopost= StripOffAfterAt(gracefuldecay($record["username"],$record["email"]));
	$post_id=$rs["post_id"];
	//echo "<BR>" . $description . "<P><br><br>";
	$out.="<div class='postbody' style='margin-left:" .$indent .  $bgstyle.   "'>";
	$out.="<table border='0'  width='" . $width. "' cellpadding='0' cellspacing='0'>\n";
	$out.="<tr>\n";
	$out.="<td width='420'>\n";
	if($locked)
	{
		$out.="<img src='images/lock.png' border='0'>\n";
	}
	$posterlink="<a class='postheader' href=\"" . $userlookuppage  . "?" . $usertablepk . "=" . $poster_id . "\">" . $postername ."</a>";
	$out.="<a class='postheader' href='bb_index.php?board_id=" . $board_id . "'>" . $board_name . "</a>";
	$out.="</td><td width='50'>\n";
	$out.=$post_count;
	$out.="</td><td width='120'>\n";
	$out.=$posterlink;
	$out.="</td><td>\n";
	$out.=$intervaldesc;
	$out.=" by <a href='other_profile.php?user_id=" . $record["user_id"] . "'>" . $lastusernametopost . "</a>";
	$out.="</td><td align='right'>\n";
	$adminline="";
	if(AdministerType(our_db,"mb_post", "", "", $user_id)>2  || 1==1)
	{
		$adminline=" <a  class='boardtool' href=# onclick=\"if(confirm('Are you sure you want to delete this thread?')){window.location.href='bb_index.php?board_id=" . $_REQUEST["board_id"] . "&d_board_id=" . $board_id . "&action=deleteboard';}\">delete</a> ";
		$adminline.=" <a class='boardtool' href='javascript:remote=window.open(\"bb_board_mod.php?board_id=" . $board_id . "&action=alter\",\"poster\",\"" . $windowspec. "\");remote.focus()'>edit</a>";
	}
	$calcwidth=$width;
 
	$out.=$adminline;
	
	//$thispostinfo="\n " . $posterlink .  " on  "  . $post_date . "  at  " . $post_time . " " . $adminline . " </div>";
	//$thispostinfo.=UserPostRankLine($poster_id,   $post_id);
	//$thispostinfo.="\n<div  class='posttext'>" . $additionalcontent .  CleanupPost($description) .  "</div>";
 
	
 
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="</table>\n";
	
	
	$out.="</div>";
	return $out;
}



function DisplayPost($rs, $additionalcontent="", $user_id="", $indent="", $width=830)
{
	if(!show_nesting)
	{
		$indent=0;
	}
	$out="";
	$windowspec="menubar=no,height=190,width=540,scrollbars=yes";
	$usertable="user";
	$usertablepk="user_id";
	$usertabledisplayname="email";
	$userlookuppage="other_profile.php";
	$post_text=$rs["post_text"];
	$poster_id=$rs["user_id"];
	//$postername=StripOffAfterAt(GenericDBLookup(our_db, $usertable, $usertablepk, $poster_id, $usertabledisplayname));
 
	$user_record=GenericDBLookup(our_db, $usertable, $usertablepk, $poster_id);
	$poster_postcount= $user_record["post_count"];
	$member_since= DescribeTimeSpan(strtotime($user_record["joined"]),time(), "");
	$postername=StripOffAfterAt(gracefuldecay($user_record["username"], $user_record[$usertabledisplayname])); 
	
	$nesting=$rs["nesting"];
	$board_id=$rs["board_id"];
	$ts=strtotime($rs["post_date"]);
	$post_date=date("m/d/y", $ts);
	$post_time=date("g:iA", $ts);
	$modified_date=$rs["modified_date"];
	$previous_post_id=$rs["previous_post_id"];
	$post_id=$rs["post_id"];
	//echo "<BR>" . $post_text . "<P><br><br>";
	$posterlink="<div class='postheader' style='width:140px'><a class='postheader' href=\"" . $userlookuppage  . "?" . $usertablepk . "=" . $poster_id . "\">" . $postername ."</a>";
	$out.="<div  class='postbody' style='margin-left:" .$indent . "'>";
	  $width=444;
	$out.="<table border='0'  width='100%' cellpadding='0' cellspacing='0'>\n";
	$out.="<tr>\n";
	$out.="<td width='140'  valign='top'>\n";
	$out.=$posterlink;
	$out.="<div class='posttime'>"  . $post_date . "  at  " . $post_time ;
	$out.="<br>member for ". $member_since;
	$out.="<br>total posts: ". $poster_postcount;
	if(function_exists("DisplayAvatar"))
	{
		$out.= DisplayAvatar($poster_id);
	}
	$out.="</div>";
	$out.="</td><td valign='top'>\n";
	
	$adminline="";
	$adminwidth=140;
	//echo AdministerType(our_db,"mb_post", "", "", $user_id);
	if(AdministerType(our_db,"mb_post", "", "", $user_id)>1)
	{
		$adminwidth=140;
	
	
	}
	$calcwidth=intval($width)-intval($indent);
	//echo $width . "  " . $calcwidth . "<Br>";
	//$adminline.="<a   class='boardtool' href=\"tf.php?" . qpre . "db=" . our_db . "&" . qpre . "table=mb_post&" . qpre . "mode=edit&" . qpre . "idfield=post_id&post_id=" . $post_id . "\">edit</a> ";
	if($rs["user_id"]==$user_id || AdministerType(our_db,"mb_post", "", "", $user_id)>1)
	{
	$adminline=" <a  class='boardtool' href=# onclick=\"if(confirm('Are you sure you want to delete this post?')){window.location.href='bb_index.php?board_id=" . $board_id . "&post_id=" . $post_id . "&action=delete';}\">delete</a> ";
$adminline.=" <a class='boardtool' href='javascript:remote=window.open(\"bb_reply.php?board_id=" . $board_id . "&edit_post_id=" . $post_id . "&action=reply\",\"poster\",\"" . $windowspec. "\");remote.focus()'>edit</a>";
	}
	if($rs["user_id"]!=$user_id)
	{
	$adminline.=" <a  class='boardtool' href=# onclick=\"if(confirm('Are you sure you want to flag this post?')){window.location.href='bb_index.php?board_id=" . $board_id . "&post_id=" . $post_id . "&action=flag';}\">flag</a>";
	}
	if(show_nesting)
	{
		$adminline.=" <a class='boardtool' href='javascript:remote=window.open(\"bb_reply.php?board_id=" . $board_id . "&post_id=" . $post_id . "&action=reply\",\"poster\",\"" . $windowspec. "\");remote.focus()'>reply</a>";
	}
	//$thispostinfo="\n " . $posterlink .  " on  "  . $post_date . "  at  " . $post_time . " " . $adminline . " </div>";
	//$thispostinfo.=UserPostRankLine($poster_id,   $post_id);
	$thispostinfo.="\n<div class='posttext'>" . $additionalcontent .  CleanupPost($post_text) .  "</div>";
	$styleinfo=" width: " . $calcwidth . "px; margin-left: " .  intval($nesting * $nestingfactor+$leftpos ). "px;";
	
	$out.="\n<div id=\"idpost-" . $post_id . "\" style=\"" . $styleinfo . "\" class=\"post\">" . $thispostinfo . "</div>";
	$out.="<td valign='top' width='" . $adminwidth . "'>\n";
	$out.=$adminline;
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="</table>\n";
	$out.="</div>";
	return $out;
}

function CleanupPost($in)
{
	$in=str_replace("<script", "<xscript", $in);
	$in=str_replace("</script", "</xscript", $in);
	$in=str_replace("<div", "<xdiv", $in);
	$in=str_replace("</div", "</xdiv", $in);
	$in=str_replace("<font", "<xfont", $in);
	$in=str_replace("</font", "</xfont", $in);
	$in=str_replace("<span", "<xspan", $in);
	$in=str_replace("</span", "</xspan", $in);
	$in=str_replace("<table", "<xtable", $in);
	$in=str_replace("</table", "</xtable", $in);
	$in=str_replace("</tr", "</xtr", $in);
	$in=str_replace("<tr", "<xtr", $in);
	$in=str_replace("</td", "</xtd", $in);
	$in=str_replace("<td", "<xtd", $in);
	$in=str_replace("<img", "<ximg", $in);
	return $in;
}

function GetLastPostByUser($intUserID, $strDatabase="")
{
	$sql=conDB();
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE user_id='" . $intUserID . "' ORDER BY post_id DESC";
	$records=$sql->query($strSQL);
	$record=$records[0];
	return $record["post_text"];
	
}

function PostSearchForm( $user_id="",   $verbiage="")
{
	if($verbiage=="")
	{
		$verbiage ="Search the " . pluralize(bb_name) . " here:";
	}
	if($user_id=="")
	{
		 
	}
	else
	{
		//echo $verbiage;
		$search=$_REQUEST["searchterm"];
		$out="<form name='SForm' action=\"" . $strPHP . "\" method=\"post\">\n";
		$out.="<table align='right' width='520' border='0'><tr><td width='140' style='padding-bottom:5px'>";
		$out.=HiddenInputs(Array("board_id"=>$board_id, "article_id"=>$article_id, "response_to_post_id"=>$response_to_post_id), "" );
		$out.="<div class='postblurb' style='vertical-align:text-top'>" . $verbiage . "</div></td><td>";
		$out.=GenericInput("searchterm", $search,  false,  "",  "",  "",  "text", "40",  "", 1);
		$out.="<div class=\"divsubmit\">";
		$alttext="submit";
		$butwidth=95;
		$butheight=44;
		$butfilename="submit";
		$out.="</td><td width='" .$butwidth . "'>";
		$out.="<div id='b6' style='background-image: url(images/" . $butfilename . ".png);width:" . $butwidth . "px;height;" . $butheight . "px; '><a href='javascript:document.SForm.submit()'><img alt='" . $alttext . "' id='b6h' src='images/" . $butfilename . "_hover.gif' border='0'></a></div>";
		//$out.=GenericInput("submit", "post");
		$out.="</div>";
		$out.="</td></tr></table>";
		$out.="</form>\n";
	
	}
	return $out;
}

function BoardAction($board_id, $user_id="", $strDatabase="")
{
	$post_text=$_REQUEST["post_text"];
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
		
	if($user_id=="")
	{

	}
	else
	{
		$board_record=GenericDBLookup($strDatabase, "mb_board", "board_id", $board_id, "");
		$post_count=$board_record["post_count"];
		$altered=$board_record["altered"];
		$additionalVerbiage="";
		if(!$board_record["has_posts"])
		{
			 $verbiage="Create a new " . bb_single_thread .".";
			 $additionalVerbiage="And make the first post:";
		}
	 	if(!$board_record["has_posts"] && $post_text!="")
		{
			//actually have to build a subboard at this point
			// AlterBoard($board_id, $board_name, $parent_id, $description, $user_id="", $has_posts=0, $strDatabase="")
			//die("#######################" . substr($post_text, 0, 30) . " " . $post_text);
			$board_name=$_REQUEST["board_name"];
			$board_id=AlterBoard("", $board_name, $board_id,$post_text, $user_id, 1, $strDatabase);
			$bwlRedirectToBoard=true;
		
		}
		$action_post_id=$_REQUEST["post_id"];
		//die($response_to_post_id);
		$response_to_post_id=gracefuldecay( $_REQUEST["response_to_post_id"], $response_to_post_id);
		$this_post_id=gracefuldecay( $_REQUEST["this_post_id"], $this_post_id);
	 
		if($_REQUEST["action"]=="delete")
		{
			//AdministerType($strDatabase, $strTable, $strAdmin, $id="", $user_id="")
			if(AdministerType($strDatabase,"mb_post", "", "", $user_id)>1)
			{
			
				DeleteBySpec($strDatabase, "mb_post", Array("post_id"=>$action_post_id));
				UpdateOrInsert($strDatabase, "mb_board", Array("board_id"=>$board_id),  Array("post_count"=>$post_count-1, "altered"=>date("Y-m-d H:i:s")));
			}
		}
		else if($_REQUEST["action"]=="flag")
		{
			UpdateOrInsert(our_db, "mb_post", Array("post_id"=>$action_post_id), Array("flagged"=> 1 ));
			
			$messages="You have flagged a post.<br>";
			$complaineremail=GenericDBLookup(our_db, "user", "user_id", $user_id, "email");
			$suspectpost=GenericDBLookup(our_db, "mb_post", "post_id", $action_post_id, "post_text");
			$body="\r\n\r\nA user whose email address is " . $complaineremail . " has complained about the post whose content is as follows:\r\n\r\n";
			$body.=$suspectpost;
			$body.="\r\n\r\n";
			$body.="To delete the post, go here:\r\n http://a2zkeywording.com/bb_index.php?board_id=" . $board_id . "&post_id=" . $action_post_id . "&action=delete";
			$body.="\r\n\r\n";
			$body.="To edit the post, go here:\r\n http://a2zkeywording.com/tf.php?" . qpre . "db=" . our_db . "&" . qpre . "table=mb_post&" . qpre . "mode=edit&" . qpre . "idfield=post_id&post_id=" . $action_post_id ;
		 	$fromemail=GenericDBLookup(our_db,"content", "name", "admin email address", "content");
		 	$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
			mail($fromemail, "A2ZKeywording: flagged post",  $body, $headers, "-f" . $fromemail);
			$fromemail="gus@asecular.com";
			mail($fromemail, "A2ZKeywording: flagged post",  $body, $headers, "-f" . $fromemail);
		}
		else if($_REQUEST["action"]=="deleteboard")
		{
			//echo AdministerType($strDatabase,"mb_board", "", "", $user_id);
			if(AdministerType($strDatabase,"mb_board", "", "", $user_id)>1)
			{
				$board_id=$_REQUEST["d_board_id"];
				$parent_id=$board_record["parent_id"];
				$parent_record=GenericDBLookup($strDatabase, "mb_board", "board_id",$parent_id, "");
				//echo $parent_id . "-" . $parent_record["post_count"] . "<BR>";
				UpdateOrInsert($strDatabase, "mb_board",Array("board_id"=>$parent_id),Array("post_count"=> $parent_record["post_count"]-1), true, false);
				
				DeleteBySpec($strDatabase, "mb_board", Array("board_id"=>$board_id));
 				DeleteBySpec($strDatabase, "mb_post", Array("board_id"=>$board_id));
			}
			
		}
		$strPHP=$_SERVER['PHP_SELF'];

		if($post_text!=""  && !$board_record["locked"])
		{
			//die($post_text . " " . $this_post_id);
			$lastpostcontent=GetLastPostByUser($user_id, $strDatabase);
		 	if($lastpostcontent!=$post_text)
			{
 				//die($board_id . "+" . $user_id . "*" . $post_text . " " . $this_post_id);
				AlterPost($board_id, $post_text, $user_id  , $this_post_id,  "", "" , "",  "",  $response_to_post_id);
				if($bwlRedirectToBoard)
				{
					//header("location: forums.php?board_id=" . $board_id);
				}
			}
		}
	}
}



function PostForm($board_id,  $user_id="", $this_post_id="", $strDatabase="", $article_id="", $response_to_post_id="", $verbiage="Post your question here:")
{
	$out="";
 
	BoardAction($board_id, $user_id, $strDatabase);
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	if($user_id=="")
	{
		$out.="You need to <a href=\"javascript:opener.location.href='signin.php?login_dest=bb_index.php?board_id=" .$board_id . "'\">log-in</a>  or <a href=\"javascript:opener.location.href='register.php'\">register</a> to post.";
	}
	else
	{
		$post_text=$_REQUEST["post_text"];
	 
	 	$board_record=GenericDBLookup($strDatabase, "mb_board", "board_id", $board_id, "");
		$post_count=$board_record["post_count"];
		$altered=$board_record["altered"];
	
		$out="<form name='MForm' action=\"" . $strPHP . "\" method=\"post\">\n";
		$out.=HiddenInputs(Array("board_id"=>$board_id, "article_id"=>$article_id, "response_to_post_id"=>$response_to_post_id,"this_post_id"=> $this_post_id), "" );
		$out.="<div class='postblurb'>" . $verbiage . "</div>";
		$butfilename="post_btn";
		$alttext="post";
		if($this_post_id!="")
		{
			$post_text=GenericDBLookup($strDatabase, "mb_post", "post_id", $this_post_id, "post_text");
			$butfilename="save_btn";
			$alttext="save";
		}
		//echo $strDatabase . " " . $this_post_id . " " . $post_text;
		if(!$board_record["has_posts"])
		{
			$out.=GenericInput("board_name", "",  false,  "",  "",  "",  "text", "60",  "",1) . "<BR/>";
		}
		$out.="<div class='additionalverbiage'>" . $additionalVerbiage . "</div>";
		$out.=GenericInput("post_text", $post_text,  false,  "",  "",  "",  "text", "60",  "", 4);
		$out.="<div class=\"divsubmit\">";
		
		$butwidth=95;
		$butheight=44;
 
		$out.="<div id='b4' style='background-image: url(images/" . $butfilename . ".png);width:" . $butwidth . "px;height;" . $butheight . "px;margin-left:350px'><a onclick='javascript:if(postformokay()){document.MForm.submit()}'><img alt='" . $alttext . "' id='b4h' src='images/" . $butfilename . "_hover.gif' border='0'></a></div>";
		//$out.=GenericInput("submit", "post");
		$out.="</div>";
		$out.="</form>\n";
		 
		
	}
	return $out;
}

function userposts($poster_id, $intFirstRecord, $limit, $sort=0, $strDatabase="", $width=830)
{
	$sql=conDB();
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	if($sort==0)
	{
		$orderbyclause="post_date DESC";
	}
	$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE user_id='" . ClearNumeric($poster_id) . "' ORDER BY  " . $orderbyclause . " LIMIT " . gracefuldecaynumeric($intFirstRecord,0) . "," . gracefuldecaynumeric($limit,1);


	$records=$sql->query($strSQL);
	foreach($records as $record)
	{
		$additionalcontent="<div class='postadditional'>From the <a href='bb_index.php?board_id=" . $record['board_id'] . "'>" . GenericDBLookup(our_db, "mb_board", "board_id", $record['board_id'], "board_name") . "</a> " . bb_name .":</div>";
		//DisplayPost($rs, $additionalcontent="", $user_id="", $indent="", $width=830)
		$out.=DisplayPost($record, $additionalcontent, $user_id, 0, $width);
		
		$out.="<p\><br\>";
	
	}
	return $out;
}

function StripOffAfterAt($in)
{
	if(contains($in, "@"))
	{
		$arrIn=explode("@", $in);
		return $arrIn[0];
		
	}
	return $in;
}

function BoardNav($board_id, $baseurl="bb_index.php", $bwlStopBeforeRoot=true, $trunc=30, $separator=" : ", $bwlShowRoot=true,$bwlLinkroot=true )
{
	$this_board_id=$board_id;
	
	$loopcount=0;
	while($this_board_id>0  && $loopcount<10)
	{
		$this_record=GenericDBLookup($strDatabase, "mb_board", "board_id", $this_board_id, "");
		
		// truncate($strIn, $intTruncNumber)
		$board_name= truncate($this_record["board_name"], $trunc);
		if($this_record["board_id"]==$board_id)
		{
			$out= $board_name .  $separator . $out; 
		}
		else
		{
			$out="<a href='" . $baseurl . "?board_id=" . $this_record["board_id"] . "'>" . $board_name . "</a>" . $separator . $out; 
		}
		$this_board_id=$this_record["parent_id"];
		$loopcount++;
	}
	$out = RemoveLastCharacterIfMatch($out,  $separator);
	if($bwlShowRoot)
	{
		if($bwlLinkroot)
		{
			$out="<a href='" . $baseurl . "?board_id=0'>" . firstlettercapitalize(pluralize(bb_name)) .  "</a>".  IfAThenB($out,  $separator) . $out;
		}
		else
		{
			$out=firstlettercapitalize(pluralize(bb_name)) .  IfAThenB($out,  $separator) . $out;
		}
	}
	return $out;
}
?>