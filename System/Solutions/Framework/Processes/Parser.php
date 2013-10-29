<?php

class Parser {
	private static $parsers;

	public function run($name) {
		if ($name == "platform.start.6") {
			$this->initParsers();
		}
	}

	public static function parse($text) {
		foreach (self::$parsers as $parser) {
			$text = $parser->getText($text);
		}
		return $text;
	}

	public function initParsers() {
		self::$parsers = array();

		foreach (Platform::getSolutions("TextParsers") as $solution) {
			foreach ($solution->getFile()->listSubs() as $item) {
				$item->import();
				$classname = $item->getExtensionlessName();
				array_push(self::$parsers, new $classname());
			}
		}
		
		usort(self::$parsers, "sortByOrder");
	}
}