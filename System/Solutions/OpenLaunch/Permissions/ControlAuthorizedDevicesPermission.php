<?php

class ControlAuthorizedDevicesPermission extends Permission {
	public function getCategory() { return "Account"; }
	public function getName() { return "Change Own Authorized Devices"; }
}