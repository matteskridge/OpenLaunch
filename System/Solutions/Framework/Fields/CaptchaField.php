<?php

class CaptchaField extends InputField {
    protected $v = null;

	public function getHtml() {
		return "<label>Human Verification:</label>".
			   "<div class='captcha-wrap'><div class='captcha'><img src='securimage_show.php' /></div>".
			   "<div class='captcha-input'><input type='text' name='$this->id' value='$this->value' /></div></div>";
	}

	public function isValid($data = "", $requirement = "") {
        if ($this->v != null) return $this->v;
		require_once("System/Libraries/SecureImage/securimage.php");
		$securimage = new Securimage();
		$this->v = $securimage->check($data);
        return $this->v;
	}
}