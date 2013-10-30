<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class TextEditor extends InputField {
    public function getHtml() {
        return Component::get("CreationShare.Editor", array("id" => $this->id, "value" => $this->value));
    }
}