<?php

class DatabaseCategory extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"page" => "Page"
		);
	}
}