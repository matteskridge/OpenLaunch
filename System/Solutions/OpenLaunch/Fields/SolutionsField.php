<?php

class SolutionsField extends ListField {
	public function init() {
		$file = new File("System/Solutions");
		$arr = array();

		foreach ($file->listSubs() as $item) {
			$arr[$item->getName()] = $item->getName();
		}

		$this->options = $arr;
	}
}