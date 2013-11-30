<?php

class CommunityControlItem extends ControlItem {

	public function canView() {
		return $this->getMenu() != array();
	}

	public function getContent($action, $id, $mode) {

		if (!$this->inMenu($action) && $action != "person")
			return;

		if ($action == "index" || $action == "") {
			$content = Component::get("OpenLaunch.People");
		} else if ($action == "person") {
			$person = new Person($id);
			if (!$person->exists())
				return new NotFoundError();

			if (isset($_GET["role"]) && isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
				$role = new Role($_GET["role"]);
				if ($role->exists()) {
					$person->addRole($role);
				}
				return new Redirect("/" . Request::getUrl());
			} else if (isset($_GET["unrole"]) && isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
				$role = new Role($_GET["unrole"]);
				if ($role->exists()) {
					$person->removeRole($role);
				}
				return new Redirect("/" . Request::getUrl());
			}

			$roles = Role::findAll("Role", array("allguests" => "0"));
			$content = Component::get("OpenLaunch.Person", array("person" => $person, "roles" => $roles));
		} else if ($action == "communications") {
			$communications = Communication::findAll("Communication", array(), "`id` DESC");
			$content = Component::get("OpenLaunch.Communications", array("communications" => $communications));
		} else if ($action == "statistics") {
            $content = Component::get("OpenLaunch.Statistics");
        } else if ($action == "comments") {
            $content = Component::get("OpenLaunch.CommunityComments");
        } else if ($action == "admins") {
            $content = Component::get("OpenLaunch.CommunityAdmins");
        }
		return Component::get("OpenLaunch.Community", $content);
	}

	public function getName() {
		return "Community";
	}

	public function getMenu() {
		$arr = array();
		if (Permission::can("CommunityAccount"))
			$arr["index"] = "People";
		if (Permission::can("CommunityCommunications"))
			$arr["communications"] = "Communications";
		if (Permission::can("CommunityComments"))
			$arr["comments"] = "Comments";
		if (Permission::can("CommunityStatistics"))
			$arr["statistics"] = "Statistics";
		if (Permission::can("CommunityAssignRoles"))
			$arr["admins"] = "Administrators";
		return $arr;
	}

	public function getOrder() {
		return 200;
	}

}
