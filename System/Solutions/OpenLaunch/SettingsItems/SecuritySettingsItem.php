<?php

class SecuritySettingsItem extends SettingsItem {

	public function getName() {
		return "Security";
	}

	public function getOrder() {
		return 200;
	}

	public function getContent() {

	}

	public function can() {
		return Permission::can("SettingsSecurity");
	}

}

