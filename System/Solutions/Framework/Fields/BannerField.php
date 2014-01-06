<?php

class BannerField extends InputField {
	public function getHtml() {
		$html = "<label>$this->display</label>";
		$html .= "<div class='form-bannerfield'>";

		$html .= "<div class='form-bannerfield-type'>";
		$html .= "<div class='form-bannerfield-type-name'>Format:</div>";
		$html .= "<div class='form-bannerfield-type-name'><select><option value=''>No Banner</option><option value='text'>Text</option><option value='icon'>Text & Icon</optiom></option></select></select></div>";
		$html .= "</div>";

		$html .= "</div>";
		return $html;
	}
}
