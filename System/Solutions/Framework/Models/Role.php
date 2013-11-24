<?php

class Role extends Model {

	public function getStructure() {
		return array(
			"name" => "string",
			"permissions" => "list",
			"category" => "string",
			"allmembers" => "boolean",
			"allguests" => "boolean",
			"allemployees" => "boolean",
			"icon" => "string",
			"importance" => "integer"
		);
	}

	public function getIcon() {
		$permissions = $this->get("permissions");
		if ($this->get("icon") != "") {
			return $this->get("icon");
		} else if ($this->get("allguests")) {
			return "<img src='/Images/Roles/IconFinder/Guest.png' />";
		} else if (in_array("SettingsBrandingPermission", $permissions)) {
			return "<img src='/Images/Roles/IconFinder/Admin.png' />";
		} else if (in_array("ManageEmployeesPermission", $permissions)) {
			return "<img src='/Images/Roles/IconFinder/Manager.png' />";
		} else if (in_array("EditWebsitePermission", $permissions)) {
			return "<img src='/Images/Roles/IconFinder/Editor.png' />";
		} else if (in_array("CommunityModeratePermission", $permissions)) {
			return "<img src='/Images/Roles/IconFinder/Moderator.png' />";
		} else {
			return "<img src='/Images/Roles/IconFinder/Person.png' />";
		}
	}

}

