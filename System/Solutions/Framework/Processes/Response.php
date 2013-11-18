<?php

class Response {

	private static $response, $controller, $action, $args, $nowrap, $title = "";

	public function run($name) {
		if ($name == "platform.start.8") {
			self::respond();
		} else if ($name == "platform.main.7") {
			self::sendResponse();
		}
	}

	public static function respond() {
		//if ($link = LinkMap::contains(Request::getUrl())) {
		//	self::$controller = $link["controller"];
		//	self::$action = $link["action"];
		//	self::$args = $link["args"];
		//} else {
		$url = Request::getUrlBits();

		$length = count($url);
		if ($length == 0) {
			$controller = "index";
			$action = "index";
			$args = array();
		} else if ($length == 1) {
			$controller = $url[0];
			$action = "index";
			$args = array();
		} else if ($length == 2) {
			$controller = $url[0];
			$action = (is_numeric($url[1])) ? "view" : $url[1];
			$args = (is_numeric($url[1])) ? array($url[1]) : array();
		} else if ($length > 2) {
			$controller = $url[0];
			$action = (is_numeric($url[1])) ? "view" : $url[1];
			$args = (is_numeric($url[1])) ? array($url[1]) : array();
			array_shift($url);
			array_shift($url);
			foreach ($url as $item)
				array_push($args, $item);
		}

		self::$controller = $controller;
		self::$action = $action;
		self::$args = $args;
		//}
	}

	public static function getController() {
		return self::$controller;
	}

	public static function getAction() {
		return self::$action;
	}

	public static function getArgs() {
		return self::$args;
	}

	public static function getArg($arg) {
		if (array_key_exists($arg, self::$args))
			return self::$args[$arg];
		return false;
	}

	public static function notFound() {
		self::$response = new NotFoundError();
	}

	public static function html($text, $nowrap = false) {
		if (self::$response instanceof Redirect)
			return false;
		Request::disableController();
		self::$nowrap = $nowrap;
		self::$response = new HtmlResponse($text);
	}

	public static function ajax($text) {
		Request::disableController();
		self::$response = new AjaxResponse($text);
	}

	public static function sendResponse() {
		if (self::$response instanceof NotFoundError || self::$response == null) {
			self::$response = new HtmlResponse(Component::get("OpenLaunch.NotFound"));
		}

		if (self::$response instanceof HtmlResponse) {
			echo Component::get("Framework.Template", array(
				"content" => self::$response,
				"nowrap" => self::$nowrap
			));
		} else if (self::$response instanceof AjaxResponse) {
			echo self::$response;
		} else if (self::$response instanceof Redirect) {
			header("Location: " . self::$response);
		}
	}

	public static function getTitle() {
		return (self::$title == "") ? Website::getName() : self::$title . " - " . Website::getName();
	}

	public static function setTitle($title) {
		self::$title = $title;
	}

	public static function redirect($where) {
		if (!($where instanceof Redirect)) {
			self::$response = new Redirect($where);
		}
		self::$response = $where;
	}

	public static function flash($text) {
		$_SESSION["flash"] = $text;
	}

	public static function hasFlash() {
		return isset($_SESSION["flash"]) && $_SESSION["flash"] != "";
	}

	public static function getFlash() {
		$flash = $_SESSION["flash"];
		$_SESSION["flash"] = "";
		return $flash;
	}

}

class NotFoundError {

}

class HtmlResponse {

	public $text;

	public function __construct($text) {
		$this->text = $text;
	}

	public function __toString() {
		return $this->text;
	}

}

class AjaxResponse {

	public $text;

	public function __construct($text) {
		$this->text = $text;
	}

	public function __toString() {
		return $this->text;
	}

}

class Redirect {

	private $text;

	public function __construct($where) {
		$this->text = $where;
	}

	public function __toString() {
		return $this->text;
	}

}

