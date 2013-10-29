<?php

class Process {
	private $file;
	private $object;
	private static $speed = array();

	public function __construct($file) {
		$file->import();
		$this->file = $file;
		$classname = $file->getExtensionlessName();
		$this->object = new $classname();
	}

	public function run($name) {
		if (!method_exists($this->object, "run")) return;

		if (Request::isProfiling()) $start = microtime(true);
		$this->object->run($name);

		if (Request::isProfiling()) {
			if (!array_key_exists($this->file->getName(), Process::$speed)) {
				Process::$speed[$this->file->getName()] = 0;
			}

			$number = microtime(true)-$start;
			if ($number < 1000) Process::$speed[$this->file->getName()] += $number;
		}
	}

	public function getName() {
		return $this->file->getName();
	}

	public function getSpeed() {
		arsort(Process::$speed);
		return Process::$speed;
	}

	public function getTotalSpeed() {
		$total = 0;
		foreach (self::$speed as $item) $total += $item;
		return $total;
	}
}