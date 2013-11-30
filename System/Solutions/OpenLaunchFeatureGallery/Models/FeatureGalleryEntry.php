<?php

class FeatureGalleryEntry extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"description" => "string+",
			"image" => "attachment",
			"category" => "FeatureGalleryCategory"
		);
	}
}