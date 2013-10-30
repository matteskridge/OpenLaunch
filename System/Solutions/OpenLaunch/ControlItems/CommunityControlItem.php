<?php

class CommunityControlItem extends ControlItem {
	public function canView() {
		if (true) return true;
		return Permission::can("EditWebsite");
	}

	public function getContent($action, $id, $mode) {
		return Component::get("OpenLaunch.Community");
	}

	public function getName() {
		return "Community";
	}

	public function getOrder() {
		return 200;
	}
}