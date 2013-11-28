<?php

class ComposeControlItem extends ControlItem {

	public function canView() {
		return Permission::can("BlogPost");
	}

	public function getName() {
		return "Compose";
	}

	public function getContent($action, $id, $mode) {
		return new Redirect("/admin/index/structure/posts/0/");
	}

	public function getOrder() {
		return 500;
	}

}

