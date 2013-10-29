<?php

class CodeField extends InputField {
	public function getHtml() {
		return Component::get("CreationShare.CodeEditor");
	}

	public function getValue() {
		return "";
	}
}