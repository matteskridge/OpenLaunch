<?php

class Component {

	private static $index;

	public function run($name) {
		if ($name == "platform.start") {
			self::index();
		}
	}

	public static function index() {
		self::$index = array();
		foreach (Platform::getSolutions("Components") as $item) {
			foreach ($item->getFile()->listSubs() as $sub) {
				self::$index[$item->getFile()->getParent()->getName() . "." . $sub->getExtensionlessName()] = $sub;
			}
		}
	}

	public static function get($name, $arr = array()) {
		if (substr($name, 0, 2) == "*.") {
			$text = "";
			foreach (self::$index as $key => $value) {
				$bits = explode(".", $key);
				$bits2 = explode(".", $name);
				if ($bits[1] == $bits2[1]) {
					if (!is_array($arr))
						$send = array("content" => $arr);
					else
						$send = $arr;
					$text .= self::template($value, $send);
				}
			}
			return $text;
		} else {
			if (!is_array($arr))
				$arr = array("content" => $arr);
			return (array_key_exists($name, self::$index)) ? self::template(self::$index[$name], $arr) : "";
		}
	}

	public static function template($file, $args) {
		foreach ($args as $cs_key => $cs_arg) {
			eval("$$cs_key = \$cs_arg;");
		}
		ob_start("ob_error_handler");
		@include($file->getPath());
		return ob_get_clean();
	}

}

function ob_error_handler($str) {
	$error = error_get_last();
	if ($error && $error["type"] == E_USER_ERROR || $error["type"] == E_ERROR) {
		return ini_get("error_prepend_string") .
				"\nFatal error: $error[message] in $error[file] on line $error[line]\n" .
				ini_get("error_append_string");
	}
	return $str;
}

