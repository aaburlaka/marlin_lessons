<?
	require('functions.php');

	$logged_in = login();

	if ($logged_in)
		redirect ('users.php');
	else
		redirect ('page_login.php');
?>