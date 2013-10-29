<?php

class Session {
	private static $loggedIn, $person;

	public function run($name) {
		if ($name == "platform.start") {
			session_start();
		} else if ($name == "platform.start.5") {
			$this->initLogin();
		} else if ($name == "platform.start.7") {
			$this->initEditing();
		}
	}

	public function initLogin() {
		if (Settings::get("security.demo")) {
			header('X-Frame-Options: GOFORIT');
		}
		if (isset($_COOKIE["cs_auth_id"]) && isset($_COOKIE["cs_auth_key"])) {
			$id = $_COOKIE["cs_auth_id"];
			$key = $_COOKIE["cs_auth_key"];

			$session = new LoginSession(array(
				"id" => $id,
				"cookie" => $key,
				"browser" => Request::getBrowser(),
				"platform" => Request::getPlatform(),
				"ipaddress" => Request::getIPAddress()
			));

			if ($session->exists() && $session->get("user")->exists()) {
				self::$loggedIn = true;
				self::$person = $session->get("user");
				self::$person->set("ipaddress", Request::getIPAddress());
			} else {
				self::$loggedIn = false;
			}
		}
	}

	public function initEditing() {
		if (Permission::can("EditWebsite") && isset($_GET["edit"])) {
			$_SESSION["cs_edit"] = ($_GET["edit"])?true:false;
		}
	}

	public static function loggedIn() {
		if (Settings::get("security.demo")) return true;
		return self::$loggedIn;
	}

	public static function getPerson() {
		if (Settings::get("security.demo")) return new FakePerson();
		return self::$person;
	}

	public static function login($person) {
		$key = Random::getText(256);

		$session = LoginSession::create("LoginSession", array(
			"user" => $person->get("id"),
			"cookie" => $key,
			"sessionid" => session_id(),
			"browser" => Request::getBrowser(),
			"platform" => Request::getPlatform(),
			"ipaddress" => Request::getIPAddress()
		));

		$expire = time()+(86400*365*5);
		setcookie("cs_auth_id", $session->get("id"), $expire, "/");
		setcookie("cs_auth_key", $key, $expire, "/");
	}

	public static function logout() {
		session_destroy();
		setcookie("cs_auth_id", "", 0, "/");
		setcookie("cs_auth_key", "", 0, "/");
	}

	public function isEditing() {
		return $_SESSION["cs_edit"] && Permission::can("EditWebsite");
	}
}