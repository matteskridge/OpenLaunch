<?php

class WikiPage extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"order" => "integer",
			"category" => "WikiCategory",
			"content" => "string+"
		);
	}
}