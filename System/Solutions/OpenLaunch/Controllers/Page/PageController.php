<?php

class PageController extends AppController {
	public function view($id) {
		$page = new Page($id);
		Page::setPage($page);
		
		if (!$page->exists()) return new NotFoundError();
		$this->page = $page;
		$this->html = $page->getHtml();

		if ($this->html instanceof Redirect) return $this->html;
		if ($this->html instanceof AjaxResponse) return "".$this->html;
	}
}