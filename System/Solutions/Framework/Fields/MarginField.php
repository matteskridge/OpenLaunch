<?php

class MarginField extends SelectField {
	public function init() {
		for ($i = -30; $i < 30; $i++) {
			$this->options[$i] = $i." pixels";
		}
	}
}