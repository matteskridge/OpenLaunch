<?php

class HashField extends SelectField {
	public function init() {
		$this->options = array(
			"pbkdf2" => "Password-Based Key Derivation Function v2 - 1,000 Iteration SHA256"
		);
	}
}