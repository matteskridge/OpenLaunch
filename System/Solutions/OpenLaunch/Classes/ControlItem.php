<?php

abstract class ControlItem {

	abstract function getName();

	abstract function getOrder();

	abstract function canView();

	public function getDescription() {
		return "No Description";
	}

	function getId() {
		return strtolower(str_replace("ControlItem", "", get_class($this)));
	}

	function getLink() {
		return "/admin/index/" . $this->getId() . "/";
	}

	function getHeader() {
		return array(
			"title" => "CreationShare Control Panel",
			"content" => "The CreationShare Platform allows you to publish websites and collaborate online. " .
			"With the click of a mouse, you can have an easy to use website for yourself, your " .
			"company, or your professional practice. The control panel allows you to edit " .
			"your website, manage user accounts, and view statistics. To access the control panel, " .
			"use one of the many links at the top of the page when signed in as an administrator.",
			"icon" => "/Images/CreationShareIcon.png"
		);
	}

	public function getHeaderName() {
		if (method_exists($this, "getHeaderForceName"))
			return $this->getHeaderForceName();
		$h = $this->getHeader();
		if (array_key_exists("title", $h) && $h["title"] != "CreationShare Control Panel") {
			return $h["title"];
		}
		else
			return $this->getName();
	}

	public function getIcon() {
		if (method_exists($this, "getHeaderIcon"))
			return $this->getHeaderIcon();
		$h = $this->getHeader();
		if (array_key_exists("icon", $h)) {
			return $h["icon"];
		}
		else
			return "";
	}

	public function getMenu() {
		return array();
	}

	function getContent($action, $id, $mode) {
		return "";
	}

	function getHtml($action, $id, $mode) {
		$content = $this->getContent($action, $id, $mode);
		if ($content instanceof Redirect)
			return $content;

		return Component::get("OpenLaunch.ControlPanel", array(
					"header" => $this->getHeader(),
					"content" => $content,
					"id" => $this->getId(),
					"item" => $this,
					"menu" => $this->getMenu(),
					"action" => $action,
					"object" => $id,
					"mode" => $mode
		));
	}

	function isSelected() {
		$controller = Response::getController();
		return (Response::getController() == "admin" &&
				Response::getAction() == "index" &&
				Response::getArg(0) == $this->getId());
	}

	static function listItems($max = 6) {
		$arr = array();
		foreach (Platform::getSolutions("ControlItems") as $solution) {
			foreach ($solution->getFile()->listSubs() as $item) {
				$item->import();
				$classname = $item->getExtensionlessName();
				$obj = new $classname();

				if ($obj->canView())
					array_push($arr, $obj);
			}
		}

		usort($arr, "sortByOrder");

		$i = 0;
		$new = array();
		foreach ($arr as $item) {
			if ($i > $max)
				break;
			array_push($new, $item);
			$i++;
		}

		return $new;
	}

	static function get($name) {
		foreach (self::listItems(99999) as $item) {
			if ($item->getId() == $name)
				return $item;
		}
		return null;
	}

	public function inMenu($item) {
		if ($item == "")
			$item = "index";
		return array_key_exists($item, $this->getMenu());
	}

}

