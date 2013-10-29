<?php

class ArrayList {
	private $items;

	public function __construct() {
		$this->items = array();
		foreach (func_get_args() as $arg) {
			$this->add($arg);
		}
	}

	public function add() {
		foreach (func_get_args() as $arg) {
			array_push($this->items, $arg);
		}
	}

	public function get($name) {
		return $this->items[$name];
	}

	public function set($name, $value) {
		$this->items[$name] = $value;
	}

	public function each() {
		return $this->items;
	}
}