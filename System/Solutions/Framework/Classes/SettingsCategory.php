<?php

class SettingsCategory {
	private $name;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $name;
	}
}