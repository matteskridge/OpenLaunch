<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class ContentField extends InputField {
    public function getHtml() {
        $text = "<label for='$this->id'>$this->display</label>";
        $text .= "<textarea id='$this->id' name='$this->id'>$this->value</textarea>";

        return $text;
    }
}