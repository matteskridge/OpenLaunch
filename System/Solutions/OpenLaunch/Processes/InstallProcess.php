<?php

class InstallProcess {

	private static $setupDB = false;
	private static $notinstalled = false;

	public function run($name) {
		if ($name == "platform.start.1") {
			$file = new File("System/Data");
			if (!$file->exists()) {
				self::$notinstalled = true;
				self::install();
			}
		} else if ($name == "platform.start.8") {
			$file = new File("System/Data");
			$login = new File("System/Data/superadmins.yml");
			if ($file->exists() && !$login->exists()) {
				self::createAdmin();
			}
		} else if ($name == "platform.start.9") {
			if (self::$setupDB) {
				self::createSql();
			}
		}
	}

	public static function install() {
		if (isset($_POST["website-name"])) {

			$error = "";
			if (@mysql_connect($_POST["database-server"], $_POST["database-user"], $_POST["database-password"])) {
				mysql_query("CREATE DATABASE IF NOT EXISTS `" . mysql_real_escape_string($_POST["database-name"]) . "`");
				if (@mysql_select_db($_POST["database-name"])) {

					$f = new File("System/Data/Settings");
					$f->makeDirectories();
					$f = new File("System/Data/Credentials");
					$f->makeDirectories();

					self::$setupDB = true;

					Settings::save("website", array(
						"name" => $_POST["website-name"],
						"description" => $_POST["website-description"],
						"theme" => "OpenLaunch-Open-Blue",
						"link" => $_POST["website-link"]
					));

					Settings::save("database", array(
						"server" => $_POST["database-server"],
						"user" => $_POST["database-user"],
						"password" => $_POST["database-password"],
						"name" => $_POST["database-name"],
					));

					header("Location: /");
					Request::disableController();
					Response::redirect("/");
					return;
				} else {
					$error = "The MySQL database you provided does not exist.";
				}
			} else {
				$error = "The MySQL username/password you provided is incorrect";
			}
		}

		Response::ajax(Component::get("OpenLaunch.Installer", array("error" => $error)));
	}

	public static function createSql() {
		foreach (Platform::getSolutions("Models") as $sol) {
			foreach ($sol->getFile()->listSubs() as $sub) {
				$name = $sub->getExtensionlessName();
				$sub->import();
				$model = new $name();
				mysql_query($model->getTableSQL()) or die(mysql_error());
			}
		}

		$roles = array(array(
				"name" => "Administrators",
				"permissions" => array("*")
			), array(
				"name" => "People",
				"allmembers" => "1"
			), array(
				"name" => "Guests",
				"allguests" => "1"
			), array(
				"name" => "Editor",
				"permissions" => array("EditWebsite")
		));

		foreach ($roles as $role)
			Role::create("Role", $role);

		Page::create("Page", array(
			"name" => "Home",
			"home" => "1",
			"html" => Component::get("OpenLaunch.WelcomePage"),
			"template" => "BasicPageType"
		));
	}

	public static function createAdmin() {
		if (isset($_GET["openid"])) {
			$response = OpenID::client($_GET["openid"]);
			if ($response instanceof Redirect) {
				Request::disableController();
				Response::redirect($response);
				return;
			} else if (is_array($response)) {
				$response["roles"] = array("1", "2", "4");
				Session::login(Person::create("Person", $response));
				$file = new File("System/Data/superadmins.yml");
				$file->write("");

				ThemeProcess::resetStyleCache();

				header("Location: /");
				Request::disableController();
				Response::redirect($response);
				return;
			}
		}
		Response::ajax(Component::get("OpenLaunch.Installer", array("login" => 1)));
	}

	public static function installed() {
		$file = new File("System/Data");
		if (self::$notinstalled)
			return false;
		return $file->exists();
	}

}

