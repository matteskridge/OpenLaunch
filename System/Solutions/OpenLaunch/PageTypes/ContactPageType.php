<?php

class ContactPageType extends PageType {
	public function getIcon() {
		return "/Images/Flat/IconFinder/Email.png";
	}

	public function getName() {
		return "Contact Form";
	}

	public function render($page) {
		$contact = new ContactForm(array("page" => $page));
		
		$form = new Form("contact");
		if (!$contact->exists() || $contact->get("askname")) $form->add(new TextField("name", "Your Name"));
		if (!$contact->exists() || $contact->get("askemail")) $form->add(new TextField("email", "Your Email"));
		if (!$contact->exists() || $contact->get("askphone")) $form->add(new TextField("phone", "Phone Number"));
		if (!$contact->exists() || $contact->get("askcomment")) $form->add(new ContentEditor("content", "Message"));
		$form->controls("Communication");
		return Component::get("OpenLaunch.Contact", $form->getHtml());
	}

	public function renderAdmin($page) {
		$contact = new ContactForm(array("page" => $page));
		if (!$contact->exists()) $contact = "ContactForm";
		
		$form = new Form("contact-page-type");
		$form->add(new HiddenField("page", "Page", $page));
		$form->add(new CheckboxField("askname", "Ask for Name"));
		$form->add(new CheckboxField("askemail", "Ask for Email"));
		$form->add(new CheckboxField("askphone", "Ask for Phone"));
		$form->add(new CheckboxField("askaddress", "Ask for Address"));
		$form->add(new CheckboxField("askcomment", "Ask for Comment"));
		$form->controls($contact);
		
		if ($form->sent()) {
			return new Redirect("/admin/index/structure/page/".$page->get("id")."/");
		}
		
		return Component::get("OpenLaunch.StructureContactPage", array("form" => $form->getHtml()));
	}

}