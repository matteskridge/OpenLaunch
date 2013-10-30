<?php

class RoleField extends SelectField {
	public function init() {
		$items = array();

		foreach (Role::findAll("Role") as $key => $value) {
			$items[$value->get("id")] = $value->get("name");
		}

		$this->options = $items;
	}

	public function getValue() {
		return new Role(parent::getValue());
	}
}