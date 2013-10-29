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

		$config = array();
		foreach ($file->listSubs() as $f) {
			$settings = array();
			@include($f->getPath());
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
		
		foreach ($data as $key => $value) {
			$text .= "\$settings[\"$name.$key\"] = \"$value\";\n";
		}
		
		$file->write($text);
	}
}