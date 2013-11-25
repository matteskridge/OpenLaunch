<?php

class Session {

	private static $loggedIn, $person;

	public function run($name) {
		if ($name == "platform.start.2") {
			session_start();
		} else if ($name == "platform.start.5" && InstallProcess::installed()) {
			$this->initLogin();
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

	public static function loggedIn() {
		if (Settings::get("security.demo"))
			return true;
		return self::$loggedIn;
	}

	public static function getPerson() {
		if (Settings::get("security.demo"))
			return new FakePerson();
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

		$expire = time() + (86400 * 365 * 5);
		setcookie("cs_auth_id", $session->get("id"), $expire, "/");
		setcookie("cs_auth_key", $key, $expire, "/");
	}

	public static function logout() {
		session_destroy();
		setcookie("cs_auth_id", "", 0, "/");
		setcookie("cs_auth_key", "", 0, "/");
	}

	private static $showAdminBar = null;

	public static function showAdminBar() {
		if (self::$showAdminBar != null)
			return self::$showAdminBar;
		$result = false;

		foreach (Platform::getSolutions("ControlItems") as $sol) {
			foreach ($sol->getFile()->listSubs() as $sub) {
				$name = $sub->getExtensionlessName();
				$sub->import();
				$obj = new $name();
				if ($obj->canView()) {
					$result = true;
					break 2;
				}
			}
		}

		self::$showAdminBar = $result;
		return $result;
	}

}

