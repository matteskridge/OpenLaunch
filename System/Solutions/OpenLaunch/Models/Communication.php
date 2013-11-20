<?php

class Communication extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"email" => "string",
			"phone" => "string",
			"content" => "string+",
			"user" => "Person"
		);
	}
}