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

			$form = new Form("create-page");
			$form->add(new TextField("name", "Name"));
			$form->controls($edit);
			$content = Component::get("OpenLaunch.StructurePage", array("page" => $edit, "form" => $form->getHtml()));
		}
		return Component::get("OpenLaunch.Structure", $content);
	}

	public function getName() {
		return "Structure";
	}

	public function getOrder() {
		return 100;
	}

}

