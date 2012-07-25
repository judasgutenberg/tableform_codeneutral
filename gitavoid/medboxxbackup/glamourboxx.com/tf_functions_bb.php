<?php 
//Judas Gutenberg January 1 2008
//message board system functions


function AlterBoard($board_id, $board_name, $parent_id, $description, $user_id="", $strDatabase="")
{
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	if($board_id!="")
	{
		 UpdateOrInsert($strDatabase, "mb_board", Array("board_id"=>$board_id), Array("board_name"=>$board_name,"parent_id"=>$parent_id,"description"=>$description,"user_id"=>$user_id), true, false);
	}
	else
	{
		 $out_id= UpdateOrInsert($strDatabase, "mb_board", "", Array("board_name"=>$board_name,"parent_id"=>$parent_id,"description"=>$description,"user_id"=>$user_id), true, false);
	}
	if($board_id=="")
	{
		return $out_id;
	}
}


function AlterPost($board_id, $post_text, $user_id="", $post_id="", $nesting="", $previous_post_id="", $next_post_id="", $strDatabase="")
//can be used to alter a post or just append a post to the bottom of a board
{
	
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
	$arrVals=Array("previous_post_id"=>$previous_post_id, "next_post_id"=>$next_post_id, "modified_date"=>$modified_date,  "post_text"=>$post_text, "board_id"=>$board_id, "user_id"=>$user_id, "nesting"=>$nesting);
	if($post_id=="")
	{
		$arrVals["post_date"]=DateTimeForMySQL( date("Y-m-d H:i:s", time()));
	}
	$out_id=UpdateOrInsert($strDatabase, "mb_post", Array("post_id"=>$post_id), $arrVals, true, false);
	if($previous_post_id!="")
	{
		UpdateNextPostID($previous_post_id, gracefuldecay($post_id, $out_id), $strDatabase);
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


function BoardBrowser($user_id, $parent_id, $intStartPost=0, $intPostCount=50, $intSortType=0, $strDatabase="")
{
	$sql=conDB();
	$boardpage="bb.php"; 
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$strWhere=  " WHERE parent_id=1  OR  parent_id is null OR  parent_id=0 ";
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
		$thisboardinfo.="<div class=\"posttext\">"  . $description . "</div>";

		$styleinfo=" width: 650px; float: left;left: " .  intval($nesting * $nestingfactor)+$leftpos . "px;";
		
		$out.="<div id=\"idboard-" . $board_id . "\" style=\"" . $styleinfo . "\" class=\"post\">" . $thisboardinfo . "</div>";
	}
	return $out;
}

function DisplayBoard($board_id, $user_id="", $intStartPost=0, $intPostCount=50, $intSortType=0, $strDatabase="")
{
	$sql=conDB();
	$leftpos=5;
	$toppos=20;
	$usertable="user";
	$usertablepk="user_id";
	$usertabledisplayname="username";
	$userlookuppage="profile.php";
	$nestingfactor=25;
	$outcount=0;
	$oldid="";
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	if($intSortType==0)
	{
		$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "' ORDER BY  post_date LIMIT 0,1";
		//echo $strSQL;
		$rs=$sql->query($strSQL);
		$verticalplace=$toppos;
		while(count($rs)>0  && $outcount<$intPostCount)
		{
	
			$rs=$rs[0];
			$post_text=$rs["post_text"];
			//echo $post_text . "==<br>";
			$poster_id=$rs["user_id"];
			$postername=GenericDBLookup($strDatabase, $usertable, $usertablepk, $poster_id, $usertabledisplayname);
			$nesting=$rs["nesting"];
			$ts=strtotime($rs["post_date"]);
			$post_date=date("m/d/y", $ts);
			$post_time=date("g:iA", $ts);
			$modified_date=$rs["modified_date"];
			$previous_post_id=$rs["previous_post_id"];
			$post_id=$rs["post_id"];
			$prevpostclause="";
			if($outcount>0  && $previous_post_id !="")
			{
				$prevpostclause=" AND previous_post_id='" . $post_id . "' ";
			}
			$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "' " . $prevpostclause . " ORDER BY  post_date LIMIT 0,1";
			//echo $strSQL . "<br>";
			if($outcount>=$intStartPost)
			{
				//echo $outcount . "=" . $intStartPost . "<br>";
				if($oldid!=$post_id)
				{
					if($postername=="")
					{
						$posterlink="anonymous";
					}
					else
					{
						$posterlink="<strong>Posted By:</strong> <a href=\"" . $userlookuppage  . "?" . $usertablepk . "=" . $poster_id . "\">" . $postername ."</a>";
					}
					$thispostinfo="\n<div  style=\"margin-top:10px\" class=\"username\">" . $posterlink .  " on <span v><strong>"  . $post_date . "</strong></span> at <strong>" . $post_time . "</strong></div>";
					$thispostinfo.=UserPostRankLine($poster_id,   $post_id);
					$thispostinfo.="\n<div  >"  . $post_text . "</div>";
		 
					$styleinfo=" width: 650px; margin-left: " .  intval($nesting * $nestingfactor+$leftpos ). "px;";
					
					$out.="\n<div id=\"idpost-" . $post_id . "\" style=\"" . $styleinfo . "\" class=\"post\">" . $thispostinfo . "</div>";
					$oldid=$post_id;
					$out.="<p\><br\>";
				}
				
				//$verticalplace=$verticalplace+ $post_text*10;
 			}
			
			$rs=$sql->query($strSQL);
			$outcount++;
			
		}
	
	}
	else
	{
		$strSQL="SELECT * FROM " . $strDatabase . ".mb_post WHERE board_id='" . ClearNumeric($board_id) . "' ORDER BY ";
		if($intSortType==0)
		{
		
		
			$strSQL.=" post_date";
		
		}
		$records=$sql->query($strSQL);
		$verticalplace=$toppos;
		foreach($records as $rs)
		{
			$out.=DisplayPost($rs);
			$rs=$sql->query($strSQL);
			$verticalplace=$verticalplace+ $post_text*10;
			$out.="<p\><br\>";
			
		}
	}
	return $out;
	
}

function DisplayPost($rs)
{
	$out="";
	$usertable="user";
	$usertablepk="user_id";
	$usertabledisplayname="username";
	$userlookuppage="profile.php";
	$post_text=$rs["post_text"];
	$poster_id=$rs["user_id"];
	$postername=GenericDBLookup($strDatabase, $usertable, $usertablepk, $poster_id, $usertabledisplayname);
	$nesting=$rs["nesting"];
	$ts=strtotime($rs["post_date"]);
	$post_date=date("m/d/y", $ts);
	$post_time=date("g:iA", $ts);
	$modified_date=$rs["modified_date"];
	$previous_post_id=$rs["previous_post_id"];
	$post_id=$rs["post_id"];
	$posterlink="<strong>Posted By:</strong> <a href=\"" . $userlookuppage  . "?" . $usertablepk . "=" . $poster_id . "\">" . $postername ."</a>";
	
	
	$thispostinfo="\n<div style=\"margin-top:10px\" class=\"username\">" . $posterlink .  " on <span  ><strong>"  . $post_date . "</strong></span> at <strong>" . $post_time . "</strong></div>";
	$thispostinfo.=UserPostRankLine($poster_id,   $post_id);
	$thispostinfo.="\n<div  >"  . $post_text . "</div>";
	$styleinfo=" width: 650px; margin-left: " .  intval($nesting * $nestingfactor+$leftpos ). "px;";
	
	$out.="\n<div id=\"idpost-" . $post_id . "\" style=\"" . $styleinfo . "\" class=\"post\">" . $thispostinfo . "</div>";

	return $out;
}
function PostForm($board_id,  $user_id="", $previous_post_id="", $strDatabase="", $article_id="")
{
	if($user_id=="")
	{
		$out.="You need to log-in (at the top right of this page) or <a href=\"register.php\">register</a> to post.";
	}
	else
	{
		$strPHP=$_SERVER['PHP_SELF'];
		if($strDatabase=="")
		{
			$strDatabase=our_db;
		}
		$post_text=$_REQUEST["post_text"];
		if($post_text!="")
		{
		 
			AlterPost($board_id, $post_text, $user_id  ,  "",  "", $previous_post_id , "",  "");
		}
		$out="<form action=\"" . $strPHP . "\" method=\"post\">\n";
		$out.=HiddenInputs(Array("board_id"=>$board_id, "article_id"=>$article_id), "" );
		$out.=GenericInput("post_text", "",  false,  "",  "",  "",  "text", "60",  "", 4);
		$out.="<div class=\"divsubmit\">";
		$out.=GenericInput("submit", "post");
		$out.="</div>";
		$out.="</form>\n";
	}
	return $out;
}

function userposts($poster_id, $intFirstRecord, $limit, $sort=0, $strDatabase="")
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
		$out.=DisplayPost($record);
		$out.="<p\><br\>";
	
	}
	return $out;
}
?>