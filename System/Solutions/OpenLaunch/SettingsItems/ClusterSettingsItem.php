<?php

class ClusterSettingsItem extends SettingsItem {
	public function getName() {
		return "Cluster";
	}

	public function getContent() {
		return Component::get("OpenLaunch.SettingsCluster");
	}

	public function getOrder() {
		return 800;
	}

	public function can() {
		return Permission::can("SettingsDeveloper");
	}
}