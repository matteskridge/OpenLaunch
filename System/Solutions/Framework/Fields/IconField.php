<?php

class IconField extends InputField {
	public function getHtml() {
        $text = "";

        if ($this->display)
            $text .= "<label for='$this->id'>$this->display</label>";

        $text .= "<div class='listboxwrap'><div class='listboxmain iconbox'>".
				"<div class='icontext'><input type='text' name='$this->id' id='$this->id' value='$this->value' /></div>";
		$dir = new File("Public/Images/Public");
		$size = 64;
        foreach ($dir->listSubs() as $key => $file) {
            $text .= "<img src='Public/Images/Public/".$file->getName()."' onclick=\"$('#$this->id').val($(this).attr('src'));\" style='width:$size;height:$size;' />";
        }
        $text .= "</div></div>";
        return $text;
	}
}