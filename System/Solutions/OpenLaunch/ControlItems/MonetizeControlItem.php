<?php

class MonetizeControlItem extends ControlItem {

	function getName() {
		return "Monetization";
	}

	public function getContent($action, $id, $mode) {

		if (!$this->inMenu($action))
			return;

		if ($action == "store") {
			$content = Component::get("OpenLaunch.MonetizeStore");
		} else if ($action == "ads") {
			$content = Component::get("OpenLaunch.MonetizeAdvertisements");
		} else {
			$content = Component::get("OpenLaunch.MonetizeSummary");
		}

		if ($content instanceof Redirect || $content instanceof NotFoundError) {
			return $content;
		}
		return Component::get("OpenLaunch.Monetize", $content);
	}

	public function getMenu() {
		$arr = array();

		if (Permission::can("EditWebsite"))
			$arr["store"] = "Online Store";

		if (Permission::can("EditWebsite"))
			$arr["ads"] = "Advertisements";

		if (count($arr) != 0) {
			$arr = array("index" => "Summary") + $arr;
		}

		return $arr;
	}

	function getOrder() {
		return 300;
	}

	function canView() {
		return $this->getMenu() != array();;
	}
}