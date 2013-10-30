<?php

class SettingsControlItem extends ControlItem {
	public function canView() {
		return true;
	}

	public function getName() {
		return "Settings";
	}

	public function getContent($action, $id, $mode) {
		return Component::get("OpenLaunch.Settings");
	}

	public function getOrder() {
		return 500;
	}
}