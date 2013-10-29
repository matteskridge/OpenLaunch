<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class SliderField extends InputField {
    public function getHtml() {
        $text = "<label for='$this->id'>$this->display</label>";
        $text .= "<input type='text' name='$this->id' id='$this->id' value='$this->value' size='2' readonly='yes' /><div id='$this->id-slider' style='width:450px;display:inline-block;'></div>";

        $text .= "<script type='text/javascript'>$(document).ready(function(){\n";
        $text .= "var val = $('#$this->id').val();";
        $text .= "$('#$this->id-slider').slider({min:0,max:100,value:val,slide:function(ev,ui) {\n";
        $text .= "$('#$this->id').val(ui.value);\n";
        $text .= "}});\n});</script>";

        return $text;
    }
}