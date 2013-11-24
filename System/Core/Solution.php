<?php

class Solution {

	private $file;

	public function __construct($file) {
		$this->file = $file;
	}

	public function getFile() {
		return $this->file;
	}

	public function getName() {
		return $this->file->getName();
	}

}

