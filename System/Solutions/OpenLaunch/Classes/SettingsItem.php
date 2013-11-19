<?php

class SettingsItem {
	public function getId() {
		return strtolower(str_replace("SettingsItem", "", get_class($this)));
	}
	
	public function getOrder() {
		return 1000;
	}
	
	public function getContent() {
		return "";
	}
	
	public static function listAll() {
		$arr = array();
		
		foreach (Platform::getSolutions("SettingsItems") as $sol) {
			foreach ($sol->getFile()->listSubs() as $item) {
				$item->import();
				$classname = $item->getExtensionlessName();
				$obj = new $classname();
				array_push($arr, $obj);
			}
		}
		
		usort($arr, "sortByOrder");
		return $arr;
	}
}