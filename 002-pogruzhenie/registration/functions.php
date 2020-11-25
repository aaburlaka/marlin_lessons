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
		$data['password'] = $_POST['password'];

		$sth = $dbh->prepare($sql);
		$sth->execute($data);

		set_flash_message('registration_successful', true);

		header('Location: page_login.php');
	}

	function set_flash_message($name, $message) {
		$_SESSION[$name] = $message;
	}

	function display_flash_message($name) {
		$message = $_SESSION[$name];
		unset($_SESSION[$name]);

		return $message;
	}

?>