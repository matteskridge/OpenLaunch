<?php

class PluginsSettingsItem extends SettingsItem {

	public function getName() {
		return "Plugins";
	}

	public function getContent() {
		$solutions = Platform::getApplications();
		return Component::get("OpenLaunch.SettingsSolutions", array("solutions" => $solutions));
	}

	public function getOrder() {
		return 500;
	}

}

