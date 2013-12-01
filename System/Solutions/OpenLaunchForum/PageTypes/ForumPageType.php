<?php

class ForumPageType extends PageType {

	public function getName() {
		return "Discussion Board";
	}

	public function getIcon() {
		return "/Images/Flat/IconFinder/Discussion.png";
	}

	public function render($page) {
		$action = Response::getArg(1);
		if ($action == "" || $action == "index") {
			return $this->index($page);
		} else if ($action == "forum") {
			return $this->forum($page, Response::getArg(2));
		} else if ($action == "topic") {
			return $this->topic($page, Response::getArg(2));
		} else if ($action == "create") {
			return $this->create($page, Response::getArg(2));
		} else if ($action == "moderate") {
			return $this->moderate($page, Response::getArg(2), Response::getArg(3), Response::getArg(4));
		}
	}

	private function index($page) {
		$categories = ForumCategory::findAll("ForumCategory", array("page" => $page), "`order`, `id`");
		return Component::get("OpenLaunchForum.Index", array(
			"page" => $page,
			"categories" => $categories
		));
	}

	private function forum($page, $id) {
		$forum = new Forum($id);
		if (!$forum->exists())
			return new NotFoundError();

		if (Permission::can("ForumHide")) {
			$find = array("forum" => $forum);
		} else {
			$find = array("forum" => $forum, "hidden" => "0");
		}

		$topics = ForumTopic::findAll("ForumTopic", $find, "`pinned` DESC, `cs_modified` DESC, `id` DESC");

		return Component::get("OpenLaunchForum.Forum", array(
			"page" => $page,
			"forum" => $forum,
			"topics" => $topics
		));
	}

	private function topic($page, $id) {
		$topic = new ForumTopic($id);
		if (!$topic->exists() || ($topic->get("hidden") && !Permission::can("ForumHide")))
			return new NotFoundError();

		$forum = $topic->get("forum");
		if (!$forum->exists())
			return new NotFoundError();

		return Component::get("OpenLaunchForum.Topic", array(
			"page" => $page,
			"forum" => $forum,
			"topic" => $topic
		));
	}

	private function create($page, $forum) {
		$forum = new Forum($forum);
		if (!$forum->exists())
			return new NotFoundError();

		$form = new Form("create");
		$form->add(new TextField("name", "Topic Name", ""));
		$form->add(new TextEditor("content", "Topic Content", ""));
		$form->add(new HiddenField("user", "User", Session::getPerson()));
		$form->add(new HiddenField("forum", "Forum", $forum));
		$form->controls("ForumTopic");

		if ($form->sent()) {
			Comment::post(new ForumTopic(mysql_insert_id()), array(
				"content" => $form->get("content"),
				"user" => $form->get("user")
			));
            return new Redirect($page->getLink("/"));
		}

		return Component::get("OpenLaunchForum.Create", array(
			"form" => $form->getHtml(),
			"forum" => $forum,
			"page" => $page
		));
	}

	public function renderAdmin($page) {
		if (isset($_GET["forum"])) {
			return $this->adminForum($page);
		} else if (isset($_GET["category"])) {
			return $this->adminCategory($page);
		} else {
			return Component::get("OpenLaunchForum.Admin", array("page" => $page));
		}
	}

	private function adminCategory($page) {
		$category = $_GET["category"];

		if ($category == "") {
			$controls = "ForumCategory";
		} else {
			$controls = new ForumCategory($category);
			if (!$controls->exists())
				return new NotFoundError();
		}

		$form = new Form("admin-category");
		$form->add(new TextField("name", "Category Name", ""));
		$form->add(new HiddenField("page", "Page", $page));
		$form->controls($controls);
		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId());
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}

	public function adminForum($page) {
		$forum = $_GET["forum"];

		if ($forum == "") {
			$controls = "Forum";
		} else {
			$controls = new Forum($forum);
			if (!$controls->exists())
				return new NotFoundError();
		}

		$form = new Form("admin-forum");
		$form->add(new TextField("name", "Forum Name", ""));
		$form->add(new TextField("description", "Forum Description", ""));
		if (isset($_GET["category"])) $form->add(new HiddenField("category", "Category", $_GET["category"]));
		$form->add(new RolesPermissionField("canview", "Who can View", ""));
		$form->add(new RolesPermissionField("canpost", "Who can Post", ""));
		$form->controls($controls);
		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId());
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}

	private function moderate($page, $topic, $action, $value) {
		$topic = new ForumTopic($topic);
		if (!$topic->exists())
			return new NotFoundError();

		if ($action == "close" && Permission::can("ForumClose")) {
			$topic->set("closed", $value);
		} else if ($action == "hide" && Permission::can("ForumHide")) {
			$topic->set("hidden", $value);
		} else if ($action == "pin" && Permission::can("ForumPin")) {
			$topic->set("pinned", $value);
		}

		return new Redirect($page->getLink("topic/".$topic->getId()."/"));
	}
}