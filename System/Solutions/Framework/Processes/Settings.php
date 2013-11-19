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
			foreach ($settings as $key => $set) $config[$key] = $set;
		}

		self::$settings = $config;
	}

	public static function get($name) {
		return (array_key_exists($name, self::$settings))?self::$settings[$name]:"";
	}
	
	public static function save($name, $data) {
		$file = new File("System/Data/Settings/$name.php");
		$text = "<?php\n";
		
		$arr = array();
		foreach (self::$settings as $k => $v) {
			if (substr($k, 0, strlen($name.".")) == $name.".") $arr[$k] = $v;
		}
		
		foreach ($data as $k => $v) {
			$arr["$name.".$k] = $v;
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
}
