<?php

class Page extends Model {
	public function getStructure() {
		return array(
			"name" => "string",
			"website" => "Website",
			"parent" => "Page",
			"menu" => "boolean",
			"home" => "boolean",
			"order" => "integer",
			"template" => "string",
			"can" => "list",
			"link" => "string",
			"html" => "string+"
		);
	}

	public function getHtml() {
		return $this->getType()->render($this);
	}

	public function getManagement() {
		$website = Website::getWebsite();
		$type = $website->get("type");

		$system = Website::getTypes();
		foreach ($system as $sys) {
			if ($sys->getId() == $type) {
				$system = $sys;
				break;
			}
		}

		if (is_array($system)) {
			return new NotFoundError();
		} else {
			return $system->managePage($this);
		}
	}

	private static $menuItems = array();
	public static function getMenuItems($level = 0, $page = null) {
		if (array_key_exists($level, self::$menuItems[$page])) return self::$menuItems[$page][$level];

		if ($page == null) {
			$pageid = 0;
			$page = null;
		} else {
			$chain = array();
			while ($page->getParent() != null && $page->getParent()->exists() && $page->getParent()->get("id") != "0") {
				array_unshift($chain, $page);
				$page = $page->get("parent");
			}

			if (array_key_exists($level, $chain)) {
				$pageid = $chain[$level]->get("id");
				$page = $chain[$level];
			} else {
				$pageid = $page->get("id");
			}
		}

		$pages = Page::findAll("Page", array("parent" => $pageid), "`order`, `id`");
		if ($page != null && (count($pages) > 0 || Session::isEditing())) array_unshift($pages, $page);

		$new = array();
		foreach ($pages as $p) if ($p->canView()) array_push($new, $p);

		self::$menuItems[$page][$level] = $new;
		return $new;
	}

	public function hasMenu($level) {
		return count(Page::getMenuItems($level, $this)) > 0;
	}

	public static function getMenuHtml($level = 0, $page = null) {
		$items = self::getMenuItems($level, $page);
		$text = "";

		foreach ($items as $item) $text .= Component::get("CreationShare.PageMenuItem", array(
			"page" => $item
		));

		return Component::get("CreationShare.PageMenu", array(
			"content" => $text,
			"number" => count($items),
			"pageid" => ($page instanceof Page)?$page->get("id"):0
		));
	}

	private $parent;
	public function getParent() {
		if ($this->parent == null) $this->parent = $this->get("parent");
		return $this->parent;
	}

	public function getUrl() {
		if ($this->get("link") != "") {
			return "/".$this->get("link")."/";
		} else return "/page/".$this->get("id")."/";
	}
	
	public function getLink() {
		return $this->getUrl();
	}

	private static $page;
	public static function getPage() {
		return self::$page;
	}

	public static function setPage($page) {
		self::$page = $page;
	}

	public function canView($person = null) {
		$can = $this->get("can");
		if (!$this->exists()) return false;

		if ($can == array()) return true;
		if (!Session::loggedIn()) return false;
		if ($person == null) $person = Session::getPerson();

		$groups = $person->get("roles");

		foreach ($can as $item) {
			foreach ($groups as $role) {
				if ($role == $item) return true;
			}
		}

		return false;
	}
	
	public function getType() {
		$types = PageType::getTypes();
		foreach ($types as $type) {
			if (get_class($type) == $this->get("template")) return $type;
		}
		return null;
	}
	
	public function getIcon() {
		$type = $this->getType();
		
		if ($this->get("home")) return "/Images/Flat/IconFinder/Home.png";
		return ($type == null) ? "/Images/Flat/IconFinder/Add.png" : $type->getIcon();
	}
}