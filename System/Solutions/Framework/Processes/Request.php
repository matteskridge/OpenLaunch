<?php

class Request {
	private static $agent, $ip, $url, $browser, $platform, $form, $crawler;

	public function run($name) {
		if ($name == "platform.start.1") {
			$this->init();
		}
	}

	public function init() {
		self::$agent = self::fetchServer("HTTP_USER_AGENT");
		self::$ip = self::fetchServer("REMOTE_ADDR");
		self::$url = self::fetchUrlArg("url");
		self::$browser = self::fetchBrowser();
		self::$platform = self::fetchPlatform();
		self::$form = self::fetchForm();
		self::$crawler = self::fetchCrawler();
	}

	private static function fetchServer($name) {
		return $_SERVER[$name];
	}

	public static function fetchUrlArg($name) {
		if (isset($_GET[$name])) {
			return $_GET[$name];
		} else {
			return "";
		}

	}

	public static function getPost($name) {
		if (isset($_POST[$name])) {
			return $_POST[$name];
		} else {
			return "";
		}

	}

	private static $browsers = array(
		"opera" => "Opera",
		"chrome" => "Chrome",
		"safari" => "Safari",
		"webkit" => "Safari",
		"mozilla" => "Firefox",
		"firefox" => "Firefox",
		"msie" => "InternetExplorer",
	);

	private static function fetchBrowser() {
		$agent = self::$agent;
		$possible = self::$browsers;

		foreach ($possible as $item => $value) {
			if (strstr(strtolower($agent), strtolower($item))) return $possible[$item];
		}

		return "unknown";
	}

	private static $platforms = array(
		"mac" => "MacOS",
		"windows" => "Windows",
		"linux" => "Linux",
		"ubuntu" => "Linux",
		"android" => "Android",
		"ios" => "iOS"
	);

	private static function fetchPlatform() {
		$agent = self::$agent;
		$possible = self::$platforms;

		foreach ($possible as $item => $value) {
			if (strstr(strtolower($agent), strtolower($item))) return $possible[$item];
		}

		return "Unknown";
	}

	private static $forms = array(
		"ios" => "Mobile",
		"android" => "Mobile",
		"mac" => "Desktop",
		"windows" => "Desktop",
		"linux" => "Desktop",
		"ubuntu" => "Desktop"
	);

	private static function fetchForm() {
		$agent = self::$agent;
		$possible = self::$forms;

		foreach ($possible as $item => $value) {
			if (strstr(strtolower($agent), strtolower($item))) return $possible[$item];
		}

		return "Unknown";
	}

	private static $crawlers = array(
		"googlebot" => "google",
		"bingbot" => "bing",
		"msnbot" => "bing",
		"yandexbot" => "yandex"
	);

	private static function fetchCrawler() {
		$agent = self::$agent;
		$possible = self::$crawlers;

		foreach ($possible as $item => $value) {
			if (strstr(strtolower($agent), strtolower($item))) return $possible[$item];
		}

		return "Unknown";
	}

	public static function getUrl() {
		return self::$url;
	}

	public static function getAgent() {
		return self::$agent;
	}

	public static function getBrowser() {
		return self::$browser;
	}

	public static function getPlatform() {
		return self::$platform;
	}

	public static function getIPAddress() {
		return self::$ip;
	}

	public static function isMobile() {
		return self::$form == "Mobile";
	}

	public static function isDesktop() {
		return self::$form == "Desktop";
	}

	public static function isTablet() {
		return self::$form == "Tablet";
	}

	public static function getUrlBits() {
		$url = self::$url;
		if (strstr($url, "?")) {
			$url = substr($url, 0, strpos($url, "?"));
			echo $url."\n";
		}
		$bits = explode("/", $url);

		$arr = array();
		foreach ($bits as $bit) if ($bit != "") array_push($arr, $bit);
		return $arr;
	}

	public static function getReferer() {
		return $_SERVER["HTTP_REFERER"];
	}

	public static function isProfiling() {
		return isset($_GET["profile"]) || (isset($_SESSION["cs_profile"]) && $_SESSION["cs_profile"] == 1);
	}

	public static function getDomain() {
		return $_SERVER["HTTP_HOST"];
	}

	private static $noController = false;
	public static function disableController() {
		self::$noController = true;
	}

	public static function noController() {
		return self::$noController;
	}

	public static function getCrawler() {
		return self::$crawler;
	}

	public static function getForm() {
		return self::$form;
	}

	public static function getPlatforms() {
		return self::$platforms;
	}

	public static function getBrowsers() {
		return self::$browsers;
	}

	public static function getCrawlers() {
		return self::$crawlers;
	}

	public static function getForms() {
		return self::$forms;
	}
	
	private static $types = array(
		"rss" => "rss"
	);
	private static $type;
	
	public static function getType() {
		if (!isset(self::$type)) {
			$type = "html";
			
			foreach (self::$types as $t) {
				$url = Request::getUrl();
				if (substr($url, strlen($url)-strlen($t)-1, strlen($t)+1) == ".".$t) {
					$type = $t;
					break;
				}
			}
			
			self::$type = $type;
		}
		return self::$type;
	}
	
	public static function isHtml() {
		return self::getType() == "html";
	}
	
	public static function isRSS() {
		return self::getType() == "rss";
	}

	public static function getProtocol() {
		return ($_SERVER["HTTPS"])?"https":"http";
	}

	public static function getBase() {
		if (Settings::get("website.link") == "") {
			return Request::getProtocol()."://".Request::getDomain()."/";
		}

		$link = Settings::get("website.link");
		if (substr($link, 0, 1) == "/") $link = substr($link, 1);
		return Request::getProtocol()."://".Request::getDomain()."/".$link;
	}
}