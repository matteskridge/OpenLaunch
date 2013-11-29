<?php

class WikiPageType extends PageType {
	public function getIcon() {
		return "/Images/Flat/IconFinder/Help.png";
	}

	public function getName() {
		return "Wiki / Knowledge Base";
	}

	public function render($page) {
		$action = Response::getArg(1);
		if ($action == "" || $action == "index") {
			return $this->index($page);
		} else if ($action == "article") {
			return $this->article($page, Response::getArg(2));
		}
	}

	private function index($page) {
		$categories = WikiCategory::findAll("WikiCategory", array("page" => $page));
		return Component::get("OpenLaunchWiki.Index", array(
			"page" => $page,
			"categories" => $categories
		));
	}

	private function article($page, $article) {
		$article = new WikiPage($article);
		if (!$article->exists())
			return new NotFoundError();

		return Component::get("OpenLaunchWiki.Article", array(
			"page" => $page,
			"article" => $article
		));
	}

	public function renderAdmin($page) {
		if (isset($_GET["page"])) {
			return $this->adminPage($page);
		} else if (isset($_GET["category"])) {
			return $this->adminCategory($page);
		} else if (isset($_GET["mainpage"])) {
			return $this->adminMainPage($page);
		} else {
			return $this->adminIndex($page);
		}
	}

	private function adminIndex($page) {
		return Component::get("OpenLaunchWiki.Admin", array(
			"page" => $page
		));
	}

	private function adminPage($page) {
		$sub = $_GET["page"];
		if ($sub == "") {
			$controls = "WikiPage";
		} else {
			$controls = new WikiPage($_GET["page"]);
			if (!$controls->exists())
				return new NotFoundError();
		}

		$form = new Form("page");
		$form->add(new TextField("name", "Article Name", ""));
		$form->add(new TextEditor("content", "Article Content", ""));
		$form->add(new HiddenField("category", "Category", $_GET["category"]));
		$form->controls($controls);
		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId()."/");
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}

	private function adminCategory($page) {
		$category = $_GET["category"];
		if ($category == "") {
			$controls = "WikiCategory";
		} else {
			$controls = new WikiCategory($_GET["category"]);
			if (!$controls->exists())
				return new NotFoundError();
		}

		$form = new Form("category");
		$form->add(new TextField("name", "Category Name", ""));
		$form->add(new HiddenField("page", "Page", $page));
		$form->controls($controls);
		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId()."/");
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}

	private function adminMainPage($page) {
		$form = new Form("mainpage");
		$form->add(new TextEditor("html", "HTML", ""));
		$form->controls($page);
		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId()."/");
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}
}