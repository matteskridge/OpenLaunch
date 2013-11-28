<?php

class MainAccountPanelItem extends AccountPanelItem {
	public function getName() {
		return "Account Settings";
	}

	public function getIcon() {
		return "/Images/Flat/IconFinder/Person.png";
	}

	public function getMenu() {
		return array(
			"name" => "Change Name",
			"openid" => "Change Sign-In",
			"email" => "Change Email",
			"phone" => "Change Phone Number",
			"address" => "Change Address",
			"profile" => "Change Profile",
			"avatar" => "Change Avatar",
			"view" => "View Profile"
		);
	}

	public function getContent($action, $args) {
		if ($action == "name") {
			return $this->name();
		} else if ($action == "email") {
			return $this->email();
		} else if ($action == "phone") {
			return $this->phone();
		} else if ($action == "address") {
			return $this->address();
		} else if ($action == "profile") {
			return $this->profile();
		} else if ($action == "view") {
			return new Redirect("/profile/".Session::getPerson()->getId()."/");
		}
	}

	private function name() {
		$form = new Form("person");
		$form->add(new TextField("nickname", "Display Name", ""));
		$form->controls(Session::getPerson());
		if ($form->sent()) return new Redirect("/account/");
		return $form->getHtml();
	}

	private function email() {
		$form = new Form("person");
		$form->add(new TextField("email", "Email Address", ""));
		$form->controls(Session::getPerson());
		if ($form->sent()) return new Redirect("/account/");
		return $form->getHtml();
	}

	private function phone() {
		$form = new Form("person");
		$form->add(new TextField("phone", "Phone Number", ""));
		$form->controls(Session::getPerson());
		if ($form->sent()) return new Redirect("/account/");
		return $form->getHtml();
	}

	private function address() {
		$form = new Form("person");
		$form->add(new TextField("address", "Street Address", ""));
		$form->add(new TextField("suite", "Address Line 2", ""));
		$form->add(new TextField("city", "City", ""));
		$form->add(new TextField("province", "State / Province", ""));
		$form->add(new TextField("country", "Country", ""));
		$form->add(new TextField("zip", "Zip Code", ""));
		$form->controls(Session::getPerson());
		if ($form->sent()) return new Redirect("/account/");
		return $form->getHtml();
	}

	private function profile() {
		$form = new Form("person");
		$form->add(new TextEditor("profile", "Profile", ""));
		$form->controls(Session::getPerson());
		if ($form->sent()) return new Redirect("/account/");
		return $form->getHtml();
	}
}