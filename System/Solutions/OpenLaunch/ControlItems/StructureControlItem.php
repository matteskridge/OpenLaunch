<?php

class StructureControlItem extends ControlItem {

	public function canView() {
		return $this->getMenu() != array();
	}

	public function getContent($action, $id, $mode) {

		if (!$this->inMenu($action) && $action != "page" && $action != "layout")
			return;

		if ($action == "index" || $action == "") {
			$content = $this->index($action, $id, $mode);
		} else if ($action == "page" && Permission::can("EditWebsite")) {
			$content = $this->page($action, $id, $mode);
		} else if ($action == "design") {
			$content = $this->design($action, $id, $mode);
		} else if ($action == "posts") {
			$content = $this->posts($action, $id, $mode);
		} else if ($action == "layout") {
			$content = $this->layout($action, $id, $mode);
		}

		if ($content instanceof Redirect)
			return $content;
		else
			return Component::get("OpenLaunch.Structure", array(
						"content" => $content,
						"action" => $action,
						"id" => $id,
						"mode" => $mode));
	}

	private function index($action, $id, $mode) {
		if ($mode == "delete" && $_GET["sid"] == session_id()) {
			$page = new Page($id);
			if ($page->exists()) {
				$page->delete();
			}
		} else if ($mode == "reorder") {
			$arr = explode(",", $_GET["order"]);
			for ($i = 0; $i < count($arr); $i++) {
				$page = new Page($arr[$i]);
				$page->set("order", $i);
			}
		} else if ($mode == "home") {
			$page = new Page($id);
			Database::query("UPDATE `Page` SET `home`='0'");
			if ($page->exists()) {
				$page->set("home", "1");
			}

		} else if ($id == "select") {
			return Component::get("OpenLaunch.StructurePageType");
		} else if ($id == "create") {
			Page::create("Page", array(
				"template" => $mode,
				"name" => $_GET["name"],
				"parent" => "0"
			));
			return new Redirect("/admin/index/structure/page/".mysql_insert_id()."/");
		}

		return Component::get("OpenLaunch.StructurePages", array(
					"action" => $action,
					"id" => $id,
					"mode" => $mode
		));
	}

	private function page($action, $id, $mode) {
		if ($id == 0) {
			$edit = "Page";
			$admin = "";
		} else {
			$edit = new Page($id);
			if ($edit->getType() instanceof PageType)
				$admin = $edit->getType()->renderAdmin($edit);
		}

		if ($mode != "" && $edit instanceof Page) {
			$edit->set("template", $mode);
			return new Redirect("/admin/index/structure/page/" . $edit->get("id") . "/");
		}

		$form = new Form("create-page");
		$form->add(new TextField("name", "Page Name"));
		$form->add(new BannerField("banner", "Banner"));
		if ($mode != "")
			$form->add(new HiddenField("parent", "Parent", new Page($mode)));
		$form->controls($edit);

		if ($form->sent() && $form->get("home")) {
			mysql_query("UPDATE `Page` SET `home`='0' WHERE `id`!='" . Security::prepareForDatabase($id) . "'");
			return new Redirect("/admin/index/structure/page/" . $id . "/");
		} else if ($form->sent()) {
			$id = ($edit instanceof Page) ? $edit->get("id") : mysql_insert_id();
			return new Redirect("/admin/index/structure/page/" . $id . "/");
		} else if ($admin instanceof Redirect) {
			return $admin;
		}

		return Component::get("OpenLaunch.StructurePage", array("page" => $edit, "form" => $form->getHtml(), "admin" => $admin));
	}

	private function design($action, $id, $mode) {
		if ($id != "") {
			Settings::set("website.theme", $id);
			ThemeProcess::resetStyleCache($id);
		}

		return Component::get("OpenLaunch.StructureDesign");
	}

	private function posts($action, $id, $mode) {
		$content = "";

		if ($id != "") {
			if ($id == 0) {
				$content = Component::get("OpenLaunch.StructurePostCompose");
			} else {
				if ($mode == "delete" && session_id() == $_GET["sid"]) {
					$post = new BlogPost($id);
					$post->delete();
					return new Redirect("/admin/index/structure/posts/");
				}
				$content = Component::get("OpenLaunch.StructurePostCompose", array("post" => new BlogPost($id)));
			}

			if (isset($_POST["blogpost-name"]) && isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
				$name = $_POST["blogpost-name"];
				$bits = explode(",", $_POST["blogpost-category"]);
				$page = $bits[0];
				$category = $bits[1];
				$text = $_POST["blogpost-text"];

				$data = array(
					"name" => $name,
					"page" => new Page($page),
					"category" => $category,
					"user" => Session::getPerson(),
					"published" => true,
					"content" => $text
				);

				if ($id == "0") {
					BlogPost::create("BlogPost", $data);
				} else {
					$post = new BlogPost($id);
					if ($post->exists()) {
						$post->set($data);
					}
				}

				return new Redirect("/admin/index/structure/posts/");
			}
		} else {
			$content = Component::get("OpenLaunch.StructureBlogPosts");
		}

		return Component::get("OpenLaunch.StructurePosts", array(
					"content" => $content,
					"id" => $id
		));
	}


	private function layout($action, $id, $mode) {
		$page = new Page($id);

		$form = "";

		if ($mode == "banner") {
			$form = new Form("banner");
			$form = $form->getHtml();
		}

		return Component::get("OpenLaunch.StructureLayout", array(
			"page" => $page,
			"form" => $form
		));
	}

	public function getName() {
		return "Content";
	}

	public function getMenu() {
		$arr = array();
		if (Permission::can("EditWebsite"))
			$arr["index"] = "Web Pages";
		if (Permission::can("BlogPost"))
			$arr["posts"] = "Blog Posts";
		if (Permission::can("DesignWebsite"))
			$arr["design"] = "Website Design";
		return $arr;
	}

	public function getOrder() {
		return 100;
	}

}
