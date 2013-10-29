<?php

class CountryField extends SelectField {
	public function init() {
		$data = new File("System/Data/countries.txt");
		$text = $data->read();

		$countries = explode("\n", $text);
		foreach ($countries as $country) {
			$bits = explode(":", $country);
			$code = $bits[0];
			$name = $bits[1];

			$this->options[$code] = $name;
		}

		$this->value = "US";
	}
}