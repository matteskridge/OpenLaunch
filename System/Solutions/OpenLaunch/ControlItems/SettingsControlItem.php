<?php

class SettingsControlItem extends ControlItem {

	public function canView() {
		return true;
	}

	public function getName() {
		return "Settings";
	}

	public function getContent($action, $id, $mode) {

		$content = "";

		foreach (SettingsItem::listAll() as $item) {
			if ($action == $item->getId()) {
				$content = $item->getContent();
			}
		}

		if ($content == "")
			$content = Component::get("OpenLaunch.System");

		if ($content instanceof Redirect)
			return $content;

		return Component::get("OpenLaunch.Settings", $content);
	}

	public function getMenu() {
		$arr = array();
		foreach (SettingsItem::listAll() as $item) {
			$arr[$item->getId()] = $item->getName();
		}
		return $arr;
	}

	public function getOrder() {
		return 500;
	}

}

