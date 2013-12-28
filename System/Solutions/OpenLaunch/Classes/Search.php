<?php

class Search {
	public static function query($query) {
		$items = array();
		$found = 0;

		foreach (Platform::getSolutionObjects("SearchItems") as $item) {
			if (!$item->can()) continue;
			$results = $item->getResults($query);
			$found += count($results);
			array_push($items, array($item, $results));
		}

		$html = "";
		foreach ($items as $category) {
			$content = "";
			foreach ($category[1] as $item) $content .= Component::get("OpenLaunch.SearchItem", array("item" => $item, "category" => $category[0]));
			$html .= Component::get("OpenLaunch.SearchCategory", array("content" => $content, "category" => $category[0]));
		}

		if ($found == 0) {
			return Component::get("OpenLaunch.SearchNoneFound");
		} else {
			return Component::get("OpenLaunch.SearchCategories", $html);
		}

	}
}