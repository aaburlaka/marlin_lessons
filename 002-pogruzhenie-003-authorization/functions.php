<?

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

		$sql = 'SELECT * FROM users WHERE email = :email';

		$data['email'] = $email;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
		$exists = $sth->fetch(PDO::FETCH_ASSOC);

		if ($exists)
			return true;
	}

	function add_user() {
		global $dbh;

		$sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';

		$data['email'] = $_POST['email'];
		$data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);;

		$sth = $dbh->prepare($sql);
		$sth->execute($data);
	}

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

		if ($error) {
			set_flash_message('auth_error', 'danger', 'Неверный e-mail или пароль');
			return false;
		}
		else {
			$_SESSION['auth'] = $_POST['email'];
			return true;
		}
	}

	function redirect ($link) {
		header('Location: '.$link);
		exit;
	}
?>