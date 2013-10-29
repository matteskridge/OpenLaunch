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
			return "<img src='/Images/IconFinder/Roles/Guest.png' />";
		} else if ($this->get("allemployees")) {
			return "<img src='/Images/IconFinder/Roles/Employee.png' />";
		} else if (in_array("EditSettingsPermission", $permissions)) {
			return "<img src='/Images/IconFinder/Roles/Administrator.png' />";
		} else if (in_array("ManageEmployeesPermission", $permissions)) {
			return "<img src='/Images/IconFinder/Roles/Manager.png' />";
		} else if (in_array("EditWebsitePermission", $permissions)) {
			return "<img src='/Images/IconFinder/Roles/Editor.png' />";
		} else if (in_array("ModeratorPermission", $permissions)) {
			return "<img src='/Images/IconFinder/Roles/Moderator.png' />";
		} else {
			return "<img src='/Images/IconFinder/Roles/Person.png' />";
		}
	}
}