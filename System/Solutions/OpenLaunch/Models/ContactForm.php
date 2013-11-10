<?php

class ContactForm extends Model {

	public function getStructure() {
		return array(
			"page" => "Page",
			"askname" => "boolean",
			"askemail" => "boolean",
			"askphone" => "boolean",
			"askaddress" => "boolean",
			"askcomment" => "boolean"
		);
	}

}

