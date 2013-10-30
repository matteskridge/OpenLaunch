<?php

class ChangePasswordPermission extends Permission {
	public function getCategory() { return "Account"; }
	public function getName() { return "Change Own Password"; }
}