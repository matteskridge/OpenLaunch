<?php

class TextEditor extends InputField {
    public function getHtml() {
        return Component::get("OpenLaunch.RichTextEditor", array("id" => $this->id, "value" => Parser::parse($this->value)));
    }
}