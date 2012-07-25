<?php

if ( !$sql->grant_permissions('drop', $_GET['user'], $_POST['pass']) )
{
	error('Error while trying to drop user '.$_GET['user'].'; txtSQL said: '.$sql->get_last_error(), E_USER_ERROR);
}

header('Location: edit.php?msg=003&redir=users');
?>