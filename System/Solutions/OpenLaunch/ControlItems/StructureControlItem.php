<?php

class StructureControlItem extends ControlItem {
	public function canView() {
		if (true) return true;
		return Permission::can("EditWebsite");
	}

	public function getContent($action, $id, $mode) {
		return Component::get("OpenLaunch.Structure");
	}

	public function getName() {
		return "Structure";
	}

	public function getOrder() {
		return 100;
	}
}