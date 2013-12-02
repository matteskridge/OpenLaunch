<?php

class AccountController extends AppController {

	public function index() {
		if (!Session::loggedIn()) {
			return new Redirect("/account/access/");
		}

		$this->items = Platform::getSolutionObjects("AccountPanelItems");
	}

	public function panel($panel, $action) {
		$args = array();
		$items = Platform::getSolutionObjects("AccountPanelItems");

		foreach ($items as $item) {
			if ($item->getId() == $panel) {
				$this->panel = $item;
				$this->content = $item->getContent($action, $args);
				if ($this->content instanceof Redirect) return $this->content;
				return;
			}
		}
		return new NotFoundError();
	}

	public function access() {
		$signup = new Form("signup");
		$signup->add(new TextField("email", "Email Address", "", array("email")));
		$signup->add(new TextField("nickname", "You Name", "", array("noempty")));
		$signup->add(new PasswordField("password", "Password", array("noempty")));
		$signup->add(new PasswordField("confirm", "Confirm", "", array("noempty", "equals:password")));
		$signup->add(new CaptchaField("captcha", "CAPTCHA", ""));
		$this->signup = $signup->getHtml();
        //print_r($signup->getData());

		if ($signup->sent() && $signup->get("password") == $signup->get("confirm")) {
			$check = new Person(array("email" => $signup->get("email")));
			if (!$check->exists()) {
				$person = Person::create("Person", $signup->getData());
				$person->setPassword($signup->get("password"));
				Session::login($person);
				return new Redirect();
			} else {
				Response::flash("An account already exists with the email address ".$signup->get("email"));
			}
		}

		$signin = new Form("signin");
		$signin->add(new TextField("email", "Email Address", ""));
		$signin->add(new PasswordField("password", "Password", ""));
		$this->signin = $signin->getHtml();

		if ($signin->sent()) {
			$person = new Person(array("email" => $signin->get("email")));
			if ($person->get("openid") == "" && $person->checkPassword($signin->get("password"))) {
				Session::login($person);
			}
			return new Redirect();
		}
	}

	public function openid($who = "google") {
		$data = OpenID::client($who, "account/openid/");
		if (is_array($data)) {
			$check = new Person(array("email" => $data["email"]));
			if ($check->exists()) {
				$check->set("openid", $data["openid"]);
				Session::login($check);
			} else {
				Session::login(Person::create("Person", $data));
			}
		} else {
			return $data;
		}
	}

	public function signout() {
		Session::logout();
		return new Redirect();
	}

}

