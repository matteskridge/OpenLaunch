<?php

class FeatureGalleryCategory extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"page" => "Page",
			"order" => "integer"
		);
	}
}