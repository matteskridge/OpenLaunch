<?php

class Action {
	private $view, $vars;

	public function run($name) {
		if ($name == "platform.main.5") {
			$this->runAction();
		}
	}

	public function runAction() {
		if (Request::noController()) return;
		$controller = Controller::getController();
		$action = Response::getAction();

		if (method_exists($controller, $action)) {
			if (strstr($action, "_")) {
				Response::notFound();
				return;
			}

			$args = Response::getArgs();
			$actionArgs = "";
			$first = true;

			foreach ($args as $key => $arg) {
				if (!$first) $actionArgs .= ", ";
				$actionArgs .= "\$args[\"$key\"]";
				$first = false;
			}

			eval("\$response = \$controller->$action($actionArgs);");
			//$response = $controller->$action();
			$this->vars = get_object_vars($controller);

			if (is_string($response)) {
				Response::ajax($response);
			} else if ($response instanceof NotFoundError) {
				Response::notFound();
			} else if ($response instanceof Redirect) {
				Response::redirect($response);
			} else {
				$view = Controller::getView($action);
				if ($view->exists()) {
					$this->view = $view;
					$this->executeView();
				} else {
					Response::notFound();
				}
			}
		}
	}

	public function executeView() {
		foreach ($this->vars as $cs_key => $cs_value) {
			eval("$$cs_key = \$cs_value;");
		}

		ob_start("ob_error_handler");
		@include($this->view->getPath());

		$layout = new File($this->view->getParent()->getSub("layout.master.php"));
		if ($layout->exists()) {
			$content = ob_get_clean();
			ob_start("ob_error_handler");
			@include($layout->getPath());
			Response::html(ob_get_clean(), true);
		} else {
			Response::html(ob_get_clean());
		}

	}
}