<?
	// error_reporting(E_ALL & ~E_NOTICE);

/*
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `vk` varchar(50) DEFAULT NULL,
  `telegram` varchar(50) DEFAULT NULL,
  `instagram` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES
(1, 'artbur@yandex.ru', '$2y$10$NGD7RSdSPPNcMHSVRGkhEertHiqVsE7dmJiVcUj7YdSj.v/8oKLn.', 'admin', 'Artem Burlaka', 'avatar-m.png', 'Web developer, Gotbootstrap Inc.', 'success', ' +1 313-779-9376', '35 Gallery St, Detroit, MI, 48946, USA', 'burlaka', 'burlaka', 'aaburlaka'),
(2, 'oliver.kopyov@smartadminwebapp.com', NULL, 'user', 'Oliver Kopyov', 'avatar-b.png', 'IT Director, Gotbootstrap Inc.', 'success', '+1 317-456-2564', '15 Charist St, Detroit, MI, 48212, USA', 'none', 'none', 'none'),
(3, 'Alita@smartadminwebapp.com', NULL, NULL, 'Alita Gray', 'avatar-c.png', 'Project Manager, Gotbootstrap Inc.', 'warning', '+1 313-461-1347', '134 Hamtrammac, Detroit, MI, 48314, USA', 'none', 'none', 'none'),
(4, ' john.cook@smartadminwebapp.com', NULL, NULL, 'Dr. John Cook PhD', 'avatar-e.png', 'Human Resources, Gotbootstrap Inc.', 'danger', '+1 313-779-1347', '55 Smyth Rd, Detroit, MI, 48341, USA', 'none', 'none', 'none'),
(5, ' jim.ketty@smartadminwebapp.com', NULL, NULL, 'Jim Ketty', 'avatar-k.png', 'Staff Orgnizer, Gotbootstrap Inc.', 'success', ' +1 313-779-3314', '134 Tasy Rd, Detroit, MI, 48212, USA', 'none', 'none', 'none'),
(6, ' john.oliver@smartadminwebapp.com', NULL, NULL, 'Dr. John Oliver', 'avatar-g.png', 'Oncologist, Gotbootstrap Inc.', 'success', ' +1 313-779-8134', '134 Gallery St, Detroit, MI, 46214, USA', 'none', 'none', 'none'),
(7, ' sarah.mcbrook@smartadminwebapp.com', NULL, NULL, 'Sarah McBrook', 'avatar-h.png', 'Xray Division, Gotbootstrap Inc.', 'success', ' +1 313-779-7613', '13 Jamie Rd, Detroit, MI, 48313, USA', 'none', 'none', 'none'),
(8, ' jimmy.fallan@smartadminwebapp.com', NULL, NULL, 'Jimmy Fellan  ', 'avatar-i.png', 'Accounting, Gotbootstrap Inc.', 'success', ' +1 313-779-4314', '55 Smyth Rd, Detroit, MI, 48341, USA', 'none', 'none', 'none'),
(9, ' arica.grace@smartadminwebapp.com', NULL, NULL, 'Arica Grace', 'avatar-j.png', 'Accounting, Gotbootstrap Inc.', 'success', ' +1 313-779-3347', '798 Smyth Rd, Detroit, MI, 48341, USA', 'none', 'none', 'none');


*/

	session_start();

	$host = 'localhost';
	$base = 'marlin_lessons';
	$user = 'root';
	$pass = '';

	$dbh = new PDO('mysql:host='.$host.';dbname='.$base.';', $user, $pass);

/*
	CREATE TABLE `users` (
		`id` INT(11) AUTO_INCREMENT PRIMARY KEY,
		`email` VARCHAR(50),
		`password` VARCHAR(50)
	)
*/

	function get_user_by_email($email) {
		global $dbh;

		$sql = 'SELECT id FROM users WHERE email = :email';

		$data['email'] = $email;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
		$exists = $sth->fetch(PDO::FETCH_ASSOC);

		if ($exists)
			return $exists['id'];
	}

	function check_email($email) {
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		if ($email)
			return $email;
	}

	function check_password($password) {
		if (strlen($password) > 3)
			return $password;
	}

/*
 *	Start registration functions
 */
	function add_user($email, $password) {
		global $dbh;

		$sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';

		$data['email'] = $email;
		$data['password'] = password_hash($password, PASSWORD_DEFAULT);

		$sth = $dbh->prepare($sql);
		$sth->execute($data);

		return $dbh->lastInsertId();
	}

	function edit_information($user_id, $username, $job_title, $phone, $address) {
		global $dbh;

		$sql = 'UPDATE users SET username = :username, job_title = :job_title, phone = :phone, address = :address WHERE id = :id';

		$data['id'] = $user_id;
		$data['username'] = $username;
		$data['job_title'] = $job_title;
		$data['phone'] = $phone;
		$data['address'] = $address;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
	}

	function set_status($user_id, $status) {
		global $dbh;

		$sql = 'UPDATE users SET status = :status WHERE id = :id';

		$data['id'] = $user_id;
		$data['status'] = $status;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
	}


	function upload_avatar($user_id, $image) {
		global $dbh;

		if ($_FILES['avatar']['error'] == 0 && $_FILES['avatar']['size'] != 0 ) {
			//  upload new avatar
			$extension  = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
			$newname = uniqid().'.'.$extension;
			$avatar = 'avatars/'.$newname;

			move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);

			// get and delete old avatar
			$sql = 'SELECT avatar FROM users WHERE id = :id';

			$data['id'] = $user_id;

			$sth = $dbh->prepare($sql);
			$sth->execute($data);
			$fetch = $sth->fetch(PDO::FETCH_ASSOC);

			if ($fetch['avatar'])
				unlink($fetch['avatar']);


			// set new avatar
			$sql = 'UPDATE users SET avatar = :avatar WHERE id = :id';

			$data['id'] = $user_id;
			$data['avatar'] = $avatar;

			$sth = $dbh->prepare($sql);
			$sth->execute($data);
		}
	}

	function add_social_links($user_id, $telegram, $instagram, $vk) {
		global $dbh;

		$sql = 'UPDATE users SET telegram = :telegram, instagram = :instagram, vk = :vk WHERE id = :id';

		$data['id'] = $user_id;
		$data['telegram'] = $telegram;
		$data['instagram'] = $instagram;
		$data['vk'] = $vk;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
	}

