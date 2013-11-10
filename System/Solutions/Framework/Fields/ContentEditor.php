<?php

/* =================================
 * CreationShare Platform
 * 
 * (c) CreationShare Technology LLC
 * =================================
 */

class ContentEditor extends InputField {
	public function getHtml() {
		$label = "<label for='$this->id'>$this->display</label><div style='width:75%;display:inline-block;margin-bottom:10px;'>";
		return $label.Component::get("OpenLaunch.RichTextEditor", array("id" => $this->id, "value" => $this->value))."</div>";
	}
}