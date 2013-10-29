<?php

require_once("System/Core/Process.php");
require_once("System/Core/Solution.php");
require_once("System/Core/Utilities/File.php");
require_once("System/Core/Utilities/ArrayList.php");
require_once("System/Core/Utilities/Random.php");

require_once("System/Solutions/Framework/Classes/InputField.php");
require_once("System/Solutions/Framework/Fields/TextField.php");
require_once("System/Solutions/Framework/Fields/SelectField.php");

class Platform {

	private static $solutions;
	private static $processes;

	public static function main() {
		self::$solutions = new ArrayList();
		self::$processes = new ArrayList();

		$file = new File("System/Solutions");
		foreach ($file->listSubs() as $f) {
			foreach ($f->listSubs() as $sub) {
				self::$solutions->add($sub);
				self::importFeature($sub);
			}
		}

		Platform::hook("platform.start");
		Platform::hook("platform.main");
		Platform::hook("platform.stop");
	}

	public static function importFeature($f) {
		if ($f->getName() == "Classes") {
			$f->import();
		} else if ($f->getName() == "Processes") {
			foreach ($f->listSubs() as $file) {
				self::$processes->add(new Process($file));
			}
		}
	}

	public static function getSolutions($name) {
		$arr = array();
		foreach (self::$solutions->each() as $sol) {
			if ($sol->getParent()->getSub("disabled")->exists())
				continue;
			if (strtolower($sol->getName()) == strtolower($name))
				array_push($arr, new Solution($sol));
		}
		return $arr;
	}

	public static function hook($name) {
		for ($i = 0; $i < 10; $i++) {
			foreach (self::$processes->each() as $proc) {
				if ($i == 0) {
					$proc->run("$name");
				} else {
					$proc->run("$name.$i");
				}
			}
		}
	}

	public static function listModels() {
		$arr = array();
		foreach (self::getSolutions("Models") as $file) {
			foreach ($file->getFile()->listSubs() as $item)
				array_push($arr, $item->getExtensionlessName());
		}
		return $arr;
	}

}

