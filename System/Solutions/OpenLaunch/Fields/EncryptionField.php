<?php

class EncryptionField extends SelectField {
	public function init() {
		$this->options = array(
			"no" => "Do not use Encryption"
		);
	}
}