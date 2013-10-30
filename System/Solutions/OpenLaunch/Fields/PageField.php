<?php

class PageField extends SelectField {
	private $arr;
	
	public function init() {
		$this->getPages();
		$this->options = $this->arr;
	}
	
	private function getPages($parent = 0, $depth = 0) {
		if ($parent == 0) $this->arr = array();
		
		$indent = "";
		for ($i = 0; $i < $depth; $i++) {
			$indent .= "--";
		}
		$indent .= " ";
		
		$pages = Page::findAll("Page", array("parent" => $parent), "`order` ASC");
		foreach ($pages as $p) {
			$this->arr[$p->get("id")] = $indent.$p->get("name");
			$this->getPages($p->get("id"), $depth+1);
		}
	}
	
	public function getValue() {
		return new Page(parent::getValue());
	}
}

class PageOrNoneField extends PageField {
	public function init() {
		parent::init();
		$this->options[0] = "Not a Sub-Page";
	}
}