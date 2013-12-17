<?php

class ForumCategory extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"order" => "integer",
			"page" => "Page"
		);
	}

	public function canView($person) {
		$forums = Forum::findAll("Forum", array("category" => $this));
		foreach ($forums as $forum) if ($forum->canView($person)) return true;
		return false;
	}
}
