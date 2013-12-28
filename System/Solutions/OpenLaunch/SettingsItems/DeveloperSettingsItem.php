<?php

class DeveloperSettingsItem extends SettingsItem {
    public function getName() {
        return "Developer";
    }

    public function getContent() {
        if (isset($_GET["recache"]) && $_GET["recache"] == session_id()) {
            ThemeProcess::resetStyleCache();
			return new Redirect("/".Request::getUrl());
        } else if (isset($_GET["cache"]) && $_GET["cache"] == session_id()) {
			Settings::set("website.nocache", "false");
			return new Redirect("/".Request::getUrl());
		} else if (isset($_GET["nocache"]) && $_GET["nocache"] == session_id()) {
			Settings::set("website.nocache", "true");
			return new Redirect("/".Request::getUrl());
		} else if (isset($_GET["dbrebuild"]) && $_GET["dbrebuild"] == session_id()) {
			$objects = Platform::getSolutionObjects("Models");
			foreach ($objects as $model) {
				$sql = Database::execute($model->getTableSQL());
			}
		}
        return Component::get("OpenLaunch.SettingsDeveloper");
    }

    public function getOrder() {
        return 600;
    }

    public function can() {
        return Permission::can("SettingsDeveloper");
    }

}