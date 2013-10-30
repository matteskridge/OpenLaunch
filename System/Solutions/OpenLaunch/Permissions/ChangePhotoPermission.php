<?php

class ChangePhotoPermission extends Permission {
	public function getCategory() { return "Account"; }
	public function getName() { return "Change Own Photo"; }
}