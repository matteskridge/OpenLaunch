<?php

class PrefixField extends SelectField {
	public function init() {
		$this->options = array(
			"" => "",
			"Mr." => "Mr.",
			"Mrs." => "Mrs.",
			"Ms." => "Ms.",
			"Dr." => "Dr.",
			"Rev." => "Rev.",
			"Fr." => "Fr.",
			"Prof." => "Prof."
		);
	}
}