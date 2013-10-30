<?php

class CaptchaField extends InputField {
	public function getHtml() {
		return "<label>Human Verification:</label>".
			   "<div class='captcha-wrap'><div class='captcha'><img src='/securimage_show.php' /></div>".
			   "<div class='captcha-input'><input type='text' name='$this->id' value='$this->value' /></div></div>";
	}

	public function isValid($data = "", $requirement = "") {
		$securimage = new Securimage();
		return $securimage->check($_POST[$this->id]);
	}
}