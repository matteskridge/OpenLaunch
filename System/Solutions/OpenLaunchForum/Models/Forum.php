<?php

class Forum extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"description" => "string",
			"order" => "integer",
			"category" => "ForumCategory",
			"canpost" => "list",
			"canview" => "list"
		);
	}

	public function canView($person = null) {
		return $this->can($person, "canview");
	}

	public function canPost($person = null) {
		return $this->can($person, "canpost");
	}

	public function isPublic() {
		return $this->get("canview") == array();
	}

	public function can($person, $mode) {
		if ($person == null) {
			if (Session::loggedIn()) {
				$person = Session::getPerson();
			} else {
				return $this->get($mode) == array() || $this->get($mode) == "";
			}
		}

		$view = $this->get($mode);
		if ($view == array()) return true;

		foreach ($person->getRoles() as $role) {
			foreach ($view as $item) {
				if ($item == $role->getId()) {
					return true;
				}
			}
		}

		return false;
	}
}