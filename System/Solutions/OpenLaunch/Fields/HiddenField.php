<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class HiddenField extends InputField {
    public function getHtml() {
        return "";
    }

    public function getValue() {
        return $this->value;
    }

	public function isValid($data, $requirement) {
		return true;
	}
}