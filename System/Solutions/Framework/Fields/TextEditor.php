<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class TextEditor extends InputField {
    public function getHtml() {
        return Component::get("OpenLaunch.RichTextEditor", array("id" => $this->id, "value" => $this->value));
    }
}