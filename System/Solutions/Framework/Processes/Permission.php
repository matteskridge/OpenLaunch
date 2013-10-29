<?php

class Permission {
	private static $permissions = array();

	public function run($name) {
		if ($name == "platform.start.6") {
			$this->findPermissions();
		}
	}

	public function findPermissions() {
		self::$permissions = array();
		foreach (Platform::getSolutions("Permissions") as $solution) {
			foreach ($solution->getFile()->listSubs() as $sub) {
				$sub->import();
			}
		}

		if (Session::loggedIn()) {
			foreach (Session::getPerson()->getRoles() as $role) {
				foreach ($role->get("permissions") as $perm) {
					if (class_exists($perm)) {
						array_push(self::$permissions, $perm);
					}
				}
			}
		} else {
			foreach (Role::findAll("Role", array("allguests" => true)) as $role) {
				foreach ($role->get("permissions") as $perm) {
					if (class_exists($perm)) {
						array_push(self::$permissions, $perm);
					}
				}
			}
		}
	}

	public static function can($name) {
		if (Settings::get("security.demo")) return true;
		return in_array($name."Permission", self::$permissions);
	}

	public function getName() {
		$class = get_class($this);
		return $class;
	}

	public function meetsRequirements($person) { return true; }
}