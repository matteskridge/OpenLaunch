<?php

class BrandingSettingsItem extends SettingsItem {

	public function getName() {
		return "Branding";
	}

	public function getOrder() {
		return 100;
	}

	public function getContent() {
		$form = new Form("website");
		$form->add(new TextField("name", "Website Name"));
		$form->add(new TextField("description", "Website Description"));
		$form->add(new TextField("organization", "Organization Name"));
		$form->add(new AttachmentField("logo", "Website Logo"));
		$form->add(new FactorField("scale", "Logo Size", "1"));
		$form->add(new MarginField("logoTop", "Margin Top", "0"));
		$form->add(new MarginField("logoBottom", "Margin Bottom", "0"));
		//$form->add(new TextField("link", "Install Directory"));
		$form->controls(new SettingsCategory("website"));

		if ($form->sent()) {
			return new Redirect("/admin/index/settings/branding/");
		}

		return $form->getHtml();
	}

	public function can() {
		return Permission::can("SettingsBranding");
	}

}

