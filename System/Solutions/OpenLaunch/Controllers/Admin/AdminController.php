<?php

class AdminController extends AppController {
	public function index($app = "", $action = "", $id = "", $mode = "") {
		$item = ControlItem::get($app);
		if ($item != null && $item->canView()) {
			$html = $item->getHtml($action, $id, $mode);
			return $html;
		}
		return new NotFoundError();
	}
}