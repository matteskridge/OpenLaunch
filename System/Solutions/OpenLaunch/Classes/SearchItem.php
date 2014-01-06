<?php

abstract class SearchItem {
	public abstract function getName();
	public abstract function getIcon();
	public abstract function getResults($query);
	public abstract function can();
}

class SearchResult {
	private $name, $link;

	public function __construct($name, $link) {
		$this->name = $name;
		$this->link = $link;
	}

	public function getName() {
		return $this->name;
	}

	public function getLink() {
		return $this->link;
	}
}