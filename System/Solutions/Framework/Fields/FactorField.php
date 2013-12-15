<?php

class FactorField extends SelectField {
	public function init() {
		$arr = array();

		for ($i = 0; $i < 5; $i+=0.1) {
			$arr["$i"] = $i."x";
		}

		$this->options = $arr;
	}
}
