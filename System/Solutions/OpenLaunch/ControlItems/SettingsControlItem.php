<?php

class SettingsControlItem extends ControlItem {
	public function canView() {
		return true;
	}

	public function getName() {
		return "Settings";
	}

	public function getContent($action, $id, $mode) {
		
		$content = "";
		
		if ($action == "branding" || $action == "") {
			if ($id == "" || $id == "website") {
				$form = new Form("settings-branding");
				$form->add(new TextField("name", "Website Name", Settings::get("website.name")));
			} else if ($id == "organization") {
				$form = new Form("settings-branding");
				$form->add(new TextField("name", "Organization Name", Settings::get("website.organization")));
			}
			$content = Component::get("OpenLaunch.SettingsBranding", $form->getHtml());
		} else if ($action == "security") {
			$content = Component::get("OpenLaunch.SettingsSecurity");
		} else if ($action == "maintenance") {
			$content = Component::get("OpenLaunch.SettingsMaintenance");
		}
		
		return Component::get("OpenLaunch.Settings", $content);
	}

	public function getOrder() {
		return 500;
	}
}