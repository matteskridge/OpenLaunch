<?php

class LoginSession extends Model {
	public function getStructure() {
		return array(
			"user" => "Person",
			"cookie" => "string+",
			"sessionid" => "string",
			"browser" => "string",
			"platform" => "string",
			"ipaddress" => "string"
		);
	}
}