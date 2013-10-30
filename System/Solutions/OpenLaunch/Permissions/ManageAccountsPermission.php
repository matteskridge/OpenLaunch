<?php

class ManageAccountsPermission extends Permission {
	public function getCategory() { return "Manage"; }
	public function getName() { return "Edit User Accounts"; }
}