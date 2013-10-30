<?php

class PageLayoutField extends SelectField {
	public function init() {
		$this->options = array("" => "Default");
		foreach (Template::listTemplates() as $template) {
			$this->options[$template->getParent()->getParent()->getName().".".$template->getExtensionlessName()] = $template->getExtensionlessName();
		}
	}
}