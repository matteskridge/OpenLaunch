<?php

class WikiCategory extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"order" => "integer",
			"page" => "Page"
		);
	}
}