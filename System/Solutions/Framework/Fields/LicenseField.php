<?php

class LicenseField extends SelectField {
	public function init() {
		$this->options = array(
			"reserved" => "All Rights Reserved",
			"" => "License is included in the Terms of Service (below)",
			"cca" => "Creative Commons Attribution",
			"ccad" => "Creative Commons Attribution No-Derivs",
			"ccas" => "Creative Commons Attribution Share-Alike",
			"ccan" => "Creative Commons Attribution Non-Commercial",
			"ccand" => "Creative Commons Attribution Non-Commercial No-Derivs",
			"ccasn" => "Creative Commons Attribution Share-Alike Non-Commercial",
			"public" => "Public Domain",
			"mit" => "MIT License",
			"bsd" => "BSD License",
			"apl" => "Apache License",
			"gpl" => "GNU Public License, version 3",
			"lgpl" => "Lesser GNU Public License"
		);
	}
}