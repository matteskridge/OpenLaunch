<?php

class Controller {
	private static $controller, $file;

	public function run($name) {
		if ($name == "platform.main.2") {
			$this->runController();
		}
	}

	public function runController() {
		if (Request::noController()) return;
		$controller = Response::getController();
		$classname = ucfirst($controller)."Controller";

		foreach (Platform::getSolutions("Controllers") as $solution) {
			foreach ($solution->getFile()->listSubs() as $item) {
				if (strtolower($item->getName()) == strtolower($controller)) {
					foreach ($item->listSubs() as $sub) {
						if (strstr($sub->getName(), $classname)) {
							$classname = $sub->getExtensionlessName();
							require_once($sub->getPath());

							self::$controller = new $classname();
							self::$file = $item;
							if (method_exists(self::$controller, "_before")) self::$controller->_before();
							break;
						}
					}
				}
			}
		}

		if (self::$controller == null) {
			Response::notFound();
		}
	}

	public static function getController() {
		return self::$controller;
	}

	public static function getFile() {
		return self::$file;
	}

	public static function getView($action) {
		return self::$file->getSub($action.".php");
	}
}

class AppController {

}