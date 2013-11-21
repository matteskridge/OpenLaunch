<?php

class BlogPageType extends PageType {

	public function getIcon() {
		return "/Images/Flat/IconFinder/Blog.png";
	}

	public function getName() {
		return "Blog / News";
	}

	public function render($page) {

		$categories = BlogCategory::findAll("BlogCategory", array("page" => $page));
		$find = array("page" => $page);

		if (Response::getArg(1) != "") {
			$find["category"] = new BlogCategory(Response::getArg(1));
			$feed = $page->getLink(Response::getArg(1) . "/feed.rss");
		} else {
			$feed = $page->getLink("/feed.rss");
		}



		if (Request::isRSS()) {
			return new AjaxResponse(BlogPost::getFeed("BlogPost", $find, "`id` DESC"));
		} else {
			$posts = BlogPost::findAll("BlogPost", $find, "`id` DESC");
			return Component::get("OpenLaunch.Blog", array("page" => $page, "categories" => $categories, "posts" => $posts, "feed" => $feed));
		}
	}

	public function renderAdmin($page) {
		$form = new Form("blog-category");
		$form->add(new TextField("name", "Category Name"));
		$form->add(new HiddenField("page", "Page", $page));
		$form->add(new HiddenField("edit", "Edit", $_GET["edit"]));
		if (!is_numeric($form->get("edit"))) {
			$form->controls("BlogCategory");
		} else {
			$form->controls(new BlogCategory($form->get("edit")));
		}

		if (isset($_GET["delete"])) {
			$delete = new BlogCategory($_GET["delete"]);
			$delete->delete();
		}

		if (!isset($_GET["create"]) && !isset($_GET["edit"]) && !$form->sent())
			$form = "";
		else
			$form = $form->getHtml();
		if ($form instanceof Form && $form->sent())
			return new Redirect("/admin/index/structure/page/" . $page->get("id") . "/");

		$categories = BlogCategory::findAll("BlogCategory");
		return Component::get("OpenLaunch.StructureBlogPage", array("page" => $page, "categories" => $categories, "form" => $form));
	}

}

