<?php

class Profiler {
	public function run($name) {
		if ($name == "platform.stop.9") {
			self::showProfiler();
		}
	}

	public static function showProfiler() {
		if (Request::isProfiling() && class_exists("Component")) {
			if ($_GET["profile"] == 0) {
				$_SESSION["cs_profile"] = "0";
			} else {
				$_SESSION["cs_profile"] = "1";
			}
			echo Component::get("CreationShare.Profiler", array("speed" => Process::getSpeed()));
		}
	}
}