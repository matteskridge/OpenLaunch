<?php

class Settings {

	public function run($name) {
		if ($name == "platform.start.1") {
			$this->importSettings();
		}
	}

	private static $settings;

	public function importSettings() {
		$file = new File("System/Data/Settings");
		if (!$file->exists()) {
			self::$settings = array();
			return;
		}

		$config = array();
		foreach ($file->listSubs() as $f) {
			$settings = array();
			include($f->getPath());
			foreach ($settings as $key => $set)
				$config[$key] = $set;
		}

		self::$settings = $config;
	}

	public static function get($name) {
		if (strstr($name, ".")) {
			return (array_key_exists($name, self::$settings)) ? self::$settings[$name] : "";
		} else {
			$arr = array();

			foreach (self::$settings as $key => $value) {
				if (strpos($key, "$name.") === 0) {
					$arr[substr($key, strlen("$name."))] = $value;
				}
			}

			return $arr;
		}
	}

	public static function save($name, $data) {
		$file = new File("System/Data/Settings/$name.php");
		$text = "<?php\n";

		$arr = array();
		if (is_array(self::$settings))
			foreach (self::$settings as $k => $v) {
				if (substr($k, 0, strlen($name . ".")) == $name . ".")
					$arr[$k] = $v;
			}

		foreach ($data as $k => $v) {
			$arr["$name." . $k] = $v;
		}

		foreach ($arr as $key => $value) {
			$value = htmlentities($value);
			$text .= "\$settings[\"$key\"] = \"$value\";\n";
		}

		$file->write($text);
	}

	public static function set($key, $value) {
		$bits = explode(".", $key);
		$file = $bits[0];
		Settings::save($file, array($bits[1] => $value));
	}

	public static function getLogo() {
		if (Settings::get("website.logo") == "") {
			return Settings::get("website.name");
		} else {
			$file = new File(Settings::get("website.logo"));
			$public = $file->getSub("public.txt")->read();

			$scale = (Settings::get("website.scale") != "")?Settings::get("website.scale"):"1";
			$scale = ($scale*100)."%";

			$top = (Settings::get("website.logoTop") != "")?Settings::get("website.logoTop"):"0";
			$bottom = (Settings::get("website.logoBottom") != "")?Settings::get("website.logoBottom"):"0";

			$top = $top."px";
			$bottom = $bottom."px";

			return "<img src='/file/attachment/".$file->getName()."/?public=$public' width='$scale' style='margin-top:$top;margin-bottom:$bottom;' alt='".Settings::get("website.name")."' />";
		}
	}

}
