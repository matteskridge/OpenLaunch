<?php

class LinkTextField extends TextField {
	public function init() {
		$this->start = "http://".Request::getDomain()."/";
		$this->end = "/";
	}
}