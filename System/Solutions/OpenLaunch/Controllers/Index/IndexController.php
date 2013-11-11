<?php

class IndexController extends AppController {
	public function index() {
		$page = Page::find("Page", array("home" => "1"));
		
		if (!$page->exists()) return new NotFoundError();
		$this->page = $page;
	}
}