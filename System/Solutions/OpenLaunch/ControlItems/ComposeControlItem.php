<?php

class ComposeControlItem extends ControlItem {
	public function canView() {
		return true;
	}

	public function getName() {
		return "Compose";
	}

	public function getContent($action, $id, $mode) {
		return new Redirect("/admin/index/structure/posts/0/");
		//return Component::get("OpenLaunch.Compose");
	}

	public function getOrder() {
		return 500;
	}
}