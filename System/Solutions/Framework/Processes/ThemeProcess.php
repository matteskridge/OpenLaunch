<?php

class ThemeProcess {

	private static $themes;

	public function run($name) {
		if ($name == "platform.start.7") {
			self::loadThemes();
		}
	}

	public static function loadThemes() {
		self::$themes = array();

		foreach (Platform::getSolutions("Themes") as $solution) {
			foreach ($solution->getFile()->listSubs() as $sub) {
				foreach ($sub->listSubs() as $sub2) {
					if ($sub2->getExtension() == "css" && $sub2->getName() != "Theme.css")
						array_push(self::$themes, new Theme($sub2));
				}
			}
		}

		$theme = new File("Public/theme.css");
		$notheme = new File("Public/notheme.css");
		if (Settings::get("website.nocache") == "true" || Settings::get("website.nocache") == "1" || !$theme->exists() || !$notheme->exists()) {
			self::resetStyleCache();
			//ScriptProcess::resetScriptCache();
		}
	}

	public static function getThemes() {
		return self::$themes;
	}

	public static function getTheme() {
		$website = Settings::get("website.theme");

		$bits = explode("-", $style);
		$sol = $bits[0];
		$name = $bits[1];
		$style = $bits[2];

		return new File("System/Solutions/$sol/Themes/$name");
	}

	public static function resetStyleCache($theme = "") {
		if ($theme == "") {
			$style = Settings::get("website.theme");
		} else {
			$style = $theme;
		}

		$bits = explode("-", $style);
		$sol = $bits[0];
		$name = $bits[1];
		$style = $bits[2];

		$str = "";

		foreach (Platform::getSolutions("Styles") as $solution) {
			foreach ($solution->getFile()->listSubs() as $sub) {
				$str .= $sub->read() . "\n\n";
			}
		}

		// http://websitetips.com/articles/optimization/css/crunch/
		$str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str);
		$str = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $str);
		$str = str_replace('{ ', '{', $str);
		$str = str_replace(' }', '}', $str);
		$str = str_replace('; ', ';', $str);
		$str = str_replace(', ', ',', $str);
		$str = str_replace(' {', '{', $str);
		$str = str_replace('} ', '}', $str);
		$str = str_replace(': ', ':', $str);
		$str = str_replace(' ,', ',', $str);
		$str = str_replace(' ;', ';', $str);

		$file = new File("Public/notheme.css");
		$file->write($str);

		$str = "";

		$file = new File("System/Solutions/$sol/Themes/$name/Theme.css");
		$str .= $file->read() . "\n\n";

		$file = new File("System/Solutions/$sol/Themes/$name/$style.css");
		$str .= $file->read() . "\n\n";

		// http://websitetips.com/articles/optimization/css/crunch/
		$str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str);
		$str = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $str);
		$str = str_replace('{ ', '{', $str);
		$str = str_replace(' }', '}', $str);
		$str = str_replace('; ', ';', $str);
		$str = str_replace(', ', ',', $str);
		$str = str_replace(' {', '{', $str);
		$str = str_replace('} ', '}', $str);
		$str = str_replace(': ', ':', $str);
		$str = str_replace(' ,', ',', $str);
		$str = str_replace(' ;', ';', $str);

		$file = new File("Public/theme.css");
		$file->write($str);
	}

}

class Theme {

	private $file;
	private $info;
	private $id;
	private $styleid;
	private $solution;
	private $loaded = false;
	private $name;
	private $author;

	public function __construct($theme) {
		$this->id = $theme->getParent()->getName();
		$this->styleid = $theme->getExtensionlessName();
		$this->file = $theme;
		$this->info = $theme->getParent()->getSub("theme.yml");
		$this->solution = $theme->getParent()->getParent()->getParent()->getName();
	}

	public function getName() {
		if (!$this->loaded)
			$this->loadYml();
		return $this->name;
	}
	
	public function getVariant() {
		return $this->styleid;
	}

	public function getAuthorName() {
		if (!$this->loaded)
			$this->loadYml();
		return $this->author["name"];
	}

	public function getAuthorWebsite() {
		if (!$this->loaded)
			$this->loadYml();
		return $this->author["website"];
	}

	public function getImage() {
		return "/theme/image/$this->solution/$this->id/$this->styleid/";
	}

	public function getImageHtml($width = "", $height = "") {
		$file = new File("Public/Images/Data/Themes/" . $this->getId() . "/$width/$height.png");
		if (!$file->exists()) {
			$f = new File("System/Solutions/$this->solution/Themes/$this->id/$this->styleid.png");
			$file->getParent()->makeDirectories();
			$file->write($f->read());
		}
		return "<img src='Images/Data/Themes/" . $this->getId() . "/$width/$height.png' style='width:" . $width . "px;height:" . $height . "px;' />";
	}

	public function getId() {
		return "$this->solution-$this->id-$this->styleid";
	}

	private function loadYml() {
		$this->loaded = true;
		$yml = new Spyc();
		$theme = $yml->YAMLLoadString($this->info->read());

		$this->name = $theme["theme"]["name"];
		$this->author = $yml->YAMLLoadString(base64_decode($theme["theme"]["author"]));
	}

}

