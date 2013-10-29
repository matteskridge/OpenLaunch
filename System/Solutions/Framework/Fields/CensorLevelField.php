<?php

class CensorLevelField extends SelectField {
	public function init() {
		$this->options = array(
			"0" => "Do Not Censor",
			"1" => "Censor Lightly",
			"2" => "Censor Moderately",
			"3" => "Censor Strictly"
		);
	}
}

class UploadBlockField extends SelectField {
	public function init() {
		$this->options = array(
			"0" => "Allow",
			"1" => "Filter using a Blacklist",
			"1" => "Filter using a Whitelist",
			"2" => "Block"
		);
	}
}