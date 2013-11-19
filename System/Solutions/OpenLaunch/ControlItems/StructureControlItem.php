<?php

class StructureControlItem extends ControlItem {

	public function canView() {
		if (true)
			return true;
		return Permission::can("EditWebsite");
	}

	public function getContent($action, $id, $mode) {
		if ($action == "index" || $action == "") {
			$content = Component::get("OpenLaunch.StructurePages", array(
						"action" => $action,
						"id" => $id,
						"mode" => $mode
			));
		} else if ($action == "page") {
			if ($id == 0) {
				$edit = "Page";
			} else {
				$edit = new Page($id);
			}

			if ($mode != "" && $edit instanceof Page) {
				$edit->set("template", $mode);
				return new Redirect("/admin/index/structure/page/" . $edit->get("id") . "/");
			}

			$form = new Form("create-page");
			$form->add(new TextField("name", "Page Name"));
			if ($mode != "")
				$form->add(new HiddenField("parent", "Parent", new Page($mode)));
			$form->controls($edit);

			$content = Component::get("OpenLaunch.StructurePage", array("page" => $edit, "form" => $form->getHtml()));

			if ($form->sent() && $form->get("home")) {
				mysql_query("UPDATE `Page` SET `home`='0' WHERE `id`!='" . Security::prepareForDatabase($id) . "'");
			} else if ($form->sent()) {
				$id = ($edit instanceof Page) ? $edit->get("id") : mysql_insert_id();
				return new Redirect("/admin/index/structure/page/" . $id . "/");
			}
		}

		return Component::get("OpenLaunch.Structure", array(
					"content" => $content,
					"action" => $action,
					"id" => $id,
					"mode" => $mode));
	}

	public function getName() {
		return "Builder";
	}

	public function getMenu() {
		return array(
			"index" => "Web Pages",
			"posts" => "Blog Posts",
			"design" => "Website Design"
		);
	}

	public function getOrder() {
		return 100;
	}

}

