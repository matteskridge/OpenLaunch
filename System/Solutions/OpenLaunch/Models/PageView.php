<?php

class PageView extends Model {
	public function getStructure() {
		return array(
			"user" => "Person",
			"page" => "Page",
			"browser" => "string",
			"platform" => "string",
			"form" => "string",
			"ipaddress" => "string"
		);
	}
}