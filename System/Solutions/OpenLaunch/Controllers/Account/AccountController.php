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

	}

	public function openid($who = "google") {
		$data = OpenID::client($who);
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
		return new Redirect("/");
	}

}

