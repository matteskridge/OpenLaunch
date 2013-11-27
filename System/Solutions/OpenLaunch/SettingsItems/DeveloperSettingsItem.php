<?php

class DeveloperSettingsItem extends SettingsItem {
    public function getName() {
        return "Developer";
    }

    public function getContent() {
        if (isset($_GET["recache"]) && $_GET["recache"] == session_id()) {
            ThemeProcess::resetStyleCache();
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