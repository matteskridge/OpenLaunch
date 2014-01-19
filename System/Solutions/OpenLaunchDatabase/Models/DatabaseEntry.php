<?php

class DatabaseEntry extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"phone" => "string",
			"address" => "string",
			"link" => "string",
			"category" => "DatabaseCategory",
			"content" => "string+",
			"featured" => "boolean",
			"trusted" => "boolean",
			"hidden" => "boolean",
			"views" => "int"
		);
	}
}