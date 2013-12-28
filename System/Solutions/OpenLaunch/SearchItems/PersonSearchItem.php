<?php

class PersonSearchItem extends SearchItem {
	public function getName() {
		return "People";
	}

	public function getIcon() {
		return "";
	}

	public function getResults($query) {
		$items = array();

		$people = Person::search("Person", $query);
		foreach ($people as $person) {
			$item = new SearchResult($person->get("nickname"), "");
			array_push($items, $item);
		}

		return $items;
	}

	public function can() {
		return Permission::can("CommunityAccount");
	}
}