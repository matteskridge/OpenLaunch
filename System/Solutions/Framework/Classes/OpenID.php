<?php

class OpenID {

	public static function client($who) {
		$url = "";
		$openid = new LightOpenID(Request::getDomain());

		if ($who == "google") {
			$url = 'https://www.google.com/accounts/o8/id';
			$openid->required = array('namePerson/first', 'contact/email', "namePerson/last");
		} else if ($who == "yahoo") {
			$url = "https://me.yahoo.com/";
			$openid->required = array("namePerson", "contact/email");
		} else if ($who == "aol") {
			$url = "http://aol.com/";
			$openid->required = array('namePerson', 'contact/email', "namePerson/friendly");
		} else {
			return new NotFoundError();
		}

		if (!$openid->mode) {
			$openid->identity = $url;

			return new Redirect($openid->authUrl());
		} else if ($openid->mode != "cancel" && $openid->validate()) {
			$attributes = $openid->getAttributes();

			if (class_exists("Person"))
				$person = new Person(array("openid" => $openid->identity));

			if (isset($person) && $person->exists()) {
				Session::login($person);
			} else {
				$data = array(
					"roles" => Role::findAll("Role", array("allmembers" => "1")),
					"openid" => $openid->identity
				);

				if ($who == "google") {
					$data["first"] = $attributes["namePerson/first"];
					$data["last"] = $attributes["namePerson/last"];
					$data["email"] = $attributes["contact/email"];
					$data["nickname"] = $attributes["namePerson/first"] . " " . ucfirst(substr($attributes["namePerson/last"], 0, 1));
				} else if ($who == "yahoo") {
					$data["nickname"] = $attributes["namePerson"];
					$data["email"] = $attributes["contact/email"];
				} else if ($who == "aol") {
					$bits = explode("@", $attributes["contact/email"]);
					$data["email"] = $attributes["contact/email"];
					$data["nickname"] = $bits[0];
				} else {
					$bits = explode("@", $attributes["contact/email"]);
					$data["email"] = $attributes["contact/email"];
					$data["nickname"] = $bits[0];
				}

				$data["confirmed"] = "1";
				$data["openid"] = $openid->identity;
				if ($data["email"] == "") {
					return new Redirect("/");
				}

				return $data;
			}

			return new Redirect((isset($_GET["return"]) ? $_GET["return"] : "/"));
		} else {
			return new NotFoundError();
		}
	}

}

