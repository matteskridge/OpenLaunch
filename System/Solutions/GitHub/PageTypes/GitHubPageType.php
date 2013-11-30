<?php

class GitHubPageType extends PageType {
	public function getName() {
		return "GitHub Project";
	}

	public function getDescription() {
		return "A summary of a GitHub project.";
	}

	public function getIcon() {
		return "/Images/Flat/IconFinder/Settings.png";
	}

	public function render($page) {
		$project = new GitHubProject(array("page"=>$page));
		$project->maybeUpdate();
		return Component::get("GitHub.Project", array(
			"page" => $page,
			"project" => $project
		));
	}

	public function renderAdmin($page) {
		$find = new GitHubProject(array("page" => $page));
		if ($find->exists()) {
			$gh = $find;
			$gh->maybeUpdate();
		} else {
			$gh = "GitHubProject";
		}

		$form = new Form("github");
		$form->add(new TextField("githubuser", "GitHub Username", ""));
		$form->add(new TextField("githubproject", "GitHub Project", ""));
		$form->add(new TextField("production", "Production Branch", ""));
		$form->add(new TextEditor("content", "Content", ""));
		$form->add(new HiddenField("page", "Page", $page));
		$form->controls($gh);

		if ($form->sent()) {
			return new Redirect("/admin/index/structure/");
		}

		return "<div class='admin-entry'><div class='admin-entry-inner'>".$form->getHtml()."</div></div>";
	}
}