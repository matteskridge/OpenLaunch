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
			$content = $this->person($action, $id, $mode);
		} else if ($action == "communications") {
			$communications = Communication::findAll("Communication", array(), "`id` DESC");
			$content = Component::get("OpenLaunch.Communications", array("communications" => $communications));
		} else if ($action == "statistics") {
            $content = Component::get("OpenLaunch.Statistics");
        } else if ($action == "comments") {
            $content = $this->comments();
        } else if ($action == "admins") {
            $content = Component::get("OpenLaunch.CommunityAdmins");
        }

        if ($content instanceof Redirect || $content instanceof NotFoundError) {
            return $content;
        }
		return Component::get("OpenLaunch.Community", $content);
	}

	private function person($action, $id, $mode) {
		$person = new Person($id);
		if (!$person->exists())
			return new NotFoundError();

		$controls = Session::getPerson()->canControl($person);

		if (isset($_GET["role"]) && isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
			$role = new Role($_GET["role"]);
			if ($role->exists() && Permission::can("CommunityAssignRoles") && $controls) {
				$person->addRole($role);
			}
			return new Redirect("/" . Request::getUrl());
		} else if (isset($_GET["unrole"]) && isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
			$role = new Role($_GET["unrole"]);
			if ($role->exists() && Permission::can("CommunityAssignRoles") && $controls) {
				$person->removeRole($role);
			}
			return new Redirect("/" . Request::getUrl());
		} else if (isset($_GET["deprofile"]) && isset($_GET["sid"]) && $_GET["sid"] == session_id()) {
			if (Permission::can("RemoveProfile") && $controls) {
				$person->set("profile", "");
			}
			return new Redirect("/" . Request::getUrl());
		}

		$suspend = new Form("suspend");
		$suspend->add(new SuspensionLengthField("length", "Length"));
		$suspend->add(new TextEditor("reason", "Reason"));
		$suspend->add(new HiddenField("user", $person));
		if (Permission::can("CommunitySuspend")) $suspend->controls("Penalty");

		$warn = new Form("warning");
		$warn->add(new TextEditor("reason", "Reason"));
		$warn->add(new HiddenField("user", $person));
		$warn->add(new HiddenField("warning", "Warning", 1));
		if (Permission::can("CommunityWarn")) $warn->controls("Penalty");

		$edit = new Form("edit");
		$edit->add(new TextField("nickname", "Display Name"));
		$edit->add(new TextField("email", "Email Address"));
		$edit->add(new TextField("street", "Street Address"));
		$edit->add(new TextField("suite", "Suite"));
		$edit->add(new TextField("city", "City"));
		$edit->add(new TextField("province", "State / Province"));
		$edit->add(new TextField("country", "Country"));
		$edit->add(new TextField("phone", "Phone #"));
		if (Permission::can("CommunityEditAccount")) $edit->controls($person);

		$ban = new Form("ban");
		$ban->add(new CheckboxField("ban", "Banned"));
		if (Permission::can("CommunityBan")) $ban->controls($person);

		if ($edit->sent() || $ban->sent()) {
			return new Redirect("/admin/index/community/person/".$person->getId());
		}

		$roles = Role::findAll("Role", array("allguests" => "0"));
		return Component::get("OpenLaunch.Person", array(
			"person" => $person,
			"roles" => $roles,
			"suspend" => $suspend->getHtml(),
			"warn" => $warn->getHtml(),
			"edit" => $edit->getHtml(),
			"ban" => $ban->getHtml(),
			"controls" => $controls,
			"me" => Session::getPerson()->getId() == $person->getId()
		));
	}

    private function comments() {
        if (Response::getArg(2) == "hide" && session_id() == $_GET["sid"]) {
            $comment = new Comment(Response::getArg(3));
            if ($comment->exists()) {
                $comment->set("hidden", 1);
            }
            return new Redirect(Request::getReferer());
        } else if (Response::getArg(2) == "unhide" && session_id() == $_GET["sid"]) {
            $comment = new Comment(Response::getArg(3));
            if ($comment->exists()) {
                $comment->set("hidden", 0);
            }
            return new Redirect(Request::getReferer());
        }
        return Component::get("OpenLaunch.CommunityComments");
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
