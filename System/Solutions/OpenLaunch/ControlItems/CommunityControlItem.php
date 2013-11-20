<?php

class CommunityControlItem extends ControlItem {

	public function canView() {
		if (true)
			return true;
		return Permission::can("EditWebsite");
	}

	public function getContent($action, $id, $mode) {
		if ($action == "index" || $action == "") {
			$content = Component::get("OpenLaunch.People");
		} else if ($action == "person") {
			$person = new Person($id);
			if (!$person->exists())
				return new NotFoundError();
			$content = Component::get("OpenLaunch.Person", array("person" => $person));
		} else if ($action == "communications") {
			$communications = Communication::findAll("Communication", array(), "`id` DESC");
			$content = Component::get("OpenLaunch.Communications", array("communications" => $communications));
		}
		return Component::get("OpenLaunch.Community", $content);
	}

	public function getName() {
		return "Community";
	}

	public function getMenu() {
		return array(
			"index" => "People",
			"communications" => "Communications",
			"comments" => "Comments",
			"statistics" => "Statistics",
			"admins" => "Administrators"
		);
	}

	public function getOrder() {
		return 200;
	}

}
