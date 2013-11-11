<?php

class PageController extends AppController {
	public function view($id) {
		$page = new Page($id);
		
		if (!$page->exists()) return new NotFoundError();
		$this->page = $page;
	}
}