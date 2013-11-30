<?php

abstract class PageType {
    
    public abstract function getName();
    public abstract function getIcon();
    public abstract function render($page);
    public abstract function renderAdmin($page);
	public function getDescription() { return "No Description."; }

	public function getId() {
		return get_class($this);
	}

	public static function getTypes() {
		$arr = array();
		
		foreach (Platform::getSolutions("PageTypes") as $solution) {
			foreach ($solution->getFile()->listSubs() as $file) {
				$file->import();
				$classname = $file->getExtensionlessName();
				$obj = new $classname();
				array_push($arr, $obj);
			}
		}
		
		return $arr;
	}
	
}