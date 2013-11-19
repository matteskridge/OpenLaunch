<?php

class ThemeController extends AppController {
	public function info($id) {
		foreach (ThemeProcess::getThemes() as $theme) {
			if ($theme->getId() == $id) {
				return Component::get("OpenLaunch.ThemeInfo", array("theme" => $theme));
			}
		}
		
		return "Theme not found";
	}
}