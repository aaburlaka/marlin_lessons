<?
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		extract($_POST);

		if (!$email = check_email($email)) {
			set_flash_message('create_user_error', 'danger', '<strong>Уведомление!</strong> Неверно введен электронный адрес.');

			$error = 'wrong email';
		}

		$user_exists = get_user_by_email($email);
		if ($user_exists) {
			set_flash_message('create_user_error', 'danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');

			$error = 'user exists';

		}

		if (!$password = check_password($password)) {
			set_flash_message('create_user_error', 'danger', '<strong>Уведомление!</strong> Пароль должен быть больше 3 символов.');

			$error = 'bad password';

		}

		if (!$error) {
			$user_id = add_user($email, $password);
			edit_information($user_id, $username, $job_title, $phone, $address);
			set_status($user_id, $status);
			upload_avatar($user_id, $image);
			add_social_links($user_id, $telegram, $instagram, $vk);

			set_flash_message('create_user_successful', 'success', 'Пользователь успешно добавлен.');

			redirect ('users.php');
		}
	}




?>