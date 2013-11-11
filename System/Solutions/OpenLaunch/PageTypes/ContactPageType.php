<?php

class ContactPageType extends PageType {
	public function getIcon() {
		return "/Images/Flat/IconFinder/Email.png";
	}

	public function getName() {
		return "Contact Form";
	}

	public function render($page) {
		$form = new Form("contact");
		$form->add(new TextField("name", "Your Name"));
		$form->add(new TextField("email", "Your Email"));
		$form->add(new TextField("phone", "Phone Number"));
		$form->add(new ContentEditor("content", "Message"));
		return Component::get("OpenLaunch.Contact", $form->getHtml());
	}

	public function renderAdmin($page) {
		$form = new Form("contact-page-type");
		$form->add(new CheckboxField("name", "Ask for Name"));
		$form->add(new CheckboxField("email", "Ask for Email"));
		$form->add(new CheckboxField("phone", "Ask for Phone"));
		$form->add(new CheckboxField("address", "Ask for Address"));
		return Component::get("OpenLaunch.StructureContactPage", array("form" => $form->getHtml()));
	}

}