<?php

class SearchController extends AppController {
	public function index() {
		return Component::get("OpenLaunch.Search");
	}

	public function api() {
		return Search::query($_GET["query"]);
	}
}