/*
 *	End registration functions
 */

	function set_flash_message($name, $type, $message) {
		$_SESSION[$name][$type] = $message;
	}

	function display_flash_message($name) {
		if ($_SESSION[$name]) {
			foreach ($_SESSION[$name] as $type => $message) {
?>
                                    <div class="alert alert-<?=$type?> text-dark" role="alert">
                                        <?=$message?>
                                    </div>
<?
			}

			unset($_SESSION[$name]);
		}
	}

	function login() {
		global $dbh;

		$sql = 'SELECT * FROM users WHERE email = :email';
		$sth = $dbh->prepare($sql);
		$sth->execute([
			'email' => $_POST['email']
		]);
		$result = $sth->fetch(PDO::FETCH_ASSOC);

		if ($result == 0)
			$error = true;
		elseif (!password_verify($_POST['password'], $result['password']))
			$error = true;

		if ($_POST && $error) {
			empty($_SESSION);

			set_flash_message('auth_error', 'danger', 'Неверный e-mail или пароль');

			return false;
		}
		else {
			$_SESSION['auth'] = $result['email'];
			$_SESSION['id'] = $result['id'];
			$_SESSION['role'] = $result['role'];
			return true;
		}
	}

	function redirect ($link) {
		header('Location: '.$link);
		exit;
	}

	function is_not_logged_in () {
		if (!$_SESSION['auth'])
			return true;
	}

	function users() {
		$users_list = get_users();

		return $users_list;
	}

	function get_users() {
		global $dbh;

		$sql = 'SELECT * FROM users';
		$sth = $dbh->prepare($sql);
		$sth->execute([
			'email' => $_POST['email']
		]);
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	function is_admin() {
		if ($_SESSION['role'] == 'admin')
			return true;
	}



	function users_view($users_list) {
		foreach ($users_list as $user) {
			$tags = mb_strtolower($user['username'], 'UTF-8');

			$status['online'] = 'success';
			$status['away'] = 'warning';
			$status['busy'] = 'danger';
?>
                <div class="col-xl-4">
                    <div id="c_<?=$user['id']?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?=$tags?>">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">
                                <span class="status status-<?=$status[$user['status']]?> mr-3">
                                    <span class="rounded-circle profile-image d-block " style="background-image:url('<?=$user['avatar']?>'); background-size: cover;"></span>
                                </span>
                                <div class="info-card-text flex-1">
<?
	if (is_admin() || $_SESSION['id'] == $user['id']) {
?>
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                        <?=$user['username']?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="edit.php?id=<?=$user['id']?>">
                                            <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                        <a class="dropdown-item" href="security.php?id=<?=$user['id']?>">
                                            <i class="fa fa-lock"></i>
                                        Безопасность</a>
                                        <a class="dropdown-item" href="status.php?id=<?=$user['id']?>">
                                            <i class="fa fa-sun"></i>
                                        Установить статус</a>
                                        <a class="dropdown-item" href="media.php?id=<?=$user['id']?>">
                                            <i class="fa fa-camera"></i>
                                            Загрузить аватар
                                        </a>
                                        <a href="#" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                            Удалить
                                        </a>
                                    </div>
<?
	}
	else {
		echo $user['username'];
	}
?>
                                    <span class="text-truncate text-truncate-xl"><?=$user['job_title']?></span>
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_<?=$user['id']?> > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">
                                <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> <?=$user['phone']?></a>
                                <a href="mailto:<?=$user['email']?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?=$user['email']?></a>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i> <?=$user['address']?></address>
                                <div class="d-flex flex-row">
                                    <a href="https://vk.me/<?=$user['vk']?>" class="mr-2 fs-xxl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                    <a href="https://t.me/<?=$user['telegram']?>" class="mr-2 fs-xxl" style="color:#38A1F3">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                    <a href="https://instagram.com/<?=$user['instagram']?>" class="mr-2 fs-xxl" style="color:#E1306C">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?
		}
		return;
	}

	function is_author($edit_user_id) {
		if ($_SESSION['id'] == $edit_user_id || $_SESSION['role'] == 'admin')
			return true;
	}

	function get_user_by_id($id) {
		global $dbh;

		$sql = 'SELECT * FROM users WHERE id = :id';

		$data['id'] = $id;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
		$user = $sth->fetch(PDO::FETCH_ASSOC);

		if ($user)
			return $user;

	}

	function edit_credentials($id, $email, $password) {
		global $dbh;

		if (!$email = check_email($email))
			$error = 'Неверно введен электронный адрес.';

		if ($user = get_user_by_email($email) && ($email != $_SESSION['auth'] && $_SESSION['role'] != 'admin')) {
			echo $email.' != '.$_SESSION['auth'];

			$error = 'Это электронный адрес уже занят.';
		}

		if (!$password = check_password($password))
			$error = 'Пароль должен быть больше 3 символов.';

		if (!$error) {
			$sql = 'UPDATE users SET email = :email, password = :password WHERE id = :id';

			$data['id'] = $id;
			$data['email'] = $email;
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);

			$sth = $dbh->prepare($sql);
			$sth->execute($data);
		}
		else
			return $error;
	}

?>