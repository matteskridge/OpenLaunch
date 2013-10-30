<?php

class AdminController extends AppController {
	public function index($app = "", $action = "", $id = "", $mode = "") {
		$item = ControlItem::get($app);
		if ($item != null && $item->canView()) {
			return $item->getHtml($action, $id, $mode);
		}
		return new NotFoundError();
	}
}