<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class CheckboxField extends InputField {
    public function getHtml() {
        $text = "<label for='$this->id' name='$this->id'>$this->display</label>";
        $checked = ($this->value)? "checked='yes' ": "";

        $text .= "<script type='text/javascript'>\n".
                 "$(document).ready(function() {\n".
                 "  $('#".$this->id."').iphoneStyle({checkedLabel: 'YES', uncheckedLabel: 'NO'});\n".
                 "});</script>";

        $text .= "<div style='display:inline-block;vertical-align:middle;'><input type='checkbox' id='$this->id' name='$this->id' ".
                 "value='1' $checked/></div>";

        return $text;
    }

    public function getValue() {
        return isset($_POST[$this->id]) && $_POST[$this->id] == "1";
    }
}