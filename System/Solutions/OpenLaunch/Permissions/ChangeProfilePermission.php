<?php

class ChangeProfilePermission extends Permission {
	public function getCategory() { return "Account"; }
	public function getName() { return "Change Own Profile"; }
}