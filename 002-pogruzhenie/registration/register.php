<?
	require('functions.php');

	$user_exists = get_user_by_email($_POST['email']);

	if ($user_exists) {
		set_flash_message('email_exists', true);

		header('Location: page_register.php');
		exit;

	}
	else {
		add_user();
	}


?>