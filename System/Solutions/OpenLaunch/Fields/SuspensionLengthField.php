<?php

class SuspensionLengthField extends SelectField {
	public function init() {
		if ($this->value == "") $this->value = "3";
		$this->options = array(
			"1" => "One Day",
			"3" => "Three Days",
			"7" => "One Week",
			"14" => "Two Weeks",
			"30" => "One Month",
			"90" => "Three Months",
			"180" => "Six Months",
			"365" => "One Year",
			"1095" => "Three Years",
			"365" => "Ten Years"
		);
	}
}