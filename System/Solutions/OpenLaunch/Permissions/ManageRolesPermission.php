<?php

class ManageRolesPermission extends Permission {
	public function getCategory() { return "Manage"; }
	public function getName() { return "Assign Roles"; }
}