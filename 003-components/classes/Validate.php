<?php

	class Validate {
		private $errors;

		public function __construct() {
			$this->db = Database::getInstance();
		}

		public function check($data, $checkings = []) {
			if (empty($checkings))
				return;

			foreach ($checkings as $key => $rules) {
				$field = $data[$key];

				foreach ($rules as $rule => $compliance) {
					if ($rule == 'required' && $compliance && empty($field)) {
						$this->add_error("$key is required");
					}
					if ($rule == 'str' && !is_string($field)) {
						$this->add_error("$key is not a string");
					}
					if ($rule == 'int' && !is_int($field)) {
						$this->add_error("$key is not integer");
					}
					if ($rule == 'min' && strlen($field) < $compliance) {
						$this->add_error("$key is less than $compliance");
					}
					if ($rule == 'max' && strlen($field) > $compliance) {
						$this->add_error("$key is bigger than $compliance");
					}
					if ($rule == 'matches' && $field != $data[$compliance]) {
						$this->add_error("$key doesn't matches $compliance");
					}
					if ($rule == 'email' && !filter_var($field, FILTER_VALIDATE_EMAIL)) {
						$this->add_error("$key is not e-mail");
					}
					if ($rule == 'unique') {
						$check = $this->db->get($compliance, [$key, '=', $field]);
						if($check->count()) {
								$this->add_error("$key already exists");
						}
					}

				}
			}
		}

		private function add_error($error) {
			$this->errors[] = $error;
		}

		public function passed() {
			if (!$this->errors)
				return true;
		}

		public function errors() {
			if ($this->errors)
				return $this->errors;
		}
	}
?>