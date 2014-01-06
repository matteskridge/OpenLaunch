<?php

class ForumTopic extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"closed" => "boolean",
			"pinned" => "boolean",
			"hidden" => "boolean",
			"user" => "Person",
			"forum" => "Forum",
			"public" => "boolean"
		);
	}

	public function getLink($page) {
		return $page->getLink("topic/".$this->getId()."/");
	}

	public static function listViewable($page) {
		return ForumTopic::findAll("ForumTopic", array(
			"public" => "1"
		), "`cs_created` DESC", 1, 20);
	}
}