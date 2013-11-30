<?php

class ForumTopic extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"closed" => "boolean",
			"pinned" => "boolean",
			"hidden" => "boolean",
			"user" => "Person",
			"forum" => "Forum"
		);
	}

	public function getLink($page) {
		return $page->getLink("topic/".$this->getId()."/");
	}
}