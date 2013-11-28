<?php

class BlogPost extends Model {

	public function getStructure() {
		return array(
			"name" => "string",
			"content" => "string+",
			"user" => "Person",
			"category" => "BlogCategory",
			"published" => "boolean",
			"page" => "Page"
		);
	}

}

