<?php

class SuffixField extends SelectField {
	public function init() {
		$this->options = array(
			"" => "",
			"Jr." => "Jr.",
			"Sr." => "Sr.",
			"I" => "I",
			"II" => "II",
			"III" => "III",
			"VI" => "VI",
			"V" => "V",
			"Ph.D" => "Ph.D",
			"M.D." => "M.D.",
			"CPA" => "CPA",
		);
	}
}