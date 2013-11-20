<?php

class RolesSettingsItem extends SettingsItem {
	public function getName() {
		return "Roles";
	}
	
	public function getOrder() {
		return 300;
	}
	
	public function getContent() {
		$roles = Role::findAll("Role");
		return Component::get("OpenLaunch.SettingsRoles", array("roles" => $roles));
	}
}