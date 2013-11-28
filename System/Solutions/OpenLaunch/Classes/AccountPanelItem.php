<?php

class AccountPanelItem {
	public function getId() {
		$class = get_class($this);
		return strtolower(str_replace("AccountPanelItem", "", $class));
	}

	public function getName() {
		return "";
	}

	public function getMenu() {

	}

	public function getIcon() {
		return "";
	}

	public function getContent($action, $args) {

	}
}