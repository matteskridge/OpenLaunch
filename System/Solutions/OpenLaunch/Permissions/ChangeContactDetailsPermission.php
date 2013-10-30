<?php

class ChangeContactDetailsPermission extends Permission {
	public function getCategory() { return "Account"; }
	public function getName() { return "Change Own Contact Details"; }
}