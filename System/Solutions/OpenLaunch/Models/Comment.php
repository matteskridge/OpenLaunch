<?php

class Comment extends Model {
	public function getStructure() {
		return array(
			"modeltype" => "string",
			"model" => "integer",
			"user" => "Person",
			"content" => "string",
			"hidden" => "boolean",
			"locked" => "boolean",
			"element" => "PageElement"
		);
	}
	
	public static function post($model, $data) {
		$model->modified();
		$data["modeltype"] = get_class($model);
		$data["model"] = $model->get("id");
		if (array_key_exists("element", $model->getStructure())) {
			$data["element"] = $model->get("element");
		}
		return Comment::create("Comment", $data);
	}

	public static function getComments($model, $locked = false) {
		$form = new Form("add-comment");
		$form->add(new HiddenField("user", "User", Session::getPerson()));
		$form->add(new TextEditor("content", "Content"));

		if ($form->sent() && (!$locked || Permission::can("CommunityForumLock")) && Permission::can("Post")) {
			Comment::post($model, $form->getData());
		}

		$comments = Comment::findAll("Comment", array("modeltype" => get_class($model), "model" => $model));
		return Component::get("OpenLaunch.Comments", array("model" => $model, "comments" => $comments, "form" => $form->getHtml(), "locked" => $locked));
	}
}