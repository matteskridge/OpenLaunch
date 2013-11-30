<?php

class FeatureGalleryPageType extends PageType {

	public function getName() {
		return "Feature Gallery";
	}

	public function getDescription() {
		return "A gallery of images with a long description of each.";
	}

	public function getIcon() {
		return "";
	}

	public function render($page) {
		$items = FeatureGalleryCategory::findAll("FeatureGalleryCategory", array("page" => $page));
		return Component::get("OpenLaunchFeatureGallery.View", array(
			"page" => $page,
			"categories" => $items
		));
	}

	public function renderAdmin($page) {
		if (isset($_GET["item"])) {
			return $this->adminEntry($page);
		} else if (isset($_GET["category"])) {
			return $this->adminCategory($page);
		} else {
			return $this->adminIndex($page);
		}
	}

	private function adminIndex($page) {
		return Component::get("OpenLaunchFeatureGallery.Admin", array("page" => $page));
	}

	private function adminCategory($page) {
		$form = new Form("category");
		$form->add(new TextField("name", "Name"));
		$form->add(new HiddenField("page", "Page", $page));
		$form->controls("FeatureGalleryCategory");
		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId()."/");
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}

	private function adminEntry($page) {
		$form = new Form("entry");
		$form->add(new TextField("name", "Name"));
		$form->add(new AttachmentField("image", "Image", ""));
		$form->add(new TextEditor("description", "Description", ""));

		if ($_GET["category"] != "") {
			$category = new FeatureGalleryCategory($_GET["category"]);
			if (!$category->exists()) {
				return new NotFoundError();
			}
			$form->add(new HiddenField("category", "Category", $category));
		}

		if (isset($_GET["item"])) {
			$form->controls(new FeatureGalleryEntry($_GET["item"]));
		} else {
			$form->controls("FeatureGalleryEntry");
		}

		if ($form->sent()) return new Redirect("/admin/index/structure/page/".$page->getId()."/");
		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}
}