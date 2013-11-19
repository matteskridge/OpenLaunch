<?php

class CensorSettingsItem extends SettingsItem {
	public function getName() {
		return "Censorship";
	}
	
	public function getOrder() {
		return 400;
	}
	
	public function getContent() {
		$options = array("No Age Requirement");
		for ($i = 6; $i <= 40; $i++) {
			$options[$i] = $i." and older";
		}
		
		$form = new Form("settings-censor");
		$form->add(new SelectField("age", "Minimum Age", 0, $options));
		$form->add(new TextField("disclaimer", "Content Disclaimer"));
		return $form->getHtml();
	}
}
