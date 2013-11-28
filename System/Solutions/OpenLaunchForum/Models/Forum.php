<?php

class Forum extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"description" => "string",
			"order" => "integer",
			"category" => "ForumCategory",
			"canpost" => "list",
			"canview" => "list"
		);
	}
}