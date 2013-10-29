<?php

class Template {
	public static function listTemplates() {
		$arr = array();
		foreach (Platform::getSolutions("Templates") as $solution) {
			foreach ($solution->getFile()->listSubs() as $item) {
				array_push($arr, $item);
			}
		}
		return $arr;
	}

	public static function get($name, $content, $page) {
		foreach (Platform::getSolutions("Templates") as $solution) {
			foreach ($solution->getFile()->listSubs() as $item) {
				if (str_replace(".php", "", $solution->getFile()->getParent()->getName().".".$item->getName()) == $name) {
					ob_start();
					@include($item->getPath());
					return ob_get_clean();
				}
			}
		}
		return "Template does not exist.";
	}
}