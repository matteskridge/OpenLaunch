<?php

class BanProcess {
	public function run($name) {
		if ($name == "platform.start.9") {
			$this->checkBan();
		}
	}

	public function checkBan() {
		if (Session::loggedIn()) {
			if (Session::getPerson()->get("ban")) {
				$content = Component::get("OpenLaunch.ResolutionBan");
				Response::html(Component::get("OpenLaunch.ResolutionWrap", $content), true);
			}

			$penalties = Penalty::findAll("Penalty", array(
				"user" => Session::getPerson(),
				"revoked" => "0"
			));

			foreach ($penalties as $penalty) {
				if ($penalty->get("warning") && !$penalty->get("read")) {
					$form = new Form("warn");
					$form->add(new CaptchaField("captcha", "Confirm"));
					if ($form->sent()) {
						$penalty->set("read", "1");
						return new Redirect(Request::getBase());
					}

					$content = Component::get("OpenLaunch.ResolutionWarning", array("warn" => $penalty, "form" => $form->getHtml()));
					Response::html(Component::get("OpenLaunch.ResolutionWrap", $content), true);
				} else if ($penalty->get("suspension") && $penalty->get("expires") > time()) {
					$content = Component::get("OpenLaunch.ResolutionSuspend", array("suspend" => $penalty));
					Response::html(Component::get("OpenLaunch.ResolutionWrap", $content), true);
				}
			}
		}
	}
}
