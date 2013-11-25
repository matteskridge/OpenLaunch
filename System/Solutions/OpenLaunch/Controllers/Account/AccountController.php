<?php

class AccountController extends AppController {

	public function index() {

	}

	public function access() {

	}

	public function openid($who = "google") {
		$data = OpenID::client($who);
		if (is_array($data)) {
			$check = new Person(array("email" => $data["email"]));
			if ($check->exists()) {
				$check->set("openid", $openid->identity);
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

