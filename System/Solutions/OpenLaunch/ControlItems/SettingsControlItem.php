<?php

class SettingsControlItem extends ControlItem {

	public function canView() {
		return $this->getMenu() != array();
	}

	public function getName() {
		return "Settings";
	}

	public function getContent($action, $id, $mode) {

		$content = "";

		foreach (SettingsItem::listAll() as $item) {
			if ($action == $item->getId() && $this->inMenu($action)) {
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
			if (!$item->can())
				continue;
			$arr[$item->getId()] = $item->getName();
		}
		return $arr;
	}

	public function getOrder() {
		return 500;
	}

}

