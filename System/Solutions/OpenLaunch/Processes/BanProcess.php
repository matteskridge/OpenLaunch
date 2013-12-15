<?php

class BanProcess {
	public function run($name) {
		if ($name == "platform.start.9") {
			$this->checkBan();
		}
	}

	public function checkBan() {
		if (Session::loggedIn() && Session::getPerson()->get("ban")) {
			$content = Component::get("OpenLaunch.ResolutionBan");
			Response::html(Component::get("OpenLaunch.ResolutionWrap", $content), true);
		}
	}
}
