<?php

class UpdateSettingsItem extends SettingsItem {

	public function getName() {
		return "Update";
	}

	public function getOrder() {
		return 600;
	}

	public function getContent() {
		if (isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
			unlink(".htaccess");
			return Component::get("OpenLaunch.SettingsUpdateWaiting");
		}
		return Component::get("OpenLaunch.SettingsUpdate");
	}

	public function can() {
		return Permission::can("SettingsUpdate");
	}

}

