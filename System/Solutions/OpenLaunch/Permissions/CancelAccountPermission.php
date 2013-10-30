<?php

class CancelAccountPermission extends Permission {
	public function getCategory() { return "Account"; }
	public function getName() { return "Cancel Own Account"; }
}