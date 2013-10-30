<?php

class WebsiteTypeField extends SelectField {
	public function init() {
		$this->options = array();
		
		foreach (WebsiteProcess::getTypes() as $type) {
			$this->options[$type->getId()] = $type->getName();
		}
	}
}

class FormField extends SelectField {
	public function init() {
		$this->options = array(
			"" => "Everything",
			"desktop" => "Desktop",
			"mobile" => "Mobile Phone"
		);
	}
}