<?php

class DatabasePageType extends PageType {
	public function getName() {
		return "Database";
	}

	public function getIcon() {
		return "Images/Flat/IconFinder/Statistics.png";
	}

	public function getDescription() {
		return "A collection of user-submitted entries.";
	}

	public function render($page) {
		$categories = DatabaseCategory::findAll("DatabaseCategory", array("page" => $page));

		switch (Response::getArg(1)) {
			case "view":
				$content = Component::get("OpenLaunchDatabase.View");
				break;
			default:
				$content = Component::get("OpenLaunchDatabase.Home", array(
					"categories" => $categories
				));
				break;
		}
		return Component::get("OpenLaunchDatabase.Wrap", array(
			"page" => $page,
			"content" => $content
		));
	}


	public function renderAdmin($page) {
		$categories = DatabaseCategory::findAll("DatabaseCategory", array("page" => $page));

		if (isset($_GET["create"])) {
			$form = new Form("create");
			$form->add(new TextField("name", "Name"));
			$form->add(new HiddenField("page", "Page", $page));
			$form->controls("DatabaseCategory");
			return "<div class='admin-structure-settings-main'>".$form->getHtml()."</div>";
		} else {
			return Component::get("OpenLaunchDatabase.Admin", array(
				"categories" => $categories,
				"page" => $page
			));
		}

	}
}
