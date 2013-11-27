<?php

class SecuritySettingsItem extends SettingsItem {

	public function getName() {
		return "Security";
	}

	public function getOrder() {
		return 200;
	}

	public function getContent() {
        $form = new Form("security");
        $form->controls(new SettingsCategory("security"));

        if ($form->sent()) {
            return new Redirect("/admin/index/settings/branding/");
        }

        return $form->getHtml();
	}

	public function can() {
		return Permission::can("SettingsSecurity");
	}

}

