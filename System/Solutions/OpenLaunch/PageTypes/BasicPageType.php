<?php

class BasicPageType extends PageType {

	public function getIcon() {
		return "/Images/Flat/IconFinder/Page.png";
	}

	public function getName() {
		return "Basic Page";
	}

	public function render($page) {
		return html_entity_decode($page->get("html"));
	}

	public function renderAdmin($page) {
		$id = "basic-page-editor";

		if (isset($_POST[$id])) {
			$page->set("html", Parser::parse($_POST[$id]));
			return new Redirect("/admin/index/structure/");
		}

		return Component::get("OpenLaunch.StructureBasicPage", array("page" => $page, "id" => $id));
	}

}

