<?
	require('functions.php');

	$user_exists = get_user_by_email($_POST['email']);

	if ($user_exists) {
		set_flash_message('email_exists', 'danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');

		redirect ('page_register.php');
	}
	else {
		add_user($_POST['email'], $_POST['password']);

		set_flash_message('registration_successful', 'success', 'Регистрация успешна');

		redirect ('page_login.php');
	}


?